@extends('layouts.admin')
@section('title', 'إعدادات التواصل')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">إعدادات التواصل والسوشيال</h1>
    <p class="text-sm" style="color:#888">كل ما يظهر في صفحة «تواصل معنا»، الفوتر، وزر الواتساب العائم</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl font-bold text-sm" style="background:#d1fae5; color:#059669">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.contact-settings.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- اتصلي بنا --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">اتصلي بنا</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">رقم الهاتف (للعرض) <span style="color:#dc2626">*</span></label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['phone']) }}"
                       class="form-input @error('contact_phone') border-red-500 @enderror" dir="ltr"
                       placeholder="+964 770 123 4567">
                @error('contact_phone')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">رقم الاتصال (أرقام فقط — اختياري)</label>
                <input type="text" name="contact_phone_raw" value="{{ old('contact_phone_raw', $settings['phone_raw']) }}"
                       class="form-input" dir="ltr" placeholder="9647701234567">
                <p class="text-xs mt-1" style="color:#888">لرابط الاتصال المباشر. اتركيه فارغاً ليُستخرج من رقم العرض</p>
            </div>
        </div>
    </div>

    {{-- واتساب --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">واتساب</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">رقم واتساب (للعرض)</label>
                <input type="text" name="contact_whatsapp_phone" value="{{ old('contact_whatsapp_phone', $settings['whatsapp_phone']) }}"
                       class="form-input" dir="ltr" placeholder="+964 770 123 4567">
                <p class="text-xs mt-1" style="color:#888">يظهر في بطاقة واتساب. اتركيه فارغاً ليطابق رقم الهاتف</p>
            </div>
            <div>
                <label class="form-label">رقم واتساب (أرقام فقط — wa.me)</label>
                <input type="text" name="contact_whatsapp_raw" value="{{ old('contact_whatsapp_raw', $settings['whatsapp_raw']) }}"
                       class="form-input" dir="ltr" placeholder="9647701234567">
                <p class="text-xs mt-1" style="color:#888">يبدأ بـ 964 بدون +. فارغ = نفس رقم الاتصال</p>
            </div>
        </div>
        <div>
            <label class="form-label">رسالة واتساب الافتراضية</label>
            <textarea name="whatsapp_default_text" rows="2" class="form-input"
                      placeholder="مرحباً، أريد الاستفسار عن خدمات NAY SPA">{{ old('whatsapp_default_text', $settings['whatsapp_text']) }}</textarea>
            <p class="text-xs mt-1" style="color:#888">تُفتح مع زر الواتساب العائم أسفل الموقع</p>
        </div>
        <div class="p-3 rounded-xl text-sm" style="background:#f0fdf4" dir="ltr">
            <span class="font-bold" style="color:#059669">معاينة:</span>
            <a href="{{ $c['whatsapp_url'] }}" target="_blank" class="block truncate" style="color:#128c7e">{{ $c['whatsapp_url'] }}</a>
        </div>
    </div>

    {{-- الموقع وساعات العمل --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">الموقع وساعات العمل</h2>
        <div>
            <label class="form-label">العنوان <span style="color:#dc2626">*</span></label>
            <input type="text" name="contact_address" value="{{ old('contact_address', $settings['address']) }}"
                   class="form-input @error('contact_address') border-red-500 @enderror"
                   placeholder="بغداد - المنصور - شارع 14 رمضان">
            @error('contact_address')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">السبت — الخميس <span style="color:#dc2626">*</span></label>
                <input type="text" name="contact_hours_weekdays"
                       value="{{ old('contact_hours_weekdays', $settings['hours_weekdays']) }}"
                       class="form-input" placeholder="10:00 ص — 10:00 م">
            </div>
            <div>
                <label class="form-label">الجمعة <span style="color:#dc2626">*</span></label>
                <input type="text" name="contact_hours_friday"
                       value="{{ old('contact_hours_friday', $settings['hours_friday']) }}"
                       class="form-input" placeholder="2:00 م — 10:00 م">
            </div>
        </div>
        <div>
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['email']) }}"
                   class="form-input" dir="ltr" placeholder="info@nayspa.iq">
            @error('contact_email')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- تابعينا --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">تابعينا — روابط السوشيال</h2>
        <p class="text-sm" style="color:#888">اتركي الحقل فارغاً لإخفاء المنصة من الموقع</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">Instagram</label>
                <input type="text" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']) }}"
                       class="form-input" dir="ltr" placeholder="https://instagram.com/nayspa">
            </div>
            <div>
                <label class="form-label">Facebook</label>
                <input type="text" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']) }}"
                       class="form-input" dir="ltr" placeholder="https://facebook.com/nayspa">
            </div>
            <div>
                <label class="form-label">TikTok</label>
                <input type="text" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok']) }}"
                       class="form-input" dir="ltr" placeholder="https://tiktok.com/@nayspa">
            </div>
            <div>
                <label class="form-label">Snapchat</label>
                <input type="text" name="social_snapchat" value="{{ old('social_snapchat', $settings['social_snapchat']) }}"
                       class="form-input" dir="ltr" placeholder="https://snapchat.com/add/nayspa">
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary px-10 py-3 text-base">
        حفظ كل الإعدادات
    </button>
</form>

@endsection
