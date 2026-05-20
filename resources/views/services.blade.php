@extends('layouts.app')

@section('title', 'خدماتنا - NAY SPA')

@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8">ما نقدمه</div>
    <h1 class="text-4xl font-black text-white mb-3">خدماتنا</h1>
    <p style="color:rgba(255,255,255,0.65)">أحدث تقنيات التجميل بأيدي خبيرات متخصصات</p>
</div>

<section class="py-20" style="background:#fdf8f5">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $service)
        <div class="service-card">
            <div class="relative overflow-hidden" style="height:200px; background:linear-gradient(135deg,#f5dfe1,#fdf0f2)">
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-7xl opacity-30">{{ $service->icon ?? '✨' }}</div>
                </div>
                <div class="absolute top-4 right-4 w-12 h-12 rounded-full flex items-center justify-center text-2xl"
                     style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                    {{ $service->icon ?? '✨' }}
                </div>
                @if($service->duration_minutes)
                <div class="absolute bottom-4 left-4 text-xs px-3 py-1 rounded-full font-bold"
                     style="background:rgba(26,26,26,0.7); color:white">
                    ⏱ {{ $service->duration_minutes }} دقيقة
                </div>
                @endif
            </div>
            <div class="p-6">
                <h3 class="text-xl font-black mb-2" style="color:#1a1a1a">{{ $service->name }}</h3>
                <p class="leading-relaxed mb-4" style="color:#666">{{ $service->description }}</p>
                <div class="flex items-center justify-between">
                    @if($service->price)
                    <div class="text-xl font-black" style="color:#c9888e">{{ number_format($service->price) }} <span class="text-sm">د.ع</span></div>
                    @endif
                    <a href="{{ route('booking', ['service_id' => $service->id]) }}" class="btn-primary">
                        احجزي الآن
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</section>
@endsection
