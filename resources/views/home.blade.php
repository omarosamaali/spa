@extends('layouts.app')

@section('title', 'NAY SPA - جمالك يستحق العناية')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')

{{-- =================== HERO SLIDER =================== --}}
<section class="relative overflow-hidden" style="height:100vh; min-height:600px;">

    <div class="swiper hero-swiper" style="height:100%;">
        <div class="swiper-wrapper">

            {{-- Slide 1 – Laser / Facial --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=1920&q=80&auto=format&fit=crop"
                         alt="جلسة ليزر" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(26,10,14,0.85) 0%, rgba(26,10,14,0.5) 50%, rgba(61,43,46,0.7) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-2xl hero-slide-content">
                            <div class="badge-spa mb-5 inline-flex opacity-0" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.35)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                أحدث تقنيات • أفضل تجربة
                            </div>
                            <h1 class="font-black text-white mb-5 opacity-0" style="font-size:clamp(2.4rem,5vw,3.8rem); line-height:1.15;">
                                جمالك يبدأ<br><span style="color:#e8b4b8;">بتجربة حجز ذكية</span>
                            </h1>
                            <p class="text-lg mb-10 opacity-0" style="color:rgba(255,255,255,0.8); max-width:500px; line-height:1.7;">
                                احجزي موعدك الآن واستمتعي<br>بتجربة فاخرة وآمنة
                            </p>
                            <div class="flex flex-wrap gap-4 opacity-0">
                                <a href="{{ route('booking') }}" class="btn-primary text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي موعدك الآن
                                </a>
                                <a href="{{ route('contact') }}" class="btn-outline text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    تواصلي معنا
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 – Massage / Spa --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=1920&q=80&auto=format&fit=crop"
                         alt="مساج احترافي" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(10,20,30,0.88) 0%, rgba(10,20,30,0.5) 55%, rgba(20,40,50,0.75) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-2xl hero-slide-content">
                            <div class="badge-spa mb-5 inline-flex opacity-0" style="background:rgba(201,169,110,0.15); color:#c9a96e; border-color:rgba(201,169,110,0.35)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                استرخاء تام • تجديد الحيوية
                            </div>
                            <h1 class="font-black text-white mb-5 opacity-0" style="font-size:clamp(2.4rem,5vw,3.8rem); line-height:1.15;">
                                جلسات مساج<br><span style="color:#c9a96e;">تُذيب كل التعب</span>
                            </h1>
                            <p class="text-lg mb-10 opacity-0" style="color:rgba(255,255,255,0.8); max-width:500px; line-height:1.7;">
                                جلسات علاجية وترفيهية متخصصة<br>لتجديد الطاقة والراحة التامة
                            </p>
                            <div class="flex flex-wrap gap-4 opacity-0">
                                <a href="{{ route('booking') }}" class="btn-primary text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('services') }}" class="btn-outline text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                                    جميع الخدمات
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 – Nails / Beauty --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?w=1920&q=80&auto=format&fit=crop"
                         alt="تصميم أظافر" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(30,10,20,0.87) 0%, rgba(30,10,20,0.5) 55%, rgba(61,20,40,0.7) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-2xl hero-slide-content">
                            <div class="badge-spa mb-5 inline-flex opacity-0" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.35)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                أناقة • إبداع • تميّز
                            </div>
                            <h1 class="font-black text-white mb-5 opacity-0" style="font-size:clamp(2.4rem,5vw,3.8rem); line-height:1.15;">
                                أظافر تُحكي<br><span style="color:#e8b4b8;">قصة جمالك</span>
                            </h1>
                            <p class="text-lg mb-10 opacity-0" style="color:rgba(255,255,255,0.8); max-width:500px; line-height:1.7;">
                                أحدث ستايلات وأرقى التصاميم<br>مع خبيرات متخصصات
                            </p>
                            <div class="flex flex-wrap gap-4 opacity-0">
                                <a href="{{ route('booking') }}" class="btn-primary text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('contact') }}" class="btn-outline text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    تواصلي معنا
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 4 – Video --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0 overflow-hidden">
                    <video class="hero-slide-video" autoplay muted loop playsinline preload="none"
                           poster="https://images.unsplash.com/photo-1552693673-1bf958298935?w=1920&q=60&auto=format&fit=crop">
                        <source src="https://videos.pexels.com/video-files/3760529/3760529-hd_1920_1080_25fps.mp4" type="video/mp4">
                    </video>
                    <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(20,10,15,0.85) 0%, rgba(20,10,15,0.45) 55%, rgba(40,20,30,0.7) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-2xl hero-slide-content">
                            <div class="badge-spa mb-5 inline-flex opacity-0" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.35)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                تجربة NAY SPA الفعلية
                            </div>
                            <h1 class="font-black text-white mb-5 opacity-0" style="font-size:clamp(2.4rem,5vw,3.8rem); line-height:1.15;">
                                شاهدي الفرق<br><span style="color:#e8b4b8;">بنفسك</span>
                            </h1>
                            <p class="text-lg mb-10 opacity-0" style="color:rgba(255,255,255,0.8); max-width:500px; line-height:1.7;">
                                نقدم لك أفضل تجربة تجميل<br>في بيئة مريحة وفاخرة
                            </p>
                            <div class="flex flex-wrap gap-4 opacity-0">
                                <a href="{{ route('booking') }}" class="btn-primary text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('contact') }}" class="btn-outline text-base px-7 py-3.5">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    تواصلي معنا
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /swiper-wrapper --}}

        {{-- Navigation --}}
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        {{-- Pagination --}}
        <div class="swiper-pagination" style="bottom:30px;"></div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-16 left-1/2 -translate-x-1/2 z-20 hidden md:flex flex-col items-center gap-2 opacity-60">
            <div class="text-white text-xs tracking-widest" style="font-size:0.7rem;">SCROLL</div>
            <div style="width:1px; height:40px; background:linear-gradient(to bottom, white, transparent);"></div>
        </div>
    </div>

    {{-- Stats overlay at bottom --}}
    <div class="absolute bottom-0 left-0 right-0 z-20" style="background:linear-gradient(to top, rgba(26,26,26,1) 0%, transparent 100%); height:120px; pointer-events:none;"></div>
