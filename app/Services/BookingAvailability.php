<?php

namespace App\Services;

use App\Models\Appointment;
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

        $booked = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['service:id,duration_minutes,equipment_id', 'staff:id'])
            ->get();

        $eligibleStaff = $this->eligibleStaffFor($service);
        $slots = [];

        for ($cursor = $dayStart->copy(); $cursor->lt($dayEnd); $cursor->addMinutes(self::SLOT_STEP_MINUTES)) {
            $slotEnd = $cursor->copy()->addMinutes($duration);
            if ($slotEnd->gt($dayEnd)) {
                break;
            }

            if ($this->equipmentBlocked($booked, $service->equipment_id, $cursor, $slotEnd)) {
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

    private function equipmentBlocked(Collection $booked, ?int $equipmentId, Carbon $start, Carbon $end): bool
    {
        if (! $equipmentId) {
            return false;
        }

        foreach ($booked as $appointment) {
            $apptEquipment = $appointment->equipment_id
                ?: $appointment->service?->equipment_id;

            if ((int) $apptEquipment !== (int) $equipmentId) {
                continue;
            }

            if ($this->intervalsOverlap($start, $end, $this->appointmentStart($appointment), $this->appointmentEnd($appointment))) {
                return true;
            }
        }

        return false;
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
