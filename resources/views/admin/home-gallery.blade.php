@extends('layouts.admin')
@section('title', 'معرض الرئيسية - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">معرض «لحظات من العناية»</h1>
        <p class="text-sm mt-1" style="color:#888">يظهر في الصفحة الرئيسية — الصور النشطة فقط. إن لم تُرفع صور بعد، تُعرض صور افتراضية للزوار.</p>
    </div>
    <button type="button" onclick="document.getElementById('addGalleryModal').classList.remove('hidden')" class="btn-primary">
        إضافة صورة
    </button>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669;">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl text-sm" style="background:#fee2e2; color:#dc2626;">
    <ul class="list-disc pr-5 space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.home-gallery.section') }}" method="POST" class="bg-white rounded-2xl p-6 shadow-sm mb-8 max-w-2xl">
    @csrf
    @method('PUT')
    <h2 class="text-lg font-black mb-4" style="color:#1a1a1a">عناوين القسم</h2>
    <div class="space-y-4">
        <div>
            <label class="form-label">الشارة الصغيرة</label>
            <input type="text" name="badge" class="form-input" value="{{ old('badge', $section['badge']) }}" required>
        </div>
        <div>
            <label class="form-label">عنوان القسم</label>
            <input type="text" name="title" class="form-input" value="{{ old('title', $section['title']) }}" required>
        </div>
        <label class="flex items-center gap-2 text-sm font-bold">
            <input type="checkbox" name="enabled" value="1" {{ old('enabled', $section['enabled']) ? 'checked' : '' }} style="accent-color:#c9888e">
            إظهار القسم في الصفحة الرئيسية
        </label>
    </div>
    <button type="submit" class="btn-primary mt-4">حفظ العناوين</button>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($items as $item)
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm" style="border-right:4px solid {{ $item->is_active ? '#e8b4b8' : '#e5e7eb' }}">
        <div class="relative" style="height:180px;">
            <img src="{{ $item->imageUrl() }}" alt="{{ $item->alt }}" class="w-full h-full object-cover">
            <span class="absolute top-2 left-2 text-xs px-2 py-0.5 rounded-full font-bold"
                  style="background:{{ $item->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $item->is_active ? '#059669' : '#dc2626' }}">
                {{ $item->is_active ? 'نشطة' : 'معطّلة' }}
            </span>
        </div>
        <form action="{{ route('admin.home-gallery.items.update', $item) }}" method="POST" enctype="multipart/form-data" class="p-4 space-y-3">
            @csrf
            @method('PUT')
            <input type="text" name="alt" value="{{ old('alt', $item->alt) }}" class="form-input text-sm" placeholder="وصف الصورة (اختياري)">
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="text-xs font-bold mb-1 block" style="color:#888">ترتيب العرض</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" class="form-input text-sm" min="0" max="999">
                </div>
                <div class="flex-1">
                    <label class="text-xs font-bold mb-1 block" style="color:#888">استبدال الصورة</label>
                    <input type="file" name="image" accept="image/*" class="form-input text-sm py-1.5">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} style="accent-color:#c9888e">
                نشطة — تظهر في الموقع
            </label>
            <button type="submit" class="btn-primary w-full text-sm py-2">حفظ</button>
        </form>
        <div class="flex gap-2 px-4 pb-4">
            <form action="{{ route('admin.home-gallery.items.toggle', $item) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold" style="background:#fef9c3; color:#d97706">
                    {{ $item->is_active ? 'إيقاف' : 'تفعيل' }}
                </button>
            </form>
            <form action="{{ route('admin.home-gallery.items.destroy', $item) }}" method="POST"
                  onsubmit="return confirm('حذف هذه الصورة من المعرض؟')">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold" style="background:#fee2e2; color:#dc2626">حذف</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 rounded-2xl bg-white" style="color:#888">
        لا توجد صور مرفوعة — أضيفي صوراً أو ستُعرض الصور الافتراضية للزوار
    </div>
    @endforelse
</div>

<div id="addGalleryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-black mb-6">إضافة صورة للمعرض</h2>
        <form action="{{ route('admin.home-gallery.items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">الصورة *</label>
                <input type="file" name="image" accept="image/*" class="form-input py-1.5" required>
                <p class="text-xs mt-1" style="color:#888">يفضّل 600×450 أو نسبة قريبة — حتى 4 ميجا</p>
            </div>
            <div>
                <label class="form-label">وصف الصورة (اختياري)</label>
                <input type="text" name="alt" value="{{ old('alt') }}" class="form-input" placeholder="مثال: قاعة السبا الفاخرة">
            </div>
            <div>
                <label class="form-label">ترتيب العرض</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0" max="999">
                <p class="text-xs mt-1" style="color:#888">الأقل يظهر أولاً</p>
            </div>
            <label class="flex items-center gap-2 text-sm font-bold">
                <input type="checkbox" name="is_active" value="1" checked style="accent-color:#c9888e">
                نشطة — تظهر فوراً في الموقع
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">إضافة</button>
                <button type="button" class="flex-1 py-3 rounded-xl font-bold" style="background:#f5f0f0; color:#666"
                        onclick="document.getElementById('addGalleryModal').classList.add('hidden')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@endsection
