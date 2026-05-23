<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Services\BookingAvailability;
use App\Services\GoHighLevelService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingAvailability $availability
    ) {}

    public function index(Request $request)
    {
        $services = Service::bookable()->with('equipment:id,name')->get();
        $servicesByCategory = $services->groupBy(fn ($s) => $s->category ?: 'other');
        $servicesForBooking = $servicesByCategory->map(fn ($group) => $group->map(fn ($s) => [
            'id'               => $s->id,
            'name'             => $s->name,
            'price'            => $s->price ? (float) $s->price : null,
            'duration_minutes' => (int) $s->duration_minutes,
            'equipment'        => $s->equipment?->name,
        ])->values());
        $categoryLabels = Service::categoryLabels();
        $selectedService = $request->get('service_id')
            ? Service::find($request->get('service_id'))
            : null;

        return view('booking', compact(
            'services',
            'servicesByCategory',
            'servicesForBooking',
            'categoryLabels',
            'selectedService'
        ));
    }

    public function staffForService(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        $service = Service::findOrFail($request->service_id);
        $staff = $this->availability->eligibleStaffFor($service);

        return response()->json($staff->map(fn ($s) => [
            'id'   => $s->id,
            'name' => $s->name,
            'role' => $s->role,
        ])->values());
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

        $service = Service::findOrFail($validated['service_id']);
        $eligible = $this->availability->eligibleStaffFor($service);

        if ($eligible->isNotEmpty()) {
            $request->validate([
                'staff_id' => 'required|exists:staff,id',
            ], ['staff_id.required' => 'يرجى اختيار الأخصائية المناسبة للخدمة']);
        }

        if (! empty($validated['staff_id']) && ! $this->availability->staffCanPerform((int) $validated['staff_id'], $service)) {
            return back()->withErrors(['staff_id' => 'هذه الأخصائية لا تقدم الخدمة المختارة'])->withInput();
        }

        $slots = $this->availability->availableSlots(
            $validated['appointment_date'],
            $service,
            $validated['staff_id'] ?? null
        );

        $time = substr($validated['appointment_time'], 0, 5);
        if (! in_array($time, $slots, true)) {
            return back()->withErrors(['appointment_time' => 'هذا الوقت لم يعد متاحاً، اختاري وقتاً آخر'])->withInput();
        }

        $validated['appointment_time'] = $time.':00';
        $validated['duration_minutes'] = $service->duration_minutes;
        $validated['equipment_id'] = $service->equipment_id;

        if (empty($validated['client_email'])) {
            $validated['client_email'] = null;
        }

        $appointment = Appointment::create($validated);

        try {
            $ghlService = new GoHighLevelService();
            $ghlContactId = $ghlService->createContact($appointment);
            $appointment->update(['ghl_contact_id' => $ghlContactId]);
            $ghlService->createAppointment($appointment);
        } catch (\Exception $e) {
            \Log::warning('GHL sync failed: '.$e->getMessage());
        }

        return redirect()->route('booking.success', $appointment->id);
    }

    public function success(Appointment $appointment)
    {
        $appointment->load(['service', 'staff']);

        return view('booking-success', compact('appointment'));
    }

    public function availableTimes(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'service_id' => 'required|exists:services,id',
            'staff_id'   => 'nullable|exists:staff,id',
        ]);

        $service = Service::findOrFail($request->service_id);

        return response()->json(
            $this->availability->availableSlots(
                $request->date,
                $service,
                $request->staff_id ? (int) $request->staff_id : null
            )
        );
    }
}
