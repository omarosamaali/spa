@extends('layouts.admin')
@section('title', 'تعديل الأخصائية - NAY SPA')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.staff') }}" class="text-sm font-bold" style="color:#888">← الأخصائيات</a>
    <span style="color:#ccc">/</span>
    <span class="text-sm font-bold" style="color:#1a1a1a">{{ $staff->name }}</span>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl p-8 shadow-sm">
        <h1 class="text-xl font-black mb-6" style="color:#1a1a1a">تعديل الأخصائية</h1>

        <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">الاسم <span style="color:#c9888e">*</span></label>
                <input type="text" name="name" value="{{ old('name', $staff->name) }}" class="form-input @error('name') border-red-400 @enderror" required>
                @error('name')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">التخصص / المسمى</label>
                <input type="text" name="role" value="{{ old('role', $staff->role) }}" class="form-input"
                       placeholder="مثال: أخصائية الليزر والبشرة">
            </div>

            <div>
                <label class="form-label">نبذة قصيرة (اختياري)</label>
                <textarea name="bio" rows="4" class="form-input">{{ old('bio', $staff->bio) }}</textarea>
            </div>

            <div>
                <label class="form-label">صورة</label>
                @if($staff->image)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/'.$staff->image) }}" alt="" class="w-20 h-20 object-cover rounded-xl">
                    <span class="text-xs" style="color:#888">الصورة الحالية</span>
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.5rem">
            </div>

            <div class="flex items-center gap-3 py-3 px-4 rounded-xl" style="background:#f9f5f5">
                <input type="checkbox" name="is_active" id="staff_is_active" value="1"
                       class="w-5 h-5 rounded" style="accent-color:#c9888e"
                       {{ old('is_active', $staff->is_active) ? 'checked' : '' }}>
                <label for="staff_is_active" class="font-bold cursor-pointer" style="color:#1a1a1a">نشطة (تظهر في نموذج الحجز)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
                <a href="{{ route('admin.staff') }}" class="btn-outline" style="color:#555; border-color:#ddd">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection
