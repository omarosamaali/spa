@extends('layouts.admin')
@section('title', 'واتساب تلقائي - NAY SPA')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">رسائل واتساب التلقائية</h1>
    <p class="text-sm" style="color:#888">إرسال رسالة للعميلة على رقمها بعد الحجز وعند التأكيد — عبر WhatsApp Business API (Meta)</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl font-bold text-sm" style="background:#d1fae5; color:#059669">{{ session('success') }}</div>
@endif

<div class="mb-6 p-5 rounded-2xl text-sm leading-relaxed" style="background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af">
    <strong>مهم:</strong> الإرسال التلقائي يحتاج حساب
    <a href="https://developers.facebook.com/" target="_blank" rel="noopener" class="underline font-bold">Meta for Developers</a>
    + رقم واتساب أعمال + <strong>قوالب رسائل معتمدة</strong> (مرة واحدة للمراجعة).
    بدون الإعداد، الحجز يشتغل عادي لكن الرسالة لن تُرسل.
</div>

<form action="{{ route('admin.whatsapp-settings.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="whatsapp_api_enabled" value="1" class="w-5 h-5 rounded" style="accent-color:#c9888e"
                   {{ old('whatsapp_api_enabled', $settings['whatsapp_api_enabled']) === '1' ? 'checked' : '' }}>
            <span class="font-bold" style="color:#1a1a1a">تفعيل الإرسال التلقائي</span>
        </label>

        <div>
            <label class="form-label">Access Token (من Meta)</label>
            <input type="password" name="whatsapp_api_token" value="{{ old('whatsapp_api_token', $settings['whatsapp_api_token']) }}"
                   class="form-input" dir="ltr" placeholder="EAAxxxx..." autocomplete="off">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">Phone Number ID</label>
                <input type="text" name="whatsapp_phone_number_id" value="{{ old('whatsapp_phone_number_id', $settings['whatsapp_phone_number_id']) }}"
                       class="form-input" dir="ltr" placeholder="1234567890">
            </div>
            <div>
                <label class="form-label">إصدار API</label>
                <input type="text" name="whatsapp_api_version" value="{{ old('whatsapp_api_version', $settings['whatsapp_api_version'] ?: 'v21.0') }}"
                       class="form-input" dir="ltr">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">أسماء القوالب في Meta</h2>
        <p class="text-sm" style="color:#888">يجب إنشاء قالبين بالعربية في Meta Business → WhatsApp → Message templates</p>

        <div class="p-4 rounded-xl text-sm font-mono leading-relaxed" style="background:#f9f5f5; color:#444; direction:ltr; text-align:left">
            <div class="mb-4">
                <strong>Template 1:</strong> booking_received (عند الحجز)<br>
                Body: مرحباً {{1}}، {{2}} لخدمة {{3}} بتاريخ {{4}} الساعة {{5}}. رقم الحجز: {{6}}.
            </div>
            <div>
                <strong>Template 2:</strong> booking_confirmed (عند التأكيد من لوحة الحجوزات)<br>
                Body: مرحباً {{1}}، {{2}} لخدمة {{3}} بتاريخ {{4}} الساعة {{5}}. رقم الحجز: {{6}}.
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="form-label">قالب «استلام الحجز»</label>
                <input type="text" name="whatsapp_template_received" class="form-input" dir="ltr"
                       value="{{ old('whatsapp_template_received', $settings['whatsapp_template_received']) }}">
            </div>
            <div>
                <label class="form-label">قالب «تأكيد الحجز»</label>
                <input type="text" name="whatsapp_template_confirmed" class="form-input" dir="ltr"
                       value="{{ old('whatsapp_template_confirmed', $settings['whatsapp_template_confirmed']) }}">
            </div>
            <div>
                <label class="form-label">لغة القالب</label>
                <input type="text" name="whatsapp_template_lang" class="form-input" dir="ltr"
                       value="{{ old('whatsapp_template_lang', $settings['whatsapp_template_lang'] ?: 'ar') }}" placeholder="ar">
            </div>
        </div>

        <p class="text-xs" style="color:#888">
            المتغيرات: {{1}} الاسم · {{2}} نص الحالة · {{3}} الخدمة · {{4}} التاريخ · {{5}} الوقت · {{6}} رقم الحجز
        </p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">رسالة تجريبية</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
            <div>
                <label class="form-label">رقم للاختبار (أرقام فقط مع مفتاح الدولة)</label>
                <input type="text" name="test_phone" class="form-input" dir="ltr" placeholder="9647xxxxxxxxx"
                       value="{{ old('test_phone') }}">
            </div>
            <label class="flex items-center gap-2 text-sm cursor-pointer pb-2">
                <input type="checkbox" name="send_test" value="1" style="accent-color:#c9888e">
                إرسال تجريبي عند الحفظ
            </label>
        </div>
    </div>

    <button type="submit" class="btn-primary">حفظ الإعدادات</button>
</form>

<div class="mt-8 p-5 rounded-2xl text-sm" style="background:#fff; border:1px solid #eee">
    <h3 class="font-black mb-3" style="color:#1a1a1a">متى تُرسل الرسالة؟</h3>
    <ul class="space-y-2 list-disc pr-5" style="color:#666">
        <li><strong>فور الحجز</strong> من الموقع → قالب booking_received</li>
        <li><strong>عند تغيير الحالة إلى «مؤكد»</strong> من لوحة الحجوزات → قالب booking_confirmed</li>
    </ul>
</div>

@endsection
