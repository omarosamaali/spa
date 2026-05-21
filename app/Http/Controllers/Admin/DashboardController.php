<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\HeroSlide;
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

            $slide->type = in_array($data['type'] ?? '', ['image', 'video']) ? $data['type'] : 'image';
            $slide->badge = $data['badge'] ?? $slide->badge;
            $slide->title = $data['title'] ?? $slide->title;
            $slide->title_highlight = $data['title_highlight'] ?? $slide->title_highlight;
            $slide->subtitle = $data['subtitle'] ?? $slide->subtitle;
            $slide->btn_primary_text = $data['btn_primary_text'] ?? $slide->btn_primary_text;
            $slide->btn_primary_url = $data['btn_primary_url'] ?? $slide->btn_primary_url;
            $slide->btn_secondary_text = $data['btn_secondary_text'] ?? $slide->btn_secondary_text;
            $slide->btn_secondary_url = $data['btn_secondary_url'] ?? $slide->btn_secondary_url;
            $slide->is_active = isset($data['is_active']);

            if (! empty($data['media_url'])) {
                $slide->media_url = $data['media_url'];
            }

            if (! empty($data['media_url_alt'])) {
                $slide->media_url_alt = $data['media_url_alt'];
            }

            if (! empty($data['poster_url'])) {
                $slide->poster_url = $data['poster_url'];
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

            $posterFile = $request->file("slides.{$id}.poster_file");
            if ($posterFile) {
                if ($slide->poster_path) {
                    Storage::disk('public')->delete($slide->poster_path);
                }
                $slide->poster_path = $posterFile->store('hero/posters', 'public');
            }

            $slide->save();
        }

        return redirect()->route('admin.hero-slides')->with('success', 'تم تحديث سلايدر الصفحة الرئيسية بنجاح');
    }
}
