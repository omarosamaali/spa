@extends('layouts.admin')
@section('title', 'بطاقة العرض - NAY SPA')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">بطاقة «جاهزة للتجربة؟»</h1>
    <p class="text-sm" style="color:#888">البانر الوردي في الصفحة الرئيسية — الصورة، النصوص، الخصم، وزر الحجز</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl font-bold text-sm" style="background:#d1fae5; color:#059669">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.promo-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="promo_active" value="1" class="w-5 h-5 rounded" style="accent-color:#c9888e"
                   {{ old('promo_active', $settings['promo_active']) === '1' ? 'checked' : '' }}>
            <span class="font-bold" style="color:#1a1a1a">إظهار البطاقة في الصفحة الرئيسية</span>
        </label>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">صورة الخلفية</h2>
        <p class="text-sm" style="color:#888">تظهر على يسار البطاقة بشكل شفاف. يفضّل صورة أفقية للسبا أو العلاجات.</p>

        @if($promo['has_image'])
        <div class="mb-3">
            <img src="{{ $promo['image_url'] }}" alt="" class="w-full max-w-md h-40 object-cover rounded-xl">
            <label class="flex items-center gap-2 mt-3 text-sm cursor-pointer" style="color:#dc2626">
                <input type="checkbox" name="remove_promo_image" value="1"> حذف الصورة الحالية
            </label>
        </div>
        @else
        <div class="mb-3 p-4 rounded-xl text-sm" style="background:#f9f5f5; color:#888">
            لا توجد صورة مرفوعة — تُستخدم صورة افتراضية حتى ترفعي صورتكم.
        </div>
        @endif

        <input type="file" name="promo_image" accept="image/jpeg,image/png,image/webp" class="form-input" style="padding:0.5rem">
        @error('promo_image')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">النصوص</h2>
        <div>
            <label class="form-label">الشارة الصغيرة (مثال: عرض خاص لأول مرة)</label>
            <input type="text" name="promo_badge" value="{{ old('promo_badge', $settings['promo_badge']) }}" class="form-input">
        </div>
        <div>
            <label class="form-label">العنوان الرئيسي <span style="color:#dc2626">*</span></label>
            <input type="text" name="promo_title" value="{{ old('promo_title', $settings['promo_title']) }}" class="form-input @error('promo_title') border-red-500 @enderror" required>
            @error('promo_title')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">سطر ١</label>
                <input type="text" name="promo_line1" value="{{ old('promo_line1', $settings['promo_line1']) }}" class="form-input" placeholder="احجزي موعدك الآن">
            </div>
            <div>
                <label class="form-label">سطر ٢</label>
                <input type="text" name="promo_line2" value="{{ old('promo_line2', $settings['promo_line2']) }}" class="form-input" placeholder="واستمتعي بتجربة عناية فاخرة">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">الخصم</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="form-label">نسبة الخصم</label>
                <input type="text" name="promo_discount" value="{{ old('promo_discount', $settings['promo_discount']) }}" class="form-input" placeholder="15%">
            </div>
            <div>
                <label class="form-label">وصف الخصم</label>
                <input type="text" name="promo_discount_label" value="{{ old('promo_discount_label', $settings['promo_discount_label']) }}" class="form-input" placeholder="خصم خاص">
            </div>
            <div>
                <label class="form-label">تفاصيل إضافية</label>
                <input type="text" name="promo_discount_note" value="{{ old('promo_discount_note', $settings['promo_discount_note']) }}" class="form-input">
            </div>
        </div>
        <p class="text-xs" style="color:#888">اتركي «نسبة الخصم» فارغة لإخفاء جزء الخصم بالكامل.</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">زر الحجز</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">نص الزر <span style="color:#dc2626">*</span></label>
                <input type="text" name="promo_button_text" value="{{ old('promo_button_text', $settings['promo_button_text']) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">رابط الزر (اختياري)</label>
                <input type="text" name="promo_button_url" value="{{ old('promo_button_url', $settings['promo_button_url']) }}" class="form-input" dir="ltr"
                       placeholder="/booking">
                <p class="text-xs mt-1" style="color:#888">فارغ = صفحة الحجز. يمكنكِ وضع رابط واتساب أو أي صفحة.</p>
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary">حفظ التغييرات</button>
</form>

@endsection
