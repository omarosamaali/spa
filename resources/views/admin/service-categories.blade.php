@extends('layouts.admin')
@section('title', 'تصنيفات الخدمات')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">تصنيفات الخدمات</h1>
        <p class="text-sm mt-1" style="color:#888">
            أسماء الأقسام (ليزر، بشرة، مساج…) — تظهر في <strong>تعديل الخدمة</strong> وفي فلتر «اختاري ما يناسبك».
            <a href="{{ route('admin.home-service-filters') }}" class="font-bold" style="color:#c9888e">إعدادات الفلتر</a>
        </p>
    </div>
    <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" class="btn-primary">
        + تصنيف جديد
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

<div class="space-y-4">
    @forelse($categories as $cat)
    <div class="bg-white rounded-2xl p-5 shadow-sm flex flex-wrap gap-4 items-start"
         style="border-right:4px solid {{ $cat->is_active ? '#e8b4b8' : '#e5e7eb' }}">
        <div class="flex-1 min-w-[200px]">
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="font-black text-lg" style="color:#1a1a1a">{{ $cat->label }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-bold"
                      style="background:{{ $cat->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $cat->is_active ? '#059669' : '#dc2626' }}">
                    {{ $cat->is_active ? 'نشط' : 'معطّل' }}
                </span>
            </div>
            <div class="text-xs" style="color:#888">
                المعرّف: <code style="background:#f5f0f0; padding:2px 6px; border-radius:4px">{{ $cat->slug }}</code>
                — {{ $cat->servicesCount() }} خدمة
                — ترتيب {{ $cat->sort_order }}
            </div>
        </div>

        <form action="{{ route('admin.service-categories.update', $cat) }}" method="POST" class="flex-1 min-w-[280px] space-y-3">
            @csrf
            @method('PUT')
            <input type="text" name="label" value="{{ old('label', $cat->label) }}" class="form-input text-sm" placeholder="اسم التصنيف" required>
            <div class="flex gap-2 flex-wrap items-center">
                <input type="number" name="sort_order" value="{{ old('sort_order', $cat->sort_order) }}" class="form-input text-sm w-24" min="0" max="999" placeholder="ترتيب">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" {{ $cat->is_active ? 'checked' : '' }} style="accent-color:#c9888e">
                    نشط
                </label>
                <button type="submit" class="btn-primary text-sm py-2 px-4">حفظ</button>
            </div>
        </form>

        <div class="flex gap-2">
            <form action="{{ route('admin.service-categories.toggle', $cat) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold" style="background:#fef9c3; color:#d97706">
                    {{ $cat->is_active ? 'إيقاف' : 'تفعيل' }}
                </button>
            </form>
            <form action="{{ route('admin.service-categories.destroy', $cat) }}" method="POST"
                  onsubmit="return confirm('حذف تصنيف «{{ addslashes($cat->label) }}»؟')">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold" style="background:#fee2e2; color:#dc2626">حذف</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-16 rounded-2xl bg-white" style="color:#888">لا توجد تصنيفات</div>
    @endforelse
</div>

<div id="addCategoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl">
        <h2 class="text-xl font-black mb-6">إضافة تصنيف</h2>
        <form action="{{ route('admin.service-categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">اسم التصنيف (عربي) *</label>
                <input type="text" name="label" value="{{ old('label') }}" class="form-input" required placeholder="مثال: حمام مغربي">
            </div>
            <div>
                <label class="form-label">المعرّف (إنجليزي — اختياري)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="form-input" placeholder="مثال: hammam" pattern="[a-z0-9_]+" dir="ltr">
                <p class="text-xs mt-1" style="color:#888">حروف صغيرة a-z وأرقام و _ فقط. يُولَّد تلقائياً إن تُرك فارغاً.</p>
            </div>
            <div>
                <label class="form-label">ترتيب العرض</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0" max="999">
            </div>
            <label class="flex items-center gap-2 text-sm font-bold">
                <input type="checkbox" name="is_active" value="1" checked style="accent-color:#c9888e">
                نشط — يظهر في الفلتر والحجز
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">إضافة</button>
                <button type="button" class="flex-1 py-3 rounded-xl font-bold" style="background:#f5f0f0; color:#666"
                        onclick="document.getElementById('addCategoryModal').classList.add('hidden')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@endsection
