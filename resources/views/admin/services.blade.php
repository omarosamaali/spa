@extends('layouts.admin')
@section('title', 'الخدمات - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <h1 class="text-2xl font-black" style="color:#1a1a1a">الخدمات</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        إضافة خدمة جديدة
    </button>
</div>

{{-- Services Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($services as $service)
    <div class="bg-white rounded-2xl p-5 shadow-sm transition-all hover:shadow-md" style="border-right:4px solid {{ $service->is_active ? '#e8b4b8' : '#e5e7eb' }}">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl"
                     style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                    {{ $service->icon ?? '✨' }}
                </div>
                <div>
                    <div class="font-black" style="color:#1a1a1a">{{ $service->name }}</div>
                    <div class="text-xs" style="color:#888">{{ $service->duration_minutes }} دقيقة</div>
                </div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full font-bold"
                  style="background:{{ $service->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $service->is_active ? '#059669' : '#dc2626' }}">
                {{ $service->is_active ? 'نشط' : 'معطل' }}
            </span>
        </div>

        <p class="text-sm mb-3 leading-relaxed" style="color:#666">{{ $service->description }}</p>

        @if($service->price)
        <div class="font-black mb-4" style="color:#c9888e">{{ number_format($service->price) }} د.ع</div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-2 pt-3" style="border-top:1px solid #f5f0f0">
            {{-- Edit --}}
            <a href="{{ route('admin.services.edit', $service) }}"
               class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold transition-all hover:opacity-80"
               style="background:#dbeafe; color:#2563eb">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                تعديل
            </a>

            {{-- Toggle active --}}
            <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all hover:opacity-80"
                        style="background:{{ $service->is_active ? '#fef9c3' : '#d1fae5' }}; color:{{ $service->is_active ? '#d97706' : '#059669' }}">
                    @if($service->is_active)
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18.36 6.64a9 9 0 11-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                    إيقاف
                    @else
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    تفعيل
                    @endif
                </button>
            </form>

            {{-- Delete --}}
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                  onsubmit="return confirm('هل تريد حذف خدمة {{ addslashes($service->name) }}؟')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all hover:opacity-80"
                        style="background:#fee2e2; color:#dc2626">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                    حذف
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

{{-- Add Service Modal --}}
<div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,0.6); backdrop-filter:blur(4px)">
    <div class="bg-white rounded-3xl p-8 w-full shadow-2xl overflow-y-auto" style="max-width:600px; max-height:90vh">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-black" style="color:#1a1a1a">إضافة خدمة جديدة</h2>
            <button onclick="document.getElementById('addModal').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl flex items-center justify-center transition-all hover:opacity-70"
                    style="background:#f5f5f5; color:#888">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">اسم الخدمة <span style="color:#c9888e">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input @error('name') border-red-400 @enderror" required>
                    @error('name')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">الأيقونة (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" class="form-input" placeholder="✨" maxlength="5">
                </div>
            </div>

            <div>
                <label class="form-label">الوصف <span style="color:#c9888e">*</span></label>
                <textarea name="description" rows="3" class="form-input @error('description') border-red-400 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">السعر (د.ع)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-input" min="0" step="500" placeholder="0">
                </div>
                <div>
                    <label class="form-label">مدة الجلسة (دقيقة) <span style="color:#c9888e">*</span></label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" class="form-input" min="5" max="480" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">التصنيف</label>
                    <select name="category" class="form-input">
                        <option value="">بدون تصنيف</option>
                        @foreach(['laser'=>'ليزر','skin'=>'بشرة','botox'=>'بوتوكس وفيلر','massage'=>'مساج','nails'=>'أظافر','hair'=>'شعر','makeup'=>'مكياج','other'=>'أخرى'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
                </div>
            </div>

            <div>
                <label class="form-label">صورة الخدمة</label>
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.5rem">
            </div>

            <div class="flex items-center gap-3 py-3 px-4 rounded-xl" style="background:#f9f5f5">
                <input type="checkbox" name="is_active" id="new_is_active" value="1"
                       class="w-5 h-5 rounded" style="accent-color:#c9888e" checked>
                <label for="new_is_active" class="font-bold cursor-pointer" style="color:#1a1a1a">الخدمة نشطة (تظهر في الموقع)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة الخدمة
                </button>
                <button type="button"
                        onclick="document.getElementById('addModal').classList.add('hidden')"
                        class="btn-outline" style="color:#555; border-color:#ddd">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Close modal on backdrop click
    document.getElementById('addModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });

    // Re-open modal if there are validation errors (old input present)
    @if($errors->any() && old('name') !== null)
    document.getElementById('addModal').classList.remove('hidden');
    @endif
</script>
@endpush

@endsection
