<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Staff;
use App\Models\HomeGalleryItem;
use App\Models\Testimonial;
use App\Services\HomeGallery;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use App\Models\SiteTheme;
use App\Services\BookingAvailability;
use App\Services\HomeCategoryFilter;
use App\Services\WhatsAppNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    // =================== DASHBOARD ===================

    public function index()
    {
        $stats = [
            'total'           => Appointment::count(),
            'pending'         => Appointment::where('status', 'pending')->count(),
            'confirmed'       => Appointment::where('status', 'confirmed')->count(),
            'today'           => Appointment::whereDate('appointment_date', today())->count(),
            'unread_contacts' => ContactMessage::unread()->count(),
        ];

        $recent   = Appointment::with('service')->latest()->take(10)->get();
        $messages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent', 'messages'));
    }

    // =================== APPOINTMENTS ===================

    public function appointments(Request $request)
    {
        $appointments = Appointment::with(['service', 'staff'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->date, fn ($q) => $q->whereDate('appointment_date', $request->date))
            ->when($request->service_id, fn ($q) => $q->where('service_id', $request->service_id))
            ->latest()
            ->paginate(20);

        $bookableServices = Service::bookable()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.appointments', compact('appointments', 'bookableServices'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_phone'     => 'required|string|max:20',
            'client_email'     => 'nullable|email|max:255',
            'service_id'       => 'required|exists:services,id',
            'staff_id'         => 'nullable|exists:staff,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'required|in:pending,confirmed,cancelled,completed',
            'notes'            => 'nullable|string|max:500',
        ], [
            'client_name.required'      => 'اسم العميلة مطلوب',
            'client_phone.required'     => 'رقم الهاتف مطلوب',
            'service_id.required'       => 'يرجى اختيار الخدمة',
            'appointment_date.required' => 'يرجى اختيار التاريخ',
            'appointment_time.required' => 'يرجى اختيار الوقت',
            'status.required'           => 'يرجى اختيار الحالة',
        ]);

        $service = Service::bookable()->with('equipment:id,name,capacity')->find($validated['service_id']);
        if (! $service) {
            return back()->withErrors(['service_id' => 'الخدمة غير متاحة للحجز'])->withInput();
        }

        $availability = app(BookingAvailability::class);

        if (! empty($validated['staff_id']) && ! $availability->staffCanPerform((int) $validated['staff_id'], $service)) {
            return back()->withErrors(['staff_id' => 'هذه الأخصائية لا تقدم الخدمة المختارة'])->withInput();
        }

        $slots = $availability->availableSlots(
            $validated['appointment_date'],
            $service,
            $validated['staff_id'] ?? null
        );

        $time = substr($validated['appointment_time'], 0, 5);
        if (! in_array($time, $slots, true)) {
            return back()->withErrors([
                'appointment_time' => $availability->slotRejectionMessage(
                    $validated['appointment_date'],
                    $time,
                    $service,
                    isset($validated['staff_id']) ? (int) $validated['staff_id'] : null
                ),
            ])->withInput();
        }

        $appointment = Appointment::create([
            'client_name'       => $validated['client_name'],
            'client_phone'      => $validated['client_phone'],
            'client_email'      => $validated['client_email'] ?: null,
            'service_id'        => $service->id,
            'staff_id'          => $validated['staff_id'] ?? null,
            'duration_minutes'  => $service->duration_minutes,
            'equipment_id'      => $service->equipment_id,
            'appointment_date'  => $validated['appointment_date'],
            'appointment_time'  => $time.':00',
            'status'            => $validated['status'],
            'notes'             => $validated['notes'] ?? null,
        ]);

        $appointment->load('service');

        try {
            $notifier = app(WhatsAppNotifier::class);
            if ($validated['status'] === 'confirmed') {
                $notifier->sendBookingConfirmed($appointment);
            } else {
                $notifier->sendBookingReceived($appointment);
            }
        } catch (\Throwable $e) {
            \Log::warning('WhatsApp admin booking notify failed: '.$e->getMessage());
        }

        $label = '#'.str_pad((string) $appointment->id, 4, '0', STR_PAD_LEFT);

        return redirect()
            ->route('admin.appointments', $request->only(['status', 'date', 'service_id']))
            ->with('success', "تم إنشاء الحجز {$label} بنجاح");
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);
        $previousStatus = $appointment->status;
        $appointment->update(['status' => $request->status]);

        if ($request->status === 'confirmed' && $previousStatus !== 'confirmed') {
            app(WhatsAppNotifier::class)->sendBookingConfirmed($appointment->fresh(['service']));
        }

        return back()->with('success', 'تم تحديث حالة الحجز بنجاح');
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment)
    {
        if ($appointment->status === 'cancelled') {
            return back()->withErrors([
                'appointment_date' => 'لا يمكن تعديل موعد حجز ملغي — غيّري الحالة إلى انتظار أو تأكيد أولاً',
            ]);
        }

        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ], [
            'appointment_date.required' => 'يرجى اختيار التاريخ',
            'appointment_time.required' => 'يرجى اختيار الوقت',
        ]);

        $appointment->load('service');
        $service = $appointment->service;
        if (! $service) {
            return back()->withErrors(['appointment_date' => 'الخدمة المرتبطة بالحجز غير موجودة'])->withInput();
        }

        $availability = app(BookingAvailability::class);
        $staffId = $appointment->staff_id ? (int) $appointment->staff_id : null;

        $time = substr($validated['appointment_time'], 0, 5);
        $slots = $availability->availableSlots(
            $validated['appointment_date'],
            $service,
            $staffId,
            $appointment->id,
        );

        if (! in_array($time, $slots, true)) {
            return back()
                ->withErrors([
                    'appointment_time' => $availability->slotRejectionMessage(
                        $validated['appointment_date'],
                        $time,
                        $service,
                        $staffId,
                        $appointment->id,
                    ),
                ])
                ->withInput([
                    'reschedule_appointment_id' => $appointment->id,
                    'appointment_date'          => $validated['appointment_date'],
                    'appointment_time'          => $time,
                ]);
        }

        $oldDate = $appointment->appointment_date->format('Y/m/d');
        $oldTime = substr((string) $appointment->appointment_time, 0, 5);

        $appointment->update([
            'appointment_date'          => $validated['appointment_date'],
            'appointment_time'          => $time.':00',
            'whatsapp_reminder_sent_at' => null,
        ]);

        $label = '#'.str_pad((string) $appointment->id, 4, '0', STR_PAD_LEFT);
        $newDate = $appointment->appointment_date->format('Y/m/d');
        $newTime = substr((string) $appointment->appointment_time, 0, 5);

        return redirect()
            ->route('admin.appointments', $request->only(['status', 'date', 'service_id']))
            ->with('success', "تم تعديل موعد الحجز {$label}: من {$oldDate} {$oldTime} إلى {$newDate} {$newTime}");
    }

    public function destroyAppointment(Appointment $appointment)
    {
        $label = '#'.str_pad((string) $appointment->id, 4, '0', STR_PAD_LEFT);
        $appointment->delete();

        return back()->with('success', "تم حذف الحجز {$label} نهائياً");
    }

    // =================== ABOUT PAGE SETTINGS ===================

    public function aboutSettings()
    {
        $years = SiteSetting::get('about_years_experience', '');
        $aboutWho = SiteSetting::aboutWhoWeAre();
        $settings = [];
        foreach (SiteSetting::aboutWhoKeys() as $key) {
            $settings[$key] = SiteSetting::get($key, SiteSetting::defaults()[$key] ?? '');
        }

        return view('admin.about-settings', [
            'years'    => $years !== '' ? (int) $years : SiteSetting::aboutYearsExperience(),
            'aboutWho' => $aboutWho,
            'settings' => $settings,
        ]);
    }

    public function updateAboutSettings(Request $request)
    {
        $validated = $request->validate([
            'about_years_experience' => 'required|integer|min:1|max:99',
            'about_who_badge'        => 'required|string|max:100',
            'about_who_title'        => 'required|string|max:500',
            'about_who_text_1'       => 'required|string|max:3000',
            'about_who_text_2'       => 'nullable|string|max:3000',
            'about_who_image'        => 'nullable|image|max:4096',
        ], [
            'about_years_experience.required' => 'عدد سنوات الخبرة مطلوب',
            'about_who_badge.required'        => 'شارة «من نحن» مطلوبة',
            'about_who_title.required'        => 'عنوان القسم مطلوب',
            'about_who_text_1.required'       => 'الفقرة الأولى مطلوبة',
            'about_who_image.image'           => 'يجب أن يكون الملف صورة',
        ]);

        SiteSetting::set('about_years_experience', (string) $validated['about_years_experience']);
        SiteSetting::set('about_who_badge', $validated['about_who_badge']);
        SiteSetting::set('about_who_title', $validated['about_who_title']);
        SiteSetting::set('about_who_text_1', $validated['about_who_text_1']);
        SiteSetting::set('about_who_text_2', $validated['about_who_text_2'] ?? '');

        $imagePath = SiteSetting::get('about_who_image', '');
        if ($request->boolean('remove_about_who_image') && $imagePath) {
            Storage::disk('public')->delete($imagePath);
            SiteSetting::set('about_who_image', '');
            $imagePath = '';
        }
        if ($request->hasFile('about_who_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            SiteSetting::set('about_who_image', $request->file('about_who_image')->store('about', 'public'));
        }

        return redirect()->route('admin.about-settings')->with('success', 'تم حفظ إعدادات صفحة عن المركز');
    }

    // =================== HOME SERVICE FILTER (اختاري ما يناسبك) ===================

    public function homeServiceFilters()
    {
        $config = HomeCategoryFilter::config();
        $categoryLabels = Service::categoryLabelsForAdmin();

        return view('admin.home-service-filters', compact('config', 'categoryLabels'));
    }

    public function updateHomeServiceFilters(Request $request)
    {
        $labels = Service::categoryLabelsForAdmin();
        $visibleInput = $request->input('visible', []);

        $visible = [];
        foreach (array_keys($labels) as $key) {
            $visible[$key] = ! empty($visibleInput[$key]);
        }

        $showAll = $request->boolean('show_all');
        $default = $request->input('default', 'all');

        $tabs = [];
        if ($showAll) {
            $tabs[] = 'all';
        }
        foreach ($labels as $key => $_label) {
            if ($visible[$key] ?? false) {
                $tabs[] = $key;
            }
        }

        if ($tabs === []) {
            return back()->withErrors(['visible' => 'يجب تفعيل قسم واحد على الأقل أو إظهار «الكل»'])->withInput();
        }

        if (! in_array($default, $tabs, true)) {
            return back()->withErrors(['default' => 'الفلتر الافتراضي يجب أن يكون من الأقسام الظاهرة'])->withInput();
        }

        HomeCategoryFilter::save($showAll, $default, $visible);

        return back()->with('success', 'تم حفظ إعدادات فلتر الخدمات في الرئيسية');
    }

    // =================== SERVICE CATEGORIES (تصنيفات الخدمات) ===================

    public function serviceCategories()
    {
        ServiceCategory::seedDefaultsIfEmpty();
        $categories = ServiceCategory::orderBy('sort_order')->orderBy('id')->get();
        $filterConfig = HomeCategoryFilter::config();
        $filterCategoryLabels = Service::categoryLabelsForAdmin();

        return view('admin.service-categories', compact('categories', 'filterConfig', 'filterCategoryLabels'));
    }

    public function storeServiceCategory(Request $request)
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:100',
            'slug'       => 'nullable|string|max:50|regex:/^[a-z0-9_]+$/|unique:service_categories,slug',
            'sort_order' => 'nullable|integer|min:0|max:999',
        ], [
            'label.required' => 'اسم التصنيف مطلوب',
            'slug.regex'     => 'المعرّف بالإنجليزية: حروف صغيرة وأرقام و _ فقط (مثل laser)',
            'slug.unique'    => 'هذا المعرّف مستخدم مسبقاً',
        ]);

        $slug = trim($validated['slug'] ?? '');
        if ($slug === '') {
            $slug = ServiceCategory::makeUniqueSlug($validated['label']);
        }

        ServiceCategory::create([
            'slug'       => $slug,
            'label'      => $validated['label'],
            'sort_order' => (int) ($validated['sort_order'] ?? ServiceCategory::max('sort_order') + 1),
            'is_active'  => $request->boolean('is_active', true),
        ]);

        ServiceCategory::clearCache();

        return redirect()->route('admin.service-categories')->with('success', 'تم إضافة التصنيف');
    }

    public function updateServiceCategory(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:999',
        ], [
            'label.required' => 'اسم التصنيف مطلوب',
        ]);

        $serviceCategory->update([
            'label'      => $validated['label'],
            'sort_order' => (int) ($validated['sort_order'] ?? $serviceCategory->sort_order),
            'is_active'  => $request->boolean('is_active'),
        ]);

        ServiceCategory::clearCache();

        return redirect()->route('admin.service-categories')->with('success', 'تم تحديث التصنيف');
    }

    public function destroyServiceCategory(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->servicesCount() > 0) {
            return back()->withErrors([
                'category' => 'لا يمكن حذف «'.$serviceCategory->label.'» — مرتبط بـ '.$serviceCategory->servicesCount().' خدمة. غيّري تصنيف الخدمات أولاً أو عطّلي التصنيف.',
            ]);
        }

        $serviceCategory->delete();
        ServiceCategory::clearCache();

        return redirect()->route('admin.service-categories')->with('success', 'تم حذف التصنيف');
    }

    public function toggleServiceCategory(ServiceCategory $serviceCategory)
    {
        $serviceCategory->update(['is_active' => ! $serviceCategory->is_active]);
        ServiceCategory::clearCache();

        return back()->with('success', 'تم تحديث حالة التصنيف');
    }

    // =================== SERVICES CRUD ===================

    public function services()
    {
        $services = Service::with('equipment:id,name')->orderBy('sort_order')->get();
        $equipmentList = Equipment::orderBy('sort_order')->orderBy('name')->get();
        $categories = ServiceCategory::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.services', compact('services', 'equipmentList', 'categories'));
    }

    public function storeService(Request $request)
    {
        $this->normalizeServiceRequest($request);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string|max:1000',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'category'         => $this->serviceCategoryRules(),
            'equipment_id'     => 'nullable|exists:equipment,id',
            'icon'             => 'nullable|string|max:16',
            'sort_order'       => 'nullable|integer|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $this->serviceValidationMessages());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Service::max('sort_order') + 1;
        $validated['equipment_id'] = $validated['equipment_id'] ?? null;
        $validated['category'] = $validated['category'] ?: null;

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    public function editService(Service $service)
    {
        $equipmentList = Equipment::orderBy('sort_order')->orderBy('name')->get();
        $categories = ServiceCategory::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.service-edit', compact('service', 'equipmentList', 'categories'));
    }

    public function updateService(Request $request, Service $service)
    {
        $this->normalizeServiceRequest($request);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string|max:1000',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'category'         => $this->serviceCategoryRules(),
            'equipment_id'     => 'nullable|exists:equipment,id',
            'icon'             => 'nullable|string|max:16',
            'sort_order'       => 'nullable|integer|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $this->serviceValidationMessages());

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['equipment_id'] = $validated['equipment_id'] ?? null;
        $validated['sort_order'] = $validated['sort_order'] ?? $service->sort_order;

        $service->update($validated);

        return redirect()->route('admin.services')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function destroyService(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->route('admin.services')->with('success', 'تم حذف الخدمة بنجاح');
    }

    /** تحويل الحقول الفارغة إلى null (Laravel 11 لا يفعل ذلك تلقائياً) */
    private function normalizeServiceRequest(Request $request): void
    {
        foreach (['price', 'category', 'equipment_id', 'icon', 'sort_order'] as $field) {
            if ($request->has($field) && $request->input($field) === '') {
                $request->merge([$field => null]);
            }
        }
    }

    /** @return array<string, string> */
    private function serviceValidationMessages(): array
    {
        return [
            'name.required'             => 'اسم الخدمة مطلوب',
            'description.required'      => 'الوصف مطلوب',
            'price.numeric'             => 'السعر يجب أن يكون رقماً صحيحاً أو يُترك فارغاً',
            'duration_minutes.required' => 'مدة الجلسة مطلوبة',
            'category.in'               => 'التصنيف غير صالح — اختاري من قائمة التصنيفات',
            'image.image'               => 'يجب أن يكون الملف صورة',
            'image.max'                 => 'حجم الصورة يجب أن لا يتجاوز 2 ميغابايت',
        ];
    }

    /** @return array<int, mixed> */
    private function serviceCategoryRules(): array
    {
        ServiceCategory::seedDefaultsIfEmpty();

        return [
            'nullable',
            'string',
            'max:50',
            Rule::in(array_keys(ServiceCategory::labelsMap(false))),
        ];
    }

    public function toggleService(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $label = $service->is_active ? 'تفعيل' : 'إيقاف';

        return back()->with('success', "تم {$label} الخدمة بنجاح");
    }

    // =================== STAFF CRUD ===================

    public function staff()
    {
        $staffMembers = Staff::orderBy('name')->get();

        return view('admin.staff', compact('staffMembers'));
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'role'         => 'nullable|string|max:255',
            'bio'          => 'nullable|string|max:2000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'service_ids'  => 'nullable|array',
            'service_ids.*'=> 'exists:services,id',
        ], [
            'name.required' => 'اسم الأخصائية مطلوب',
            'image.image'   => 'يجب أن يكون الملف صورة',
            'image.max'     => 'حجم الصورة يجب أن لا يتجاوز 2 ميغابايت',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('staff', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $serviceIds = $request->input('service_ids', []);

        $staff = Staff::create(collect($validated)->except('service_ids')->all());
        $staff->services()->sync($serviceIds);

        return redirect()->route('admin.staff')->with('success', 'تم إضافة الأخصائية بنجاح');
    }

    public function editStaff(Staff $staff)
    {
        $staff->load('services');
        $allServices = Service::orderBy('category')->orderBy('sort_order')->get();

        return view('admin.staff-edit', compact('staff', 'allServices'));
    }

    public function updateStaff(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'role'         => 'nullable|string|max:255',
            'bio'          => 'nullable|string|max:2000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'service_ids'  => 'nullable|array',
            'service_ids.*'=> 'exists:services,id',
        ], [
            'name.required' => 'اسم الأخصائية مطلوب',
        ]);

        if ($request->hasFile('image')) {
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
            $validated['image'] = $request->file('image')->store('staff', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $serviceIds = $request->input('service_ids', []);

        $staff->update(collect($validated)->except('service_ids')->all());
        $staff->services()->sync($serviceIds);

        return redirect()->route('admin.staff')->with('success', 'تم تحديث الأخصائية بنجاح');
    }

    public function destroyStaff(Staff $staff)
    {
        if ($staff->image) {
            Storage::disk('public')->delete($staff->image);
        }

        $staff->delete();

        return redirect()->route('admin.staff')->with('success', 'تم حذف الأخصائية بنجاح');
    }

    public function toggleStaff(Staff $staff)
    {
        $staff->update(['is_active' => ! $staff->is_active]);
        $label = $staff->is_active ? 'تفعيل' : 'إيقاف';

        return back()->with('success', "تم {$label} الأخصائية بنجاح");
    }

    // =================== EQUIPMENT CRUD ===================

    public function equipment()
    {
        $equipmentList = Equipment::orderBy('sort_order')->orderBy('name')->get();
        $categoryLabels = Equipment::categoryLabels();

        return view('admin.equipment', compact('equipmentList', 'categoryLabels'));
    }

    public function storeEquipment(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'category'   => 'nullable|string|max:50',
            'capacity'   => 'required|integer|min:1|max:50',
            'notes'      => 'nullable|string|max:1000',
            'sort_order' => 'integer|min:0',
        ], [
            'name.required' => 'اسم الجهاز مطلوب',
            'capacity.required' => 'عدد الأماكن مطلوب',
            'capacity.min' => 'عدد الأماكن يجب أن يكون 1 على الأقل',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Equipment::max('sort_order') + 1;

        Equipment::create($validated);

        return redirect()->route('admin.equipment')->with('success', 'تم إضافة الجهاز بنجاح');
    }

    public function updateEquipment(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'category'   => 'nullable|string|max:50',
            'capacity'   => 'required|integer|min:1|max:50',
            'notes'      => 'nullable|string|max:1000',
            'sort_order' => 'integer|min:0',
        ], [
            'capacity.required' => 'عدد الأماكن مطلوب',
            'capacity.min' => 'عدد الأماكن يجب أن يكون 1 على الأقل',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $equipment->update($validated);

        return redirect()->route('admin.equipment')->with('success', 'تم تحديث الجهاز بنجاح');
    }

    public function destroyEquipment(Equipment $equipment)
    {
        Service::where('equipment_id', $equipment->id)->update(['equipment_id' => null]);
        $equipment->delete();

        return redirect()->route('admin.equipment')->with('success', 'تم حذف الجهاز بنجاح');
    }

    public function toggleEquipment(Equipment $equipment)
    {
        $equipment->update(['is_active' => ! $equipment->is_active]);

        return back()->with('success', 'تم تحديث حالة الجهاز');
    }

    // =================== HOME GALLERY (لحظات من العناية) ===================

    public function homeGallery()
    {
        $items = HomeGalleryItem::orderBy('sort_order')->orderBy('id')->get();
        $section = [
            'enabled' => SiteSetting::get(HomeGallery::SETTING_ENABLED, '1') === '1',
            'badge'   => SiteSetting::get(HomeGallery::SETTING_BADGE, 'معرضنا'),
            'title'   => SiteSetting::get(HomeGallery::SETTING_TITLE, 'لحظات من العناية'),
        ];

        return view('admin.home-gallery', compact('items', 'section'));
    }

    public function updateHomeGallerySection(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'required|string|max:100',
            'title' => 'required|string|max:200',
        ], [
            'badge.required' => 'عنوان الشارة مطلوب',
            'title.required' => 'عنوان القسم مطلوب',
        ]);

        HomeGallery::saveSection(
            $request->boolean('enabled', true),
            $validated['badge'],
            $validated['title'],
        );

        return redirect()->route('admin.home-gallery')->with('success', 'تم حفظ إعدادات القسم');
    }

    public function storeHomeGalleryItem(Request $request)
    {
        $validated = $request->validate([
            'image'      => 'required|image|max:4096',
            'alt'        => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0|max:999',
        ], [
            'image.required' => 'صورة المعرض مطلوبة',
            'image.image'    => 'يجب أن يكون الملف صورة',
        ]);

        $path = $request->file('image')->store('home-gallery', 'public');

        HomeGalleryItem::create([
            'image'      => $path,
            'alt'        => $validated['alt'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.home-gallery')->with('success', 'تم إضافة الصورة للمعرض');
    }

    public function updateHomeGalleryItem(Request $request, HomeGalleryItem $homeGalleryItem)
    {
        $validated = $request->validate([
            'image'      => 'nullable|image|max:4096',
            'alt'        => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0|max:999',
        ]);

        if ($request->hasFile('image')) {
            if ($homeGalleryItem->image) {
                Storage::disk('public')->delete($homeGalleryItem->image);
            }
            $validated['image'] = $request->file('image')->store('home-gallery', 'public');
        } else {
            unset($validated['image']);
        }

        $homeGalleryItem->update([
            'image'      => $validated['image'] ?? $homeGalleryItem->image,
            'alt'        => $validated['alt'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? $homeGalleryItem->sort_order),
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.home-gallery')->with('success', 'تم تحديث الصورة');
    }

    public function destroyHomeGalleryItem(HomeGalleryItem $homeGalleryItem)
    {
        if ($homeGalleryItem->image) {
            Storage::disk('public')->delete($homeGalleryItem->image);
        }
        $homeGalleryItem->delete();

        return redirect()->route('admin.home-gallery')->with('success', 'تم حذف الصورة');
    }

    public function toggleHomeGalleryItem(HomeGalleryItem $homeGalleryItem)
    {
        $homeGalleryItem->update(['is_active' => ! $homeGalleryItem->is_active]);

        return back()->with('success', 'تم تحديث حالة الصورة');
    }

    // =================== TESTIMONIALS CRUD ===================

    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('id')->get();

        return view('admin.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $this->validateTestimonial($request);

        if ($request->hasFile('client_image')) {
            $validated['client_image'] = $request->file('client_image')->store('testimonials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['rating'] = $validated['rating'] ?? 5;

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials')->with('success', 'تم إضافة الرأي بنجاح');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $validated = $this->validateTestimonial($request);

        if ($request->hasFile('client_image')) {
            if ($testimonial->client_image) {
                Storage::disk('public')->delete($testimonial->client_image);
            }
            $validated['client_image'] = $request->file('client_image')->store('testimonials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['rating'] = $validated['rating'] ?? 5;

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials')->with('success', 'تم تحديث الرأي بنجاح');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        if ($testimonial->client_image) {
            Storage::disk('public')->delete($testimonial->client_image);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials')->with('success', 'تم حذف الرأي بنجاح');
    }

    public function toggleTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => ! $testimonial->is_active]);

        return back()->with('success', 'تم تحديث حالة الرأي');
    }

    /** @return array<string, mixed> */
    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_city'  => 'nullable|string|max:255',
            'content'      => 'required|string|max:2000',
            'rating'       => 'nullable|integer|min:1|max:5',
            'client_image' => 'nullable|image|max:2048',
        ], [
            'client_name.required' => 'اسم العميلة مطلوب',
            'content.required'     => 'نص الرأي مطلوب',
            'rating.min'           => 'التقييم من 1 إلى 5',
            'rating.max'           => 'التقييم من 1 إلى 5',
        ]);
    }

    // =================== CONTACT MESSAGES ===================

    public function contacts(Request $request)
    {
        $messages = ContactMessage::when(
                $request->filter === 'unread',
                fn($q) => $q->where('is_read', false)
            )
            ->when(
                $request->filter === 'read',
                fn($q) => $q->where('is_read', true)
            )
            ->latest()
            ->paginate(20);

        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contacts', compact('messages', 'unreadCount'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'تم تحديد الرسالة كمقروءة');
    }

    public function markAllRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'تم تحديد جميع الرسائل كمقروءة');
    }

    public function destroyMessage(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'تم حذف الرسالة');
    }

    // =================== CONTACT / WHATSAPP SETTINGS ===================

    public function contactSettings()
    {
        $c = SiteSetting::contactInfo();

        $settings = [
            'phone'            => SiteSetting::get('contact_phone', $c['phone']),
            'phone_raw'        => SiteSetting::get('contact_phone_raw', $c['phone_raw']),
            'whatsapp_phone'   => SiteSetting::get('contact_whatsapp_phone', $c['whatsapp_phone']),
            'whatsapp_raw'     => SiteSetting::get('contact_whatsapp_raw', $c['whatsapp_raw']),
            'email'            => SiteSetting::get('contact_email', $c['email']),
            'address'          => SiteSetting::get('contact_address', $c['address']),
            'hours_weekdays'   => SiteSetting::get('contact_hours_weekdays', $c['hours_weekdays']),
            'hours_friday'     => SiteSetting::get('contact_hours_friday', $c['hours_friday']),
            'whatsapp_text'    => SiteSetting::get('whatsapp_default_text', $c['whatsapp_text']),
            'social_instagram' => SiteSetting::get('social_instagram', ''),
            'social_facebook'  => SiteSetting::get('social_facebook', ''),
            'social_tiktok'    => SiteSetting::get('social_tiktok', ''),
            'social_snapchat'  => SiteSetting::get('social_snapchat', ''),
        ];

        return view('admin.contact-settings', compact('settings', 'c'));
    }

    public function updateContactSettings(Request $request)
    {
        $validated = $request->validate([
            'contact_phone'            => 'required|string|max:50',
            'contact_phone_raw'        => 'nullable|string|max:20',
            'contact_whatsapp_phone'   => 'nullable|string|max:50',
            'contact_whatsapp_raw'     => 'nullable|string|max:20',
            'contact_email'            => 'nullable|email|max:255',
            'contact_address'          => 'required|string|max:500',
            'contact_hours_weekdays'   => 'required|string|max:100',
            'contact_hours_friday'     => 'required|string|max:100',
            'whatsapp_default_text'    => 'nullable|string|max:500',
            'social_instagram'         => 'nullable|string|max:500',
            'social_facebook'          => 'nullable|string|max:500',
            'social_tiktok'            => 'nullable|string|max:500',
            'social_snapchat'          => 'nullable|string|max:500',
        ], [
            'contact_phone.required' => 'رقم الهاتف مطلوب',
            'contact_email.email'    => 'البريد الإلكتروني غير صالح',
        ]);

        $phoneRaw = $validated['contact_phone_raw']
            ? SiteSetting::normalizePhone($validated['contact_phone_raw'])
            : SiteSetting::normalizePhone($validated['contact_phone']);

        $waPhone = $validated['contact_whatsapp_phone'] ?: $validated['contact_phone'];
        $waRaw = $validated['contact_whatsapp_raw']
            ? SiteSetting::normalizePhone($validated['contact_whatsapp_raw'])
            : $phoneRaw;

        SiteSetting::set('contact_phone', $validated['contact_phone']);
        SiteSetting::set('contact_phone_raw', $phoneRaw);
        SiteSetting::set('contact_whatsapp_phone', $waPhone);
        SiteSetting::set('contact_whatsapp_raw', $waRaw);
        SiteSetting::set('contact_email', $validated['contact_email'] ?? '');
        SiteSetting::set('contact_address', $validated['contact_address']);
        SiteSetting::set('contact_hours_weekdays', $validated['contact_hours_weekdays']);
        SiteSetting::set('contact_hours_friday', $validated['contact_hours_friday']);
        SiteSetting::set('whatsapp_default_text', $validated['whatsapp_default_text'] ?? '');

        foreach (['instagram', 'facebook', 'tiktok', 'snapchat'] as $platform) {
            SiteSetting::set('social_' . $platform, $this->normalizeSocialUrl($validated['social_' . $platform] ?? ''));
        }

        SiteSetting::clearContactCache();

        return redirect()->route('admin.contact-settings')->with('success', 'تم تحديث بيانات التواصل والسوشيال بنجاح');
    }

    // =================== WHATSAPP API (AUTO MESSAGES) ===================

    public function whatsappSettings()
    {
        $config = SiteSetting::whatsappApi();
        $settings = [];
        foreach (SiteSetting::whatsappApiKeys() as $key) {
            $settings[$key] = SiteSetting::get($key, SiteSetting::defaults()[$key] ?? '');
        }

        return view('admin.whatsapp-settings', compact('config', 'settings'));
    }

    public function updateWhatsappSettings(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_api_token'          => 'nullable|string|max:500',
            'whatsapp_phone_number_id'  => 'nullable|string|max:80',
            'whatsapp_api_version'      => 'nullable|string|max:20',
            'whatsapp_template_received'  => 'nullable|string|max:120',
            'whatsapp_template_confirmed' => 'nullable|string|max:120',
            'whatsapp_template_reminder'  => 'nullable|string|max:120',
            'whatsapp_reminder_hours'     => 'nullable|integer|min:1|max:168',
            'whatsapp_template_lang'    => 'nullable|string|max:10',
            'test_phone'                => 'nullable|string|max:20',
            'test_template'               => 'nullable|in:received,confirmed,reminder',
        ]);

        SiteSetting::set('whatsapp_api_enabled', $request->boolean('whatsapp_api_enabled') ? '1' : '0');
        SiteSetting::set('whatsapp_api_token', trim($validated['whatsapp_api_token'] ?? ''));
        SiteSetting::set('whatsapp_phone_number_id', trim($validated['whatsapp_phone_number_id'] ?? ''));
        SiteSetting::set('whatsapp_api_version', trim($validated['whatsapp_api_version'] ?? 'v21.0') ?: 'v21.0');
        SiteSetting::set('whatsapp_template_received', trim($validated['whatsapp_template_received'] ?? 'booking_received') ?: 'booking_received');
        SiteSetting::set('whatsapp_template_confirmed', trim($validated['whatsapp_template_confirmed'] ?? 'booking_confirmed') ?: 'booking_confirmed');
        SiteSetting::set('whatsapp_template_reminder', trim($validated['whatsapp_template_reminder'] ?? 'booking_reminder') ?: 'booking_reminder');
        SiteSetting::set('whatsapp_reminder_enabled', $request->boolean('whatsapp_reminder_enabled') ? '1' : '0');
        SiteSetting::set('whatsapp_reminder_hours', (string) max(1, min(168, (int) ($validated['whatsapp_reminder_hours'] ?? 24))));
        SiteSetting::set('whatsapp_template_lang', trim($validated['whatsapp_template_lang'] ?? 'ar') ?: 'ar');

        SiteSetting::clearWhatsappApiCache();

        $message = 'تم حفظ إعدادات واتساب';

        if ($request->boolean('send_test') && ! empty($validated['test_phone'])) {
            $sent = app(WhatsAppNotifier::class)->sendTestMessage(
                $validated['test_phone'],
                'اختبار',
                $validated['test_template'] ?? 'received'
            );
            $message .= $sent ? ' — وتم إرسال رسالة تجريبية' : ' — فشل الإرسال التجريبي (راجع السجل أو القوالب في Meta)';
        }

        return redirect()->route('admin.whatsapp-settings')->with('success', $message);
    }

    private function normalizeSocialUrl(?string $url): string
    {
        $url = trim($url ?? '');
        if ($url === '') {
            return '';
        }
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }

    // =================== PROMO CTA BANNER ===================

    public function promoSettings()
    {
        $promo = SiteSetting::promoBanner();
        $settings = [];
        foreach (SiteSetting::promoKeys() as $key) {
            $settings[$key] = SiteSetting::get($key, SiteSetting::defaults()[$key] ?? '');
        }

        return view('admin.promo-settings', compact('promo', 'settings'));
    }

    public function updatePromoSettings(Request $request)
    {
        $validated = $request->validate([
            'promo_badge'          => 'nullable|string|max:120',
            'promo_title'          => 'required|string|max:200',
            'promo_line1'          => 'nullable|string|max:200',
            'promo_line2'          => 'nullable|string|max:300',
            'promo_discount'       => 'nullable|string|max:20',
            'promo_discount_label' => 'nullable|string|max:100',
            'promo_discount_note'  => 'nullable|string|max:200',
            'promo_button_text'    => 'required|string|max:80',
            'promo_button_url'     => 'nullable|string|max:500',
            'promo_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'promo_title.required' => 'عنوان البطاقة مطلوب',
            'promo_button_text.required' => 'نص الزر مطلوب',
        ]);

        SiteSetting::set('promo_active', $request->boolean('promo_active') ? '1' : '0');
        SiteSetting::set('promo_badge', $validated['promo_badge'] ?? '');
        SiteSetting::set('promo_title', $validated['promo_title']);
        SiteSetting::set('promo_line1', $validated['promo_line1'] ?? '');
        SiteSetting::set('promo_line2', $validated['promo_line2'] ?? '');
        SiteSetting::set('promo_discount', $validated['promo_discount'] ?? '');
        SiteSetting::set('promo_discount_label', $validated['promo_discount_label'] ?? '');
        SiteSetting::set('promo_discount_note', $validated['promo_discount_note'] ?? '');
        SiteSetting::set('promo_button_text', $validated['promo_button_text']);
        SiteSetting::set('promo_button_url', trim($validated['promo_button_url'] ?? ''));

        $imagePath = SiteSetting::get('promo_image');
        if ($request->boolean('remove_promo_image') && $imagePath) {
            Storage::disk('public')->delete($imagePath);
            SiteSetting::set('promo_image', '');
            $imagePath = '';
        }
        if ($request->hasFile('promo_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            SiteSetting::set('promo_image', $request->file('promo_image')->store('promo', 'public'));
        }

        SiteSetting::clearPromoCache();

        return redirect()->route('admin.promo-settings')->with('success', 'تم تحديث بطاقة العرض بنجاح');
    }

    // =================== BOOKING STEPS VIDEO ===================

    public function stepsVideoSettings()
    {
        $stepsVideo = SiteSetting::stepsVideo();
        $settings = [];
        foreach (SiteSetting::stepsVideoKeys() as $key) {
            $settings[$key] = SiteSetting::get($key, SiteSetting::defaults()[$key] ?? '');
        }

        return view('admin.steps-video-settings', compact('stepsVideo', 'settings'));
    }

    public function updateStepsVideoSettings(Request $request)
    {
        $validated = $request->validate([
            'steps_video_url'    => 'nullable|string|max:1000',
            'steps_video_poster' => 'nullable|string|max:1000',
            'steps_video_file'   => 'nullable|file|mimes:mp4,webm,mov|max:51200',
        ], [
            'steps_video_file.max' => 'حجم الفيديو كبير جداً (الحد الأقصى 50 ميجابايت)',
            'steps_video_file.mimes' => 'صيغة الفيديو غير مدعومة (mp4, webm, mov)',
        ]);

        SiteSetting::set('steps_video_url', trim($validated['steps_video_url'] ?? ''));
        SiteSetting::set('steps_video_poster', trim($validated['steps_video_poster'] ?? ''));

        $videoPath = SiteSetting::get('steps_video_path');
        if ($request->boolean('remove_steps_video') && $videoPath) {
            Storage::disk('public')->delete($videoPath);
            SiteSetting::set('steps_video_path', '');
            $videoPath = '';
        }

        if ($request->hasFile('steps_video_file')) {
            if ($videoPath) {
                Storage::disk('public')->delete($videoPath);
            }
            SiteSetting::set('steps_video_path', $request->file('steps_video_file')->store('steps-video', 'public'));
        }

        SiteSetting::clearStepsVideoCache();

        return redirect()->route('admin.steps-video')->with('success', 'تم تحديث فيديو الخطوات بنجاح');
    }

    // =================== BRANDING (COLORS / LOGO / FAVICON) ===================

    public function brandingSettings()
    {
        $theme = SiteSetting::theme();

        $settings = [];
        foreach (SiteSetting::themeKeys() as $key) {
            $settings[$key] = SiteSetting::get($key, SiteSetting::defaults()[$key] ?? '');
        }

        return view('admin.branding-settings', compact('theme', 'settings'));
    }

    public function updateBrandingSettings(Request $request)
    {
        $validated = $request->validate([
            'theme_primary'       => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'theme_primary_dark'  => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'theme_primary_light' => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'theme_gold'          => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'theme_dark'          => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'theme_dark_2'        => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'site_name'           => 'required|string|max:80',
            'site_tagline'        => 'nullable|string|max:120',
            'logo_file'           => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'favicon_file'        => 'nullable|file|mimes:jpeg,png,jpg,webp,ico,svg|max:512',
        ], [
            'theme_primary.regex' => 'لون غير صالح (مثال: #e8b4b8)',
        ]);

        foreach (['theme_primary', 'theme_primary_dark', 'theme_primary_light', 'theme_gold', 'theme_dark', 'theme_dark_2'] as $colorKey) {
            SiteSetting::set($colorKey, SiteSetting::normalizeHexColor($validated[$colorKey]));
        }

        SiteSetting::set('site_name', $validated['site_name']);
        SiteSetting::set('site_tagline', $validated['site_tagline'] ?? '');

        $logoPath = SiteSetting::get('logo_path');
        if ($request->boolean('remove_logo') && $logoPath) {
            Storage::disk('public')->delete($logoPath);
            SiteSetting::set('logo_path', '');
        }
        if ($request->hasFile('logo_file')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            SiteSetting::set('logo_path', $request->file('logo_file')->store('branding', 'public'));
        }

        $faviconPath = SiteSetting::get('favicon_path');
        if ($request->boolean('remove_favicon') && $faviconPath) {
            Storage::disk('public')->delete($faviconPath);
            SiteSetting::set('favicon_path', '');
        }
        if ($request->hasFile('favicon_file')) {
            if ($faviconPath) {
                Storage::disk('public')->delete($faviconPath);
            }
            SiteSetting::set('favicon_path', $request->file('favicon_file')->store('branding', 'public'));
        }

        SiteSetting::clearThemeCache();

        return redirect()->route('admin.branding-settings')->with('success', 'تم تحديث ألوان الموقع والشعار بنجاح');
    }

    // =================== HERO SLIDER ===================

    public function heroSlides()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();

        return view('admin.hero-slides', compact('slides'));
    }

    public function updateHeroSlides(Request $request)
    {
        $slidesData = $request->input('slides', []);

        foreach ($slidesData as $id => $data) {
            $slide = HeroSlide::find($id);
            if (! $slide) {
                continue;
            }

            $newType = in_array($data['type'] ?? '', ['image', 'video']) ? $data['type'] : 'image';
            $oldType = $slide->type;

            if ($oldType !== $newType) {
                $this->cleanupHeroSlideMediaOnTypeChange($slide, $newType);
            }

            $slide->type = $newType;
            $slide->badge = $data['badge'] ?? $slide->badge;
            $slide->title = $data['title'] ?? $slide->title;
            $slide->title_highlight = $data['title_highlight'] ?? $slide->title_highlight;
            $slide->subtitle = $data['subtitle'] ?? $slide->subtitle;
            $slide->btn_primary_text = $data['btn_primary_text'] ?? $slide->btn_primary_text;
            $slide->btn_primary_url = $data['btn_primary_url'] ?? $slide->btn_primary_url;
            $slide->btn_secondary_text = $data['btn_secondary_text'] ?? $slide->btn_secondary_text;
            $slide->btn_secondary_url = $data['btn_secondary_url'] ?? $slide->btn_secondary_url;
            $slide->is_active = isset($data['is_active']);

            if (array_key_exists('media_url', $data)) {
                $slide->media_url = $data['media_url'] ?: null;
            }

            if ($slide->type === 'video') {
                $slide->media_url_alt = ! empty($data['media_url_alt']) ? $data['media_url_alt'] : null;
                $slide->poster_url = ! empty($data['poster_url']) ? $data['poster_url'] : null;
            } else {
                $slide->media_url_alt = null;
                $slide->poster_url = null;
            }

            if (! empty($data['remove_media']) && $slide->media_path) {
                Storage::disk('public')->delete($slide->media_path);
                $slide->media_path = null;
            }

            if (! empty($data['remove_poster']) && $slide->poster_path) {
                Storage::disk('public')->delete($slide->poster_path);
                $slide->poster_path = null;
            }

            $mediaFile = $request->file("slides.{$id}.media_file");
            if ($mediaFile) {
                if ($slide->media_path) {
                    Storage::disk('public')->delete($slide->media_path);
                }
                $folder = $slide->type === 'video' ? 'hero/videos' : 'hero/images';
                $slide->media_path = $mediaFile->store($folder, 'public');
            }

            if ($slide->type === 'video') {
                $posterFile = $request->file("slides.{$id}.poster_file");
                if ($posterFile) {
                    if ($slide->poster_path) {
                        Storage::disk('public')->delete($slide->poster_path);
                    }
                    $slide->poster_path = $posterFile->store('hero/posters', 'public');
                }
            } elseif ($slide->poster_path) {
                Storage::disk('public')->delete($slide->poster_path);
                $slide->poster_path = null;
            }

            $slide->save();
        }

        return redirect()->route('admin.hero-slides')->with('success', 'تم تحديث سلايدر الصفحة الرئيسية بنجاح');
    }

    // =================== THEME SELECTOR ===================

    public function themeSelector()
    {
        $themes    = SiteTheme::presets();
        $activeId  = SiteSetting::get('active_theme') ?: 'luxea';

        return view('admin.theme-selector', compact('themes', 'activeId'));
    }

    public function setActiveTheme(Request $request)
    {
        $themeId = $request->input('theme_id');

        if (! SiteTheme::exists($themeId)) {
            return back()->with('error', 'الثيم غير موجود');
        }

        SiteSetting::set('active_theme', $themeId);
        SiteSetting::clearThemeCache();

        return back()->with('success', 'تم تفعيل الثيم بنجاح');
    }

    // =================== PRIVATE HELPERS ===================

    private function cleanupHeroSlideMediaOnTypeChange(HeroSlide $slide, string $newType): void
    {
        $slide->media_url = null;
        $slide->media_url_alt = null;
        $slide->poster_url = null;

        if ($slide->poster_path) {
            Storage::disk('public')->delete($slide->poster_path);
            $slide->poster_path = null;
        }

        if ($newType === 'image') {
            if ($slide->media_path && str_starts_with($slide->media_path, 'hero/videos')) {
                Storage::disk('public')->delete($slide->media_path);
                $slide->media_path = null;
            }
        } elseif ($slide->media_path && str_starts_with($slide->media_path, 'hero/images')) {
            Storage::disk('public')->delete($slide->media_path);
            $slide->media_path = null;
        }
    }
}