</section>

{{-- =================== STATS BAR =================== --}}
<section style="background:#1a1a1a; padding:2.5rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="stat-card text-center">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:rgba(232,180,184,0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#e8b4b8;">
                    {{ $stats['clients'] > 0 ? '+' . $stats['clients'] : '+500' }}
                </div>
                <div class="text-sm" style="color:rgba(255,255,255,0.5);">عميلة راضية</div>
            </div>

            <div class="stat-card text-center">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:rgba(201,169,110,0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2" stroke-linecap="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9a96e;">{{ $stats['years'] }}+</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.5);">سنوات خبرة</div>
            </div>

            <div class="stat-card text-center">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:rgba(232,180,184,0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#e8b4b8;">{{ $stats['services'] > 0 ? $stats['services'] . '+' : '15+' }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.5);">خدمة متميزة</div>
            </div>

            <div class="stat-card text-center">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:rgba(201,169,110,0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9a96e;">{{ $stats['rating'] }}%</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.5);">رضا العميلات</div>
            </div>

        </div>
    </div>
</section>

{{-- =================== SERVICES SECTION =================== --}}
<section class="py-20 reveal" style="background:#1a1a1a;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">خدماتنا</div>
            <h2 class="text-3xl md:text-4xl font-black mb-4 text-white">خدمات تجميل متكاملة</h2>
            <p class="mb-4" style="color:rgba(255,255,255,0.5); max-width:520px; margin:0 auto;">نقدم لك أفضل الخدمات بأعلى معايير الجودة والعناية</p>
            <div class="section-divider mt-4"></div>
        </div>

        {{-- Services grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            @forelse($services as $service)
            <div class="service-card text-center group">
                <div class="relative overflow-hidden" style="height:170px;">
                    @if($service->image)
                        <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        @php
                        $serviceImages = [
                            'laser'   => 'https://images.unsplash.com/photo-1559599101-f09722fb4948?w=400&h=300&q=75&auto=format&fit=crop',
                            'skin'    => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=400&h=300&q=75&auto=format&fit=crop',
                            'botox'   => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=400&h=300&q=75&auto=format&fit=crop',
                            'massage' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400&h=300&q=75&auto=format&fit=crop',
                            'nails'   => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=400&h=300&q=75&auto=format&fit=crop',
                        ];
                        $img = $serviceImages[$service->category ?? ''] ?? $serviceImages['skin'];
                        @endphp
                        <img src="{{ $img }}" alt="{{ $service->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @endif
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,26,26,0.9) 0%, transparent 60%);"></div>
                    <div class="absolute bottom-3 right-3 text-white font-black text-base">{{ $service->name }}</div>
                </div>
                <div class="p-4">
                    <p class="text-xs mb-3 leading-relaxed" style="color:rgba(255,255,255,0.55);">{{ $service->description }}</p>
                    @if($service->price)
                    <div class="text-sm font-bold mb-3" style="color:#e8b4b8;">{{ number_format($service->price) }} د.ع</div>
                    @endif
                    <a href="{{ route('booking', ['service_id' => $service->id]) }}"
                       class="btn-primary text-xs w-full justify-center" style="padding:0.5rem 1rem">
                        احجزي الآن
                    </a>
                </div>
            </div>
            @empty
            @foreach([
                ['name'=>'الليزر',         'cat'=>'laser',   'price'=>'150', 'desc'=>'إزالة الشعر بتقنيات حديثة آمنة وفعالة'],
                ['name'=>'البشرة',         'cat'=>'skin',    'price'=>'120', 'desc'=>'جلسات تنظيف ونضارة وتثبيت البشرة'],
                ['name'=>'المساج',         'cat'=>'massage', 'price'=>'100', 'desc'=>'استرخاء تام وتجديد الحيوية'],
                ['name'=>'البوتوكس والفيلر','cat'=>'botox',   'price'=>'300', 'desc'=>'إبراز جمالك بشكل طبيعي وآمن'],
                ['name'=>'الأظافر',        'cat'=>'nails',   'price'=>'80',  'desc'=>'تصميم الأظافر بأحدث الستايلات'],
            ] as $s)
            @php
            $imgs = [
                'laser'   => 'https://images.unsplash.com/photo-1559599101-f09722fb4948?w=400&h=300&q=75&auto=format&fit=crop',
                'skin'    => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=400&h=300&q=75&auto=format&fit=crop',
                'massage' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400&h=300&q=75&auto=format&fit=crop',
                'botox'   => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=400&h=300&q=75&auto=format&fit=crop',
                'nails'   => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=400&h=300&q=75&auto=format&fit=crop',
            ];
            @endphp
            <div class="service-card text-center group">
                <div class="relative overflow-hidden" style="height:170px;">
                    <img src="{{ $imgs[$s['cat']] }}" alt="{{ $s['name'] }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,26,26,0.9) 0%, transparent 60%);"></div>
                    <div class="absolute bottom-3 right-3 text-white font-black text-base">{{ $s['name'] }}</div>
                </div>
                <div class="p-4">
                    <p class="text-xs mb-3 leading-relaxed" style="color:rgba(255,255,255,0.55);">{{ $s['desc'] }}</p>
                    <div class="text-sm font-bold mb-3" style="color:#e8b4b8;">{{ $s['price'] }} د.ع</div>
                    <a href="{{ route('booking') }}" class="btn-primary text-xs w-full justify-center" style="padding:0.5rem 1rem">احجزي الآن</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('services') }}" class="btn-outline" style="color:#e8b4b8; border-color:rgba(232,180,184,0.4);">
                عرض جميع الخدمات
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =================== HOW TO BOOK SECTION =================== --}}
<section class="py-20 reveal relative overflow-hidden" style="background:#131313;">
    <div class="absolute inset-0 opacity-30" style="background-image:radial-gradient(circle at 20% 50%, rgba(232,180,184,0.06) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(201,169,110,0.06) 0%, transparent 50%);"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4" style="background:rgba(232,180,184,0.12); color:#e8b4b8; border-color:rgba(232,180,184,0.3);">خطوات الحجز</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">احجزي موعدك بسهولة</h2>
            <div class="section-divider mb-4"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0 relative">
            @foreach([
                ['num'=>'1','title'=>'اختاري الخدمة','desc'=>'اختاري الخدمة التي تناسب احتياجاتك','svg'=>'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
                ['num'=>'2','title'=>'اختري الوقت','desc'=>'اختري اليوم والوقت المناسب لك','svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                ['num'=>'3','title'=>'بياناتك','desc'=>'أدخلي بياناتك للتأكيد على الحجز','svg'=>'<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                ['num'=>'4','title'=>'تم الحجز','desc'=>'تم حجز موعدك بنجاح، ننتظرك','svg'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            ] as $i => $step)
            <div class="flex flex-col items-center text-center text-white relative">
                @if($i < 3)
                <div class="absolute hidden md:block" style="top:32px; right:0; width:50%; z-index:0; height:2px; background:linear-gradient(to left, transparent, rgba(232,180,184,0.4)); margin-right:50%;"></div>
                @endif
                <div class="step-icon-wrap mb-4 relative z-10">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $step['svg'] !!}
                    </svg>
                </div>
                <div class="text-xs font-bold mb-1 px-3 py-0.5 rounded-full" style="background:rgba(232,180,184,0.1); color:#e8b4b8; border:1px solid rgba(232,180,184,0.2);">
                    {{ $step['num'] }}
                </div>
                <h3 class="text-base font-black mt-2 mb-2">{{ $step['title'] }}</h3>
                <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,0.5); max-width:140px;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-14">
            <a href="{{ route('booking') }}" class="btn-primary text-lg px-10 py-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                ابدئي حجزك الآن
            </a>
        </div>
    </div>
</section>

{{-- =================== FEATURES SECTION =================== --}}
<section class="py-20 reveal" style="background:#1e1e1e;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">لماذا نحن</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">نقدم أكثر من مجرد خدمة</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['title'=>'تغطية شاملة','desc'=>'منتجات علاجية بمقاييس عالمية 100%','svg'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','color'=>'#e8b4b8'],
                ['title'=>'منتجات عالية الجودة','desc'=>'أفضل المنتجات العالمية المعتمدة','svg'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>','color'=>'#c9a96e'],
                ['title'=>'رعاية مخصصة','desc'=>'عناية تناسب احتياجاتك الشخصية','svg'=>'<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>','color'=>'#e8b4b8'],
                ['title'=>'خصوصية تامة','desc'=>'سرية ذاتية وبال مرتاح دائماً','svg'=>'<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>','color'=>'#c9a96e'],
            ] as $f)
            <div class="rounded-2xl p-7 text-center group transition-all duration-300 hover:-translate-y-1"
                 style="background:#2a2a2a; border:1px solid rgba(255,255,255,0.05);">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5 transition-transform duration-300 group-hover:scale-110"
                     style="background:rgba({{ $f['color'] === '#e8b4b8' ? '232,180,184' : '201,169,110' }},0.12);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="{{ $f['color'] }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        {!! $f['svg'] !!}
                    </svg>
                </div>
                <h3 class="font-black text-white mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5);">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =================== TESTIMONIALS SECTION =================== --}}
