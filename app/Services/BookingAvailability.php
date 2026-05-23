<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingAvailability
{
    public const OPEN_HOUR = 10;

    public const CLOSE_HOUR = 20;

    public const SLOT_STEP_MINUTES = 15;

    public function availableSlots(string $date, Service $service, ?int $staffId = null): array
    {
        $duration = max(5, (int) $service->duration_minutes);
        $dayStart = Carbon::parse("{$date} ".sprintf('%02d:00', self::OPEN_HOUR));
        $dayEnd = Carbon::parse("{$date} ".sprintf('%02d:00', self::CLOSE_HOUR));

        $booked = $this->bookedAppointmentsForDate($date);
        $eligibleStaff = $this->eligibleStaffFor($service);
        $equipment = $this->equipmentForService($service);
        $slots = [];

        for ($cursor = $dayStart->copy(); $cursor->lt($dayEnd); $cursor->addMinutes(self::SLOT_STEP_MINUTES)) {
            $slotEnd = $cursor->copy()->addMinutes($duration);
            if ($slotEnd->gt($dayEnd)) {
                break;
            }

            if (! $this->equipmentHasCapacity($booked, $equipment, $cursor, $slotEnd)) {
                continue;
            }

            if ($staffId) {
                if (! $this->staffFree($booked, $staffId, $cursor, $slotEnd)) {
                    continue;
                }
            } elseif (! $this->anyStaffFree($booked, $eligibleStaff, $cursor, $slotEnd)) {
                continue;
            }

            $slots[] = $cursor->format('H:i');
        }

        return $slots;
    }

    public function isSlotAvailable(string $date, string $time, Service $service, ?int $staffId = null): bool
    {
        $time = substr($time, 0, 5);

        return in_array($time, $this->availableSlots($date, $service, $staffId), true);
    }

    public function slotRejectionMessage(string $date, string $time, Service $service, ?int $staffId = null): string
    {
        $duration = max(5, (int) $service->duration_minutes);
        $start = Carbon::parse("{$date} {$time}");
        $end = $start->copy()->addMinutes($duration);
        $booked = $this->bookedAppointmentsForDate($date);
        $equipment = $this->equipmentForService($service);

        if ($equipment && ! $this->equipmentHasCapacity($booked, $equipment, $start, $end)) {
            $cap = max(1, (int) $equipment->capacity);

            return $cap === 1
                ? 'الجهاز غير متاح في هذا الوقت — اختاري وقتاً آخر من القائمة'
                : "الجهاز ممتلئ ({$cap} أماكن محجوزة في هذا الوقت) — اختاري وقتاً آخر";
        }

        if ($staffId && ! $this->staffFree($booked, $staffId, $start, $end)) {
            return 'الأخصائية غير متاحة في هذا الوقت — اختاري وقتاً آخر';
        }

        return 'هذا الوقت لم يعد متاحاً — اختاري وقتاً آخر من القائمة';
    }

    public function eligibleStaffFor(Service $service): Collection
    {
        $linked = $service->staff()->where('is_active', true)->get();

        if ($linked->isNotEmpty()) {
            return $linked;
        }

        return Staff::where('is_active', true)->orderBy('name')->get();
    }

    public function staffCanPerform(int $staffId, Service $service): bool
    {
        $linked = $service->staff()->where('staff.id', $staffId)->exists();

        if ($linked) {
            return true;
        }

        return $service->staff()->count() === 0;
    }

    private function bookedAppointmentsForDate(string $date): Collection
    {
        return Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['service:id,duration_minutes,equipment_id', 'staff:id'])
            ->get();
    }

    private function equipmentForService(Service $service): ?Equipment
    {
        if (! $service->equipment_id) {
            return null;
        }

        if ($service->relationLoaded('equipment') && $service->equipment) {
            return $service->equipment;
        }

        return Equipment::find($service->equipment_id);
    }

    private function anyStaffFree(Collection $booked, Collection $staff, Carbon $start, Carbon $end): bool
    {
        if ($staff->isEmpty()) {
            return true;
        }

        foreach ($staff as $member) {
            if ($this->staffFree($booked, $member->id, $start, $end)) {
                return true;
            }
        }

        return false;
    }

    private function staffFree(Collection $booked, int $staffId, Carbon $start, Carbon $end): bool
    {
        foreach ($booked as $appointment) {
            if ((int) $appointment->staff_id !== $staffId) {
                continue;
            }
            if ($this->intervalsOverlap($start, $end, $this->appointmentStart($appointment), $this->appointmentEnd($appointment))) {
                return false;
            }
        }

        return true;
    }

    /**
     * True if adding a booking at [start, end) stays within equipment capacity.
     */
    private function equipmentHasCapacity(Collection $booked, ?Equipment $equipment, Carbon $start, Carbon $end): bool
    {
        if (! $equipment) {
            return true;
        }

        $capacity = max(1, (int) $equipment->capacity);
        $equipmentId = $equipment->id;

        $events = [
            [$start->timestamp, 1],
            [$end->timestamp, -1],
        ];

        foreach ($booked as $appointment) {
            $apptEquipment = $appointment->equipment_id
                ?: $appointment->service?->equipment_id;

            if ((int) $apptEquipment !== (int) $equipmentId) {
                continue;
            }

            $aStart = $this->appointmentStart($appointment);
            $aEnd = $this->appointmentEnd($appointment);

            if (! $this->intervalsOverlap($start, $end, $aStart, $aEnd)) {
                continue;
            }

            $events[] = [$aStart->timestamp, 1];
            $events[] = [$aEnd->timestamp, -1];
        }

        usort($events, function (array $a, array $b) {
            if ($a[0] === $b[0]) {
                return $a[1] <=> $b[1];
            }

            return $a[0] <=> $b[0];
        });

        $concurrent = 0;
        $peak = 0;

        foreach ($events as [, $delta]) {
            $concurrent += $delta;
            $peak = max($peak, $concurrent);
        }

        return $peak <= $capacity;
    }

    private function appointmentStart(Appointment $appointment): Carbon
    {
        $time = substr((string) $appointment->appointment_time, 0, 5);

        return Carbon::parse($appointment->appointment_date->format('Y-m-d').' '.$time);
    }

    private function appointmentEnd(Appointment $appointment): Carbon
    {
        $minutes = $appointment->duration_minutes
            ?: $appointment->service?->duration_minutes
            ?: 60;

        return $this->appointmentStart($appointment)->copy()->addMinutes($minutes);
    }

    private function intervalsOverlap(Carbon $aStart, Carbon $aEnd, Carbon $bStart, Carbon $bEnd): bool
    {
        return $aStart->lt($bEnd) && $bStart->lt($aEnd);
    }
}
