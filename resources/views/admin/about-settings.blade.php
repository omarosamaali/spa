@extends('layouts.admin')
@section('title', 'إعدادات عن المركز')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">إعدادات عن المركز</h1>
    <p class="text-sm" style="color:#888">قسم «من نحن» والأرقام في صفحة <a href="{{ route('about') }}" target="_blank" class="font-bold" style="color:#c9888e">عن المركز</a></p>
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

<form action="{{ route('admin.about-settings.update') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">من نحن</h2>
        <p class="text-sm" style="color:#888">النص والصورة بجانب قسم «من نحن» في صفحة عن المركز.</p>

        <div>
            <label class="form-label">الشارة الصغيرة *</label>
            <input type="text" name="about_who_badge" class="form-input @error('about_who_badge') border-red-400 @enderror"
                   value="{{ old('about_who_badge', $settings['about_who_badge']) }}" required>
            @error('about_who_badge')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">العنوان الرئيسي *</label>
            <textarea name="about_who_title" rows="2" class="form-input @error('about_who_title') border-red-400 @enderror" required
                      placeholder="سطر جديد = سطر ثاني في العنوان">{{ old('about_who_title', $settings['about_who_title']) }}</textarea>
            <p class="text-xs mt-1" style="color:#888">مثال: مركز تجميل متكامل — ثم سطر جديد — يهتم بكل تفصيلة</p>
            @error('about_who_title')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">الفقرة الأولى *</label>
            <textarea name="about_who_text_1" rows="4" class="form-input @error('about_who_text_1') border-red-400 @enderror" required>{{ old('about_who_text_1', $settings['about_who_text_1']) }}</textarea>
            @error('about_who_text_1')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">الفقرة الثانية (اختياري)</label>
            <textarea name="about_who_text_2" rows="4" class="form-input">{{ old('about_who_text_2', $settings['about_who_text_2']) }}</textarea>
        </div>

        <div>
            <label class="form-label">صورة القسم</label>
            <p class="text-sm mb-2" style="color:#888">يفضّل صورة عمودية أو مربعة للمركز (حتى 4 ميجا). بدون صورة يظهر الشعار الزخرفي.</p>

            @if($aboutWho['has_image'])
            <div class="mb-3">
                <img src="{{ $aboutWho['image_url'] }}" alt="" class="w-full max-w-sm h-52 object-cover rounded-xl">
                <label class="flex items-center gap-2 mt-3 text-sm cursor-pointer" style="color:#dc2626">
                    <input type="checkbox" name="remove_about_who_image" value="1"> حذف الصورة الحالية
                </label>
            </div>
            @endif

            <input type="file" name="about_who_image" accept="image/jpeg,image/png,image/webp" class="form-input" style="padding:0.5rem">
            @error('about_who_image')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">سنوات الخبرة</h2>
        <p class="text-sm" style="color:#888">يظهر في مربع «سنوات خبرة» أسفل قسم من نحن.</p>

        <div>
            <label class="form-label">عدد السنوات *</label>
            <input type="number" name="about_years_experience" class="form-input @error('about_years_experience') border-red-400 @enderror"
                   value="{{ old('about_years_experience', $years) }}" min="1" max="99" required>
            @error('about_years_experience')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>

        <p class="text-xs p-3 rounded-xl" style="background:#fdf8f5; color:#666">
            المعروض للزائر: <strong>{{ old('about_years_experience', $years) }}+</strong> سنوات خبرة
        </p>
    </div>

    <button type="submit" class="btn-primary">حفظ كل الإعدادات</button>
</form>

@endsection
