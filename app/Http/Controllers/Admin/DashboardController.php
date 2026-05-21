<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date, fn($q) => $q->whereDate('appointment_date', $request->date))
            ->latest()
            ->paginate(20);

        return view('admin.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);
        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الحجز بنجاح');
    }

    // =================== SERVICES CRUD ===================

    public function services()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services', compact('services'));
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string|max:1000',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'category'         => 'nullable|string|max:50',
            'icon'             => 'nullable|string|max:10',
            'sort_order'       => 'integer|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required'        => 'اسم الخدمة مطلوب',
            'description.required' => 'الوصف مطلوب',
            'price.numeric'        => 'السعر يجب أن يكون رقماً',
            'duration_minutes.required' => 'مدة الجلسة مطلوبة',
            'image.image'          => 'يجب أن يكون الملف صورة',
            'image.max'            => 'حجم الصورة يجب أن لا يتجاوز 2 ميغابايت',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Service::max('sort_order') + 1;

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    public function editService(Service $service)
    {
        return view('admin.service-edit', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string|max:1000',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'category'         => 'nullable|string|max:50',
            'icon'             => 'nullable|string|max:10',
            'sort_order'       => 'integer|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required'        => 'اسم الخدمة مطلوب',
            'description.required' => 'الوصف مطلوب',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

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

    public function toggleService(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $label = $service->is_active ? 'تفعيل' : 'إيقاف';

        return back()->with('success', "تم {$label} الخدمة بنجاح");
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
