@extends('layouts.app')
@section('title', 'تواصل معنا - NAY SPA')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">تواصلي معنا</div>
    <h1 class="text-4xl font-black text-white mb-3">نحن هنا لك</h1>
    <p style="color:rgba(255,255,255,0.65)">تواصلي معنا في أي وقت ونرد عليك في أسرع وقت ممكن</p>
</div>

<section class="py-20" style="background:#fdf8f5">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-8 p-5 rounded-2xl flex items-center gap-4" style="background:#d1fae5; border:1px solid #6ee7b7">
        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background:#059669">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="font-black" style="color:#059669">تم الإرسال بنجاح</div>
            <div class="text-sm mt-0.5" style="color:#047857">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    {{-- Contact Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
        <a href="tel:+9647701234567" class="bg-white rounded-2xl p-6 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-md no-underline" style="display:block">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.8 19.79 19.79 0 01.22 2.18 2 2 0 012.22 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/></svg>
            </div>
            <h3 class="font-black mb-1" style="color:#1a1a1a">اتصلي بنا</h3>
            <p class="text-sm" style="color:#c9888e; direction:ltr">+964 770 123 4567</p>
        </a>

        <a href="https://wa.me/9647701234567" target="_blank" class="bg-white rounded-2xl p-6 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-md no-underline" style="display:block">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:linear-gradient(135deg,#dcfce7,#86efac)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#16a34a"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            </div>
            <h3 class="font-black mb-1" style="color:#1a1a1a">واتساب</h3>
            <p class="text-sm" style="color:#16a34a; direction:ltr">+964 770 123 4567</p>
        </a>

        <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:linear-gradient(135deg,#fef9c3,#fde047)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h3 class="font-black mb-1" style="color:#1a1a1a">الموقع</h3>
            <p class="text-sm" style="color:#888">بغداد - المنصور - شارع 14 رمضان</p>
        </div>
    </div>

    {{-- Main Grid: Form + Map --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Contact Form --}}
        <div class="lg:col-span-3 bg-white rounded-3xl p-8 shadow-sm">
            <h2 class="text-2xl font-black mb-2" style="color:#1a1a1a">أرسلي رسالتك</h2>
            <p class="text-sm mb-8" style="color:#888">سنرد عليك خلال 24 ساعة</p>

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">
                            الاسم الكامل <span style="color:#c9888e">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-input @error('name') border-red-400 @enderror"
                               placeholder="اسمك الكامل">
                        @error('name')
                        <p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">
                            رقم الهاتف <span style="color:#c9888e">*</span>
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               class="form-input @error('phone') border-red-400 @enderror"
                               placeholder="07XX XXX XXXX" dir="ltr">
                        @error('phone')
                        <p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input @error('email') border-red-400 @enderror"
                           placeholder="example@email.com" dir="ltr">
                    @error('email')
                    <p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">
                        الموضوع <span style="color:#c9888e">*</span>
                    </label>
                    <select name="subject" class="form-input @error('subject') border-red-400 @enderror">
                        <option value="">اختاري الموضوع</option>
                        <option value="استفسار عن خدمة" {{ old('subject') == 'استفسار عن خدمة' ? 'selected' : '' }}>استفسار عن خدمة</option>
                        <option value="حجز موعد" {{ old('subject') == 'حجز موعد' ? 'selected' : '' }}>حجز موعد</option>
                        <option value="استفسار عن الأسعار" {{ old('subject') == 'استفسار عن الأسعار' ? 'selected' : '' }}>استفسار عن الأسعار</option>
                        <option value="شكوى" {{ old('subject') == 'شكوى' ? 'selected' : '' }}>شكوى</option>
                        <option value="اقتراح" {{ old('subject') == 'اقتراح' ? 'selected' : '' }}>اقتراح</option>
                        <option value="أخرى" {{ old('subject') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                    @error('subject')
                    <p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">
                        الرسالة <span style="color:#c9888e">*</span>
                    </label>
                    <textarea name="message" rows="5"
                              class="form-input @error('message') border-red-400 @enderror"
                              placeholder="اكتبي رسالتك هنا...">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>
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
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="font-black" style="color:#1a1a1a">ساعات العمل</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2" style="border-bottom:1px solid #f5f0f0">
                        <span class="text-sm font-bold" style="color:#1a1a1a">السبت — الخميس</span>
                        <span class="text-sm" style="color:#c9888e; direction:ltr">10:00 ص — 10:00 م</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-bold" style="color:#1a1a1a">الجمعة</span>
                        <span class="text-sm" style="color:#c9888e; direction:ltr">2:00 م — 10:00 م</span>
                    </div>
                </div>
            </div>

            {{-- Quick Booking CTA --}}
            <div class="rounded-2xl p-6 text-white text-center" style="background:linear-gradient(135deg,#1a1a1a,#3d2b2e)">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(232,180,184,0.15)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="font-black mb-2">جاهزة للحجز؟</h3>
                <p class="text-sm mb-5" style="color:rgba(255,255,255,0.65)">احجزي موعدك مباشرة بدون انتظار</p>
                <a href="{{ route('booking') }}" class="btn-primary w-full justify-center">
                    احجزي الآن
                </a>
            </div>

            {{-- Social --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="font-black mb-4" style="color:#1a1a1a">تابعينا</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="flex items-center gap-2 p-3 rounded-xl transition-all hover:opacity-80 no-underline" style="background:#fdf0f4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#e1306c"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="white"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                        <span class="text-xs font-bold" style="color:#e1306c">Instagram</span>
                    </a>
                    <a href="#" class="flex items-center gap-2 p-3 rounded-xl transition-all hover:opacity-80 no-underline" style="background:#f0f4ff">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#1877f2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span class="text-xs font-bold" style="color:#1877f2">Facebook</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
</section>

@endsection