<section class="py-20 reveal" style="background:#131313;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">آراء عملائنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">ثقتكم هي سر نجاحنا</h2>
            <div class="section-divider mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($testimonials as $t)
            <div class="testimonial-card">
                <div class="mb-4" style="color:rgba(232,180,184,0.35);">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p class="leading-relaxed mb-6 text-sm" style="color:rgba(255,255,255,0.7);">{{ $t->content }}</p>
                <div class="flex items-center gap-4 justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/60?u={{ urlencode($t->client_name) }}"
                             alt="{{ $t->client_name }}"
                             class="w-12 h-12 rounded-full object-cover"
                             style="border:2px solid rgba(232,180,184,0.3);"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="w-12 h-12 rounded-full items-center justify-center text-white font-bold text-lg hidden"
                             style="background:linear-gradient(135deg,#e8b4b8,#c9888e); display:none;">
                            {{ mb_substr($t->client_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-sm text-white">{{ $t->client_name }}</div>
                            @if($t->client_city)
                            <div class="text-xs" style="color:rgba(255,255,255,0.4);">{{ $t->client_city }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-0.5">
                        @for($i=0;$i<($t->rating ?? 5);$i++)
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
            @empty
            @foreach([
                ['name'=>'سارة','city'=>'بغداد','text'=>'أفضل تجربة ليزر، المكان نظيف والعاملات راقيات جداً','stars'=>5,'av'=>1],
                ['name'=>'نور','city'=>'النجف','text'=>'جلسات البشرة غيّرت بشرتي ١٨٠ درجة، أنصح الجميع','stars'=>5,'av'=>5],
                ['name'=>'رنا','city'=>'البصرة','text'=>'خدمة ممتازة ونتائج رائعة، سأعود دائماً','stars'=>5,'av'=>9],
            ] as $t)
            <div class="testimonial-card">
                <div class="mb-4" style="color:rgba(232,180,184,0.35);">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p class="leading-relaxed mb-6 text-sm" style="color:rgba(255,255,255,0.7);">{{ $t['text'] }}</p>
                <div class="flex items-center gap-4 justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/60?img={{ $t['av'] }}"
                             alt="{{ $t['name'] }}"
                             class="w-12 h-12 rounded-full object-cover"
                             style="border:2px solid rgba(232,180,184,0.3);">
                        <div>
                            <div class="font-bold text-sm text-white">{{ $t['name'] }}</div>
                            <div class="text-xs" style="color:rgba(255,255,255,0.4);">{{ $t['city'] }}</div>
                        </div>
                    </div>
                    <div class="flex gap-0.5">
                        @for($i=0;$i<$t['stars'];$i++)<svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor
                    </div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- =================== CTA SECTION =================== --}}
<section class="py-20 relative overflow-hidden" style="background:linear-gradient(135deg,#1a1a1a 0%,#3d2b2e 60%,#2a1a1e 100%);">
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 50% 50%, rgba(232,180,184,0.08) 0%, transparent 70%);"></div>
    <div class="absolute inset-0" style="background-image:radial-gradient(circle, rgba(232,180,184,0.06) 1px, transparent 1px); background-size:40px 40px;"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <div class="badge-spa mb-6 inline-flex" style="background:rgba(232,180,184,0.12); color:#e8b4b8; border-color:rgba(232,180,184,0.25);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            عرض خاص
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-white mb-4">جاهزة لتجربة الفرق؟</h2>
        <p class="text-lg mb-10" style="color:rgba(255,255,255,0.65);">احجزي موعدك الآن واستمتعي بخصم 10% على أول زيارة</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('booking') }}" class="px-10 py-4 rounded-full font-black text-lg transition-all hover:scale-105"
               style="background:white; color:#c9888e; box-shadow:0 8px 30px rgba(0,0,0,0.3);">
                <span class="flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    احجزي الآن
                </span>
            </a>
            <a href="https://wa.me/9647701234567" class="btn-whatsapp px-8 py-4 text-lg">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                تواصلي معنا
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        speed: 900,
        autoplay: {
            delay: 5500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        on: {
            slideChangeTransitionStart() {
                // Autoplay video on slide 4 (index 3)
                const active = this.slides[this.activeIndex];
                const video = active?.querySelector('video');
                if (video) video.play().catch(() => {});
            }
        }
    });

    // Scroll reveal
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(el => {
            if (el.isIntersecting) {
                el.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
</script>
@endpush

@endsection
