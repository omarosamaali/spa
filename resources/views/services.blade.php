@extends('layouts.app')

@section('title', 'خدماتنا - NAY SPA')

@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">ما نقدمه</div>
    <h1 class="text-4xl font-black text-white mb-3">خدماتنا</h1>
    <p style="color:rgba(255,255,255,0.65)">أحدث تقنيات التجميل بأيدي خبيرات متخصصات</p>
</div>

<section class="py-20" style="background:#1a1a1a">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    @if($services->isEmpty())
    <p class="text-center py-16" style="color:rgba(255,255,255,0.5)">لا توجد خدمات متاحة حالياً.</p>
    @else
    <div class="services-grid-home services-grid-page">
        @foreach($services as $service)
        @include('partials.service-card-home', [
            'img' => $service->displayImageUrl(),
            'name' => $service->name,
            'icon' => $service->icon,
            'desc' => $service->description,
            'price' => $service->price,
            'duration' => $service->duration_minutes,
            'category' => $service->category ?? 'all',
            'bookingUrl' => route('booking', ['service_id' => $service->id]),
            'variant' => 'page',
        ])
        @endforeach
    </div>
    @endif

    <div class="text-center mt-12">
        <a href="{{ route('booking') }}" class="btn-primary text-base px-8 py-4">
            احجزي موعدك الآن
        </a>
    </div>
</div>
</section>
@endsection
