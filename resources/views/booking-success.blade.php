@extends('layouts.app')

@section('title', 'تم الحجز بنجاح - NAY SPA')

@section('content')

<div class="page-header">
    <h1 class="text-4xl font-black text-white">✅ تم الحجز بنجاح</h1>
</div>

<section class="py-20" style="background:#fdf8f5">
<div class="max-w-2xl mx-auto px-4 text-center">

    <div class="bg-white rounded-3xl p-10 shadow-xl" style="box-shadow:0 20px 60px rgba(232,180,184,0.15)">
        <div class="text-7xl mb-6 animate-float">🌸</div>
        <h2 class="text-2xl font-black mb-3" style="color:#1a1a1a">مرحباً {{ $appointment->client_name }}!</h2>
        <p class="text-lg mb-8" style="color:#666">تم استلام حجزك بنجاح. سيتم التواصل معك عبر واتساب لتأكيد الموعد.</p>

        {{-- Booking details --}}
        <div class="rounded-2xl p-6 mb-8 text-right" style="background:#fdf8f5">
            <h3 class="font-black mb-4" style="color:#1a1a1a; font-size:1.1rem">تفاصيل الحجز</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2" style="border-bottom:1px solid #f0dde0">
                    <span style="color:#888">رقم الحجز</span>
                    <span class="font-bold" style="color:#c9888e">#{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between items-center py-2" style="border-bottom:1px solid #f0dde0">
                    <span style="color:#888">الخدمة</span>
                    <span class="font-bold">{{ $appointment->service->name ?? '' }}</span>
                </div>
                <div class="flex justify-between items-center py-2" style="border-bottom:1px solid #f0dde0">
                    <span style="color:#888">التاريخ</span>
                    <span class="font-bold">{{ $appointment->appointment_date->format('Y/m/d') }}</span>
                </div>
                <div class="flex justify-between items-center py-2" style="border-bottom:1px solid #f0dde0">
                    <span style="color:#888">الوقت</span>
                    <span class="font-bold">{{ substr($appointment->appointment_time, 0, 5) }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span style="color:#888">الحالة</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold" style="background:#fef9c3; color:#ca8a04">⏳ في الانتظار</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/9647701234567?text=مرحبا، حجزت موعد برقم%20%23{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}"
               class="btn-whatsapp justify-center">
                💬 تواصلي معنا
            </a>
            <a href="{{ route('home') }}" class="btn-primary justify-center">
                🏠 العودة للرئيسية
            </a>
        </div>
    </div>
</div>
</section>
@endsection
