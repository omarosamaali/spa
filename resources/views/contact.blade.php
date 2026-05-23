@extends('layouts.app')
@section('title', 'تواصل معنا - NAY SPA')
@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">تواصلي معنا</div>
    <h1 class="text-4xl font-black text-white mb-3">نحن هنا لك</h1>
    <p style="color:rgba(255,255,255,0.65)">تواصلي معنا في أي وقت ونرد عليك في أسرع وقت ممكن</p>
</div>

<section class="py-20" style="background:#1a1a1a">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-8 p-5 rounded-2xl flex items-center gap-4"
         style="background:rgba(5,150,105,0.15); border:1px solid rgba(5,150,105,0.35)">
        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background:#059669">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="font-black text-white">تم الإرسال بنجاح</div>
            <div class="text-sm mt-0.5" style="color:rgba(255,255,255,0.6)">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    {{-- Contact Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
        <a href="{{ $siteContact['tel_url'] }}"
           class="rounded-2xl p-6 text-center transition-all hover:-translate-y-1 no-underline block"
           style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(232,180,184,0.1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.8 19.79 19.79 0 01.22 2.18 2 2 0 012.22 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/></svg>
            </div>
            <h3 class="font-black mb-1 text-white">اتصلي بنا</h3>
            <p class="text-sm" style="color:#e8b4b8; direction:ltr">{{ $siteContact['phone'] }}</p>
        </a>

        <a href="{{ $siteContact['whatsapp_url_plain'] }}" target="_blank" rel="noopener"
           class="rounded-2xl p-6 text-center transition-all hover:-translate-y-1 no-underline block"
           style="background:#2a2a2a; border:1px solid rgba(37,211,102,0.2)">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(37,211,102,0.1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#25d366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            </div>
            <h3 class="font-black mb-1 text-white">واتساب</h3>
            <p class="text-sm" style="color:#25d366; direction:ltr">{{ $siteContact['whatsapp_phone'] }}</p>
        </a>

        <div class="rounded-2xl p-6 text-center"
             style="background:#2a2a2a; border:1px solid rgba(201,169,110,0.15)">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(201,169,110,0.1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h3 class="font-black mb-1 text-white">الموقع</h3>
            <p class="text-sm" style="color:rgba(255,255,255,0.5)">{{ $siteContact['address'] }}</p>
        </div>
    </div>

    {{-- Main Grid: Form + Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Contact Form --}}
        <div class="lg:col-span-3 rounded-3xl p-8"
             style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
            <h2 class="text-2xl font-black mb-2 text-white">أرسلي رسالتك</h2>
            <p class="text-sm mb-8" style="color:rgba(255,255,255,0.45)">سنرد عليك خلال 24 ساعة</p>

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="booking-label">الاسم الكامل <span style="color:#e8b4b8">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="booking-input @error('name') border-red-500 @enderror"
                               placeholder="اسمك الكامل">
                        @error('name')
                        <p class="text-xs mt-1" style="color:#fca5a5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="booking-label">رقم الهاتف <span style="color:#e8b4b8">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               class="booking-input @error('phone') border-red-500 @enderror"
                               placeholder="07XX XXX XXXX" dir="ltr">
                        @error('phone')
                        <p class="text-xs mt-1" style="color:#fca5a5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="booking-label">البريد الإلكتروني <span style="color:rgba(255,255,255,0.4); font-weight:400;">(اختياري)</span></label>
                    <input type="text" name="email" value="{{ old('email') }}"
                           class="booking-input @error('email') border-red-500 @enderror"
                           placeholder="example@email.com"
                           inputmode="email" autocomplete="email"
                           style="direction:ltr; text-align:left; color:#fff;">
                    @error('email')
                    <p class="text-xs mt-1" style="color:#fca5a5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="booking-label">الموضوع <span style="color:#e8b4b8">*</span></label>
                    <select name="subject" class="booking-input @error('subject') border-red-500 @enderror">
                        <option value="">اختاري الموضوع</option>
                        <option value="استفسار عن خدمة" {{ old('subject') == 'استفسار عن خدمة' ? 'selected' : '' }}>استفسار عن خدمة</option>
                        <option value="حجز موعد" {{ old('subject') == 'حجز موعد' ? 'selected' : '' }}>حجز موعد</option>
                        <option value="استفسار عن الأسعار" {{ old('subject') == 'استفسار عن الأسعار' ? 'selected' : '' }}>استفسار عن الأسعار</option>
                        <option value="شكوى" {{ old('subject') == 'شكوى' ? 'selected' : '' }}>شكوى</option>
                        <option value="اقتراح" {{ old('subject') == 'اقتراح' ? 'selected' : '' }}>اقتراح</option>
                        <option value="أخرى" {{ old('subject') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                    @error('subject')
                    <p class="text-xs mt-1" style="color:#fca5a5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="booking-label">الرسالة <span style="color:#e8b4b8">*</span></label>
                    <textarea name="message" rows="5"
                              class="booking-input @error('message') border-red-500 @enderror"
                              placeholder="اكتبي رسالتك هنا...">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-xs mt-1" style="color:#fca5a5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full justify-center text-base py-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    إرسال الرسالة
                </button>
            </form>
        </div>

        {{-- Side Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Working Hours --}}
            <div class="rounded-2xl p-6" style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                         style="background:rgba(232,180,184,0.1)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="font-black text-white">ساعات العمل</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2"
                         style="border-bottom:1px solid rgba(255,255,255,0.07)">
                        <span class="text-sm font-bold text-white">السبت — الخميس</span>
                        <span class="text-sm" style="color:#e8b4b8; direction:ltr">{{ $siteContact['hours_weekdays'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-bold text-white">الجمعة</span>
                        <span class="text-sm" style="color:#e8b4b8; direction:ltr">{{ $siteContact['hours_friday'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Booking CTA --}}
            <div class="rounded-2xl p-6 text-white text-center"
                 style="background:linear-gradient(135deg,#1a1a1a,#3d2b2e); border:1px solid rgba(232,180,184,0.15)">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                     style="background:rgba(232,180,184,0.12)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="font-black mb-2">جاهزة للحجز؟</h3>
                <p class="text-sm mb-5" style="color:rgba(255,255,255,0.55)">احجزي موعدك مباشرة بدون انتظار</p>
                <a href="{{ route('booking') }}" class="btn-primary w-full justify-center">
                    احجزي الآن
                </a>
            </div>

            @if(count($siteContact['social'] ?? []) > 0)
            <div class="rounded-2xl p-6" style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
                <h3 class="font-black mb-4 text-white">تابعينا</h3>
                @include('partials.social-links', ['variant' => 'contact'])
            </div>
            @endif

        </div>
    </div>

</div>
</section>

@endsection
