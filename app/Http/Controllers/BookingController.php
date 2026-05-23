<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Services\GoHighLevelService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::active()->get();
        $servicesByCategory = $services->groupBy(fn ($s) => $s->category ?: 'other');
        $categoryLabels = Service::categoryLabels();
        $staff = Staff::where('is_active', true)->get();
        $selectedService = $request->get('service_id')
            ? Service::find($request->get('service_id'))
            : null;

        return view('booking', compact(
            'services',
            'servicesByCategory',
            'categoryLabels',
            'staff',
            'selectedService'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_phone'     => 'required|string|max:20',
            'client_email'     => 'nullable|email|max:255',
            'service_id'       => 'required|exists:services,id',
            'staff_id'         => 'nullable|exists:staff,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes'            => 'nullable|string|max:500',
        ], [
            'client_name.required'      => 'الاسم مطلوب',
            'client_phone.required'     => 'رقم الهاتف مطلوب',
            'service_id.required'       => 'يرجى اختيار الخدمة',
            'appointment_date.required' => 'يرجى اختيار التاريخ',
            'appointment_date.after_or_equal' => 'التاريخ يجب أن يكون اليوم أو بعده',
            'appointment_time.required' => 'يرجى اختيار الوقت',
        ]);

        $appointment = Appointment::create($validated);

        // Send to GoHighLevel
        try {
            $ghlService = new GoHighLevelService();
            $ghlContactId = $ghlService->createContact($appointment);
            $appointment->update(['ghl_contact_id' => $ghlContactId]);
            $ghlService->createAppointment($appointment);
        } catch (\Exception $e) {
            // GHL integration is optional - booking still saved locally
            \Log::warning('GHL sync failed: ' . $e->getMessage());
        }

        return redirect()->route('booking.success', $appointment->id);
    }

    public function success(Appointment $appointment)
    {
        return view('booking-success', compact('appointment'));
    }

    public function availableTimes(Request $request)
    {
        $date = $request->get('date');
        $serviceId = $request->get('service_id');

        $bookedTimes = Appointment::where('appointment_date', $date)
            ->where('service_id', $serviceId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        $allTimes = $this->generateTimeSlots();
        $available = array_filter($allTimes, fn($t) => !in_array($t, $bookedTimes));

        return response()->json(array_values($available));
    }

    private function generateTimeSlots(): array
    {
        $slots = [];
        for ($h = 10; $h <= 20; $h++) {
            $slots[] = sprintf('%02d:00', $h);
            if ($h < 20) {
                $slots[] = sprintf('%02d:30', $h);
            }
        }
        return $slots;
    }
}
