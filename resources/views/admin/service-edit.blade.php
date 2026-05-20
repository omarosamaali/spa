@extends('layouts.admin')
@section('title', 'تعديل الخدمة - NAY SPA')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.services') }}" class="text-sm font-bold transition-all hover:opacity-70" style="color:#888">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline; vertical-align:middle"><polyline points="15 18 9 12 15 6"/></svg>
        الخدمات
    </a>
    <span style="color:#ccc">/</span>
    <span class="text-sm font-bold" style="color:#1a1a1a">تعديل: {{ $service->name }}</span>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <h1 class="text-xl font-black mb-6" style="color:#1a1a1a">تعديل الخدمة</h1>

        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">اسم الخدمة <span style="color:#c9888e">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-input @error('name') border-red-400 @enderror" required>
                    @error('name')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">الأيقونة (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="form-input" placeholder="✨" maxlength="5">
                </div>
            </div>

            <div>
                <label class="form-label">الوصف <span style="color:#c9888e">*</span></label>
                <textarea name="description" rows="3" class="form-input @error('description') border-red-400 @enderror" required>{{ old('description', $service->description) }}</textarea>
                @error('description')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">السعر (د.ع)</label>
                    <input type="number" name="price" value="{{ old('price', $service->price) }}" class="form-input" min="0" step="500" placeholder="0">
                </div>
                <div>
                    <label class="form-label">مدة الجلسة (دقيقة) <span style="color:#c9888e">*</span></label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" class="form-input" min="5" max="480" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="form-label">التصنيف</label>
                    <select name="category" class="form-input">
                        <option value="">بدون تصنيف</option>
                        @foreach(['laser'=>'ليزر','skin'=>'بشرة','botox'=>'بوتوكس وفيلر','massage'=>'مساج','nails'=>'أظافر','hair'=>'شعر','makeup'=>'مكياج','other'=>'أخرى'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $service->category) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="form-input" min="0">
                </div>
            </div>

            <div>
                <label class="form-label">صورة الخدمة</label>
                @if($service->image)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/'.$service->image) }}" alt="" class="w-20 h-20 object-cover rounded-xl">
                    <span class="text-xs" style="color:#888">الصورة الحالية — رفع صورة جديدة يستبدلها</span>
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.5rem">
            </div>

            <div class="flex items-center gap-3 py-3 px-4 rounded-xl" style="background:#f9f5f5">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="w-5 h-5 rounded" style="accent-color:#c9888e"
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="font-bold cursor-pointer" style="color:#1a1a1a">الخدمة نشطة (تظهر في الموقع)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    حفظ التعديلات
                </button>
                <a href="{{ route('admin.services') }}" class="btn-outline" style="color:#555; border-color:#ddd">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection
