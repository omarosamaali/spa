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

            {{-- Slide 1 – VIDEO (Spa Ambiance – first thing visitors see) --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0 overflow-hidden">
                    <video class="hero-slide-video" autoplay muted loop playsinline preload="auto"
                           poster="https://images.unsplash.com/photo-1583416750470-965b2707b355?w=1920&q=60&auto=format&fit=crop">
                        <source src="https://videos.pexels.com/video-files/3209828/3209828-hd_1920_1080_25fps.mp4" type="video/mp4">
                        <source src="https://videos.pexels.com/video-files/3214436/3214436-hd_1920_1080_25fps.mp4" type="video/mp4">
                    </video>
                    <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(18,8,14,0.88) 0%,rgba(18,8,14,0.42) 55%,rgba(40,18,28,0.75) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <div class="badge-spa mb-5 inline-flex" style="background:rgba(232,180,184,0.15);color:#e8b4b8;border-color:rgba(232,180,184,0.35);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                تجربة NAY SPA الفعلية
                            </div>
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                اكتشفي<br><span style="color:#e8b4b8;">عالم الفخامة</span>
                            </h1>
                            <p class="mb-3" style="color:rgba(255,255,255,0.75);font-size:1rem;line-height:1.7;">تجربة سبا فاخرة في أجواء هادئة ومريحة</p>
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                <a href="{{ route('booking') }}" class="btn-primary">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي موعدك الآن
                                </a>
                                <a href="https://wa.me/9647701234567" class="btn-outline">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                                    تواصل معنا
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 – Luxury Spa Interior --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1583416750470-965b2707b355?w=1920&q=80&auto=format&fit=crop"
                         alt="مركز ناي سبا" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(20,8,12,0.9) 0%,rgba(20,8,12,0.5) 55%,rgba(50,30,35,0.75) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <div class="badge-spa mb-5 inline-flex" style="background:rgba(232,180,184,0.15);color:#e8b4b8;border-color:rgba(232,180,184,0.35);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                أحدث تقنيات • أفضل تجربة
                            </div>
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                جمالك<br>يبدأ <span style="color:#e8b4b8;">هنا</span>
                            </h1>
                            <p class="mb-3" style="color:rgba(255,255,255,0.75);font-size:1rem;line-height:1.7;">منصة حجز ذكية لجميع خدمات التجميل والعناية</p>
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                <a href="{{ route('booking') }}" class="btn-primary">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('services') }}" class="btn-outline">جميع الخدمات</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 – Spa Candles & Stones (NO body) --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1508380702597-707c1b00695c?w=1920&q=80&auto=format&fit=crop"
                         alt="جلسات استرخاء" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(10,18,28,0.9) 0%,rgba(10,18,28,0.5) 55%,rgba(20,35,50,0.78) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <div class="badge-spa mb-5 inline-flex" style="background:rgba(201,169,110,0.15);color:#c9a96e;border-color:rgba(201,169,110,0.35);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                استرخاء تام • تجديد الحيوية
                            </div>
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                جلسات<br><span style="color:#c9a96e;">تُجدد طاقتك</span>
                            </h1>
                            <p class="mb-3" style="color:rgba(255,255,255,0.75);font-size:1rem;">جلسات علاجية وترفيهية لتجديد الطاقة والراحة التامة</p>
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                <a href="{{ route('booking') }}" class="btn-primary">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('services') }}" class="btn-outline">جميع الخدمات</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 4 – Spa Products --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1556760544-74068565f05c?w=1920&q=80&auto=format&fit=crop"
                         alt="منتجات العناية" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(28,8,18,0.9) 0%,rgba(28,8,18,0.5) 55%,rgba(55,18,35,0.78) 100%);"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <div class="badge-spa mb-5 inline-flex" style="background:rgba(232,180,184,0.15);color:#e8b4b8;border-color:rgba(232,180,184,0.35);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                منتجات فاخرة • نتائج مذهلة
                            </div>
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                منتجات<br><span style="color:#e8b4b8;">تُعنى بك</span>
                            </h1>
                            <p class="mb-3" style="color:rgba(255,255,255,0.75);font-size:1rem;">أفضل منتجات العناية العالمية لنتائج مضمونة</p>
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                <a href="{{ route('booking') }}" class="btn-primary">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    احجزي الآن
                                </a>
                                <a href="{{ route('contact') }}" class="btn-outline">تواصلي معنا</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination" style="bottom:28px;"></div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none" style="background:linear-gradient(to top,rgba(26,26,26,1) 0%,transparent 100%);height:100px;"></div>
</section>

{{-- =================== STATS BAR =================== --}}
<section style="background:#1a1a1a;padding:2.5rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;" class="md:grid-cols-4">
            @foreach([
                ['val'=> ($stats['clients']>0 ? '+'.$stats['clients'] : '+500'), 'label'=>'جلسة مكتملة',  'icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>','c'=>'#e8b4b8'],
                ['val'=> '4.9',                                                  'label'=>'تقييم العملاء','icon'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>','c'=>'#c9a96e'],
                ['val'=> '10+',                                                  'label'=>'خبراء متخصصين','icon'=>'<circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0112 0v2"/>','c'=>'#e8b4b8'],
                ['val'=> '100%',                                                 'label'=>'رضا العميلات', 'icon'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>','c'=>'#c9a96e'],
            ] as $s)
            <div class="stat-card text-center">
                <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;background:rgba({{ $s['c']==='#e8b4b8'?'232,180,184':'201,169,110' }},0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $s['c'] }}" stroke-width="2" stroke-linecap="round">{!! $s['icon'] !!}</svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:{{ $s['c'] }};">{{ $s['val'] }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.5);">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =================== SERVICES + CATEGORY TABS =================== --}}
<section class="py-20" style="background:#1a1a1a;" id="services-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <div class="badge-spa mb-4">خدماتنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-2">اختاري ما يناسبك</h2>
            <p class="text-sm mb-6" style="color:rgba(255,255,255,0.45);">تصفحي خدماتنا واختاري الخدمة التي تناسبك</p>
            <div class="section-divider"></div>
        </div>

        {{-- Category Tabs --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10" id="cat-tabs">
            @php $cats = ['all'=>'الكل','laser'=>'الليزر','skin'=>'البشرة','massage'=>'المساج','botox'=>'البوتوكس','nails'=>'الأظافر']; @endphp
            @foreach($cats as $key => $label)
            <button onclick="filterServices('{{ $key }}')" data-cat="{{ $key }}"
                    class="cat-tab px-5 py-2 rounded-full text-sm font-bold transition-all duration-200"
                    style="{{ $key==='all' ? 'background:linear-gradient(135deg,#e8b4b8,#c9888e);color:white;' : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.65);border:1px solid rgba(255,255,255,0.1);' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Services Grid --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;" class="md:grid-cols-4" id="services-grid">
            @php
            $sImgs = [
                'laser'   => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=500&h=350&q=75&auto=format&fit=crop',
                'skin'    => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500&h=350&q=75&auto=format&fit=crop',
                'massage' => 'https://images.unsplash.com/photo-1563788240-4a32624c5e46?w=500&h=350&q=75&auto=format&fit=crop',
                'botox'   => 'https://images.unsplash.com/photo-1556760544-74068565f05c?w=500&h=350&q=75&auto=format&fit=crop',
                'nails'   => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500&h=350&q=75&auto=format&fit=crop',
            ];
            @endphp
            @forelse($services as $service)
            <div class="service-card group" data-category="{{ $service->category ?? 'all' }}">
                <div class="relative overflow-hidden" style="height:190px;">
                    @php $img = $service->image ? asset('storage/'.$service->image) : ($sImgs[$service->category??'']??$sImgs['skin']); @endphp
                    <img src="{{ $img }}" alt="{{ $service->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(26,26,26,0.95) 0%,transparent 55%);"></div>
                    <div class="absolute bottom-3 right-3 left-3">
                        <div class="font-black text-white text-sm">{{ $service->name }}</div>
                        @if($service->price)<div class="text-xs mt-0.5" style="color:#e8b4b8;">{{ number_format($service->price) }} د.ع</div>@endif
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs mb-4 leading-relaxed" style="color:rgba(255,255,255,0.5);">{{ $service->description }}</p>
                    <a href="{{ route('booking',['service_id'=>$service->id]) }}" class="btn-primary text-xs w-full justify-center" style="padding:0.5rem;">احجزي الآن</a>
                </div>
            </div>
            @empty
            @foreach([
                ['name'=>'جلسات الليزر',      'cat'=>'laser',   'price'=>'150','desc'=>'إزالة الشعر بتقنيات حديثة آمنة وفعالة'],
                ['name'=>'البشرة والنضارة',   'cat'=>'skin',    'price'=>'120','desc'=>'جلسات تنظيف ونضارة وتثبيت البشرة'],
                ['name'=>'مساج الجسم',        'cat'=>'massage', 'price'=>'100','desc'=>'استرخاء تام وتجديد الحيوية'],
                ['name'=>'البوتوكس والفيلر',  'cat'=>'botox',   'price'=>'300','desc'=>'إبراز جمالك بشكل طبيعي وآمن'],
                ['name'=>'الأظافر',           'cat'=>'nails',   'price'=>'80', 'desc'=>'تصميم الأظافر بأحدث الستايلات'],
                ['name'=>'تنظيف البشرة',      'cat'=>'skin',    'price'=>'90', 'desc'=>'جلسة تنظيف عميق وإشراق البشرة'],
                ['name'=>'إزالة الشعر',       'cat'=>'laser',   'price'=>'130','desc'=>'إزالة الشعر بتقنية الليزر الحديثة'],
                ['name'=>'علاجات الاسترخاء',  'cat'=>'massage', 'price'=>'110','desc'=>'جلسات استرخاء علاجية متخصصة'],
            ] as $s)
            <div class="service-card group" data-category="{{ $s['cat'] }}">
                <div class="relative overflow-hidden" style="height:190px;">
                    <img src="{{ $sImgs[$s['cat']] }}" alt="{{ $s['name'] }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(26,26,26,0.95) 0%,transparent 55%);"></div>
                    <div class="absolute bottom-3 right-3 left-3">
                        <div class="font-black text-white text-sm">{{ $s['name'] }}</div>
                        <div class="text-xs mt-0.5" style="color:#e8b4b8;">{{ $s['price'] }} د.ع</div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-xs mb-4 leading-relaxed" style="color:rgba(255,255,255,0.5);">{{ $s['desc'] }}</p>
                    <a href="{{ route('booking') }}" class="btn-primary text-xs w-full justify-center" style="padding:0.5rem;">احجزي الآن</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('services') }}" class="btn-outline" style="color:#e8b4b8;border-color:rgba(232,180,184,0.4);">
                عرض جميع الخدمات
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =================== BOOKING STEPS VERTICAL TIMELINE =================== --}}
<section class="py-20" style="background:#131313;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4" style="background:rgba(232,180,184,0.12);color:#e8b4b8;border-color:rgba(232,180,184,0.3);">خطوات الحجز</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">احجزي في 4 خطوات سهلة</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div class="relative">
            <div class="absolute hidden md:block" style="right:2.5rem;top:24px;bottom:24px;width:2px;background:linear-gradient(to bottom,rgba(232,180,184,0.6),rgba(232,180,184,0.1));border-radius:2px;"></div>

            @foreach([
                ['num'=>'01','title'=>'اختاري الخدمة','desc'=>'تصفحي خدماتنا واختاري ما يناسبك','svg'=>'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
                ['num'=>'02','title'=>'اختاري الوقت','desc'=>'حددي التاريخ والوقت المناسب لك','svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                ['num'=>'03','title'=>'بياناتك','desc'=>'أدخلي بياناتك للتأكيد','svg'=>'<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                ['num'=>'04','title'=>'تم الحجز','desc'=>'تم حجز موعدك بنجاح، نراكِ قريباً','svg'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            ] as $step)
            <div class="flex items-start gap-6 mb-10 last:mb-0 relative">
                <div class="relative flex-shrink-0 z-10">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:rgba(232,180,184,0.08);border:1px solid rgba(232,180,184,0.25);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="1.8" stroke-linecap="round">
                            {!! $step['svg'] !!}
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-3">
                    <div class="flex items-center gap-4 mb-2">
                        <h3 class="text-lg font-black text-white">{{ $step['title'] }}</h3>
                        <span class="text-3xl font-black" style="color:rgba(232,180,184,0.15);line-height:1;">{{ $step['num'] }}</span>
                    </div>
                    <p class="text-sm" style="color:rgba(255,255,255,0.5);">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('booking') }}" class="btn-primary text-lg px-10 py-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                احجزي الآن
            </a>
        </div>
    </div>
</section>

{{-- =================== WHY US - STATS 2x2 =================== --}}
<section class="py-20" style="background:#1e1e1e;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">لماذا نحن؟</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">تجربة تستحقينها</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            @foreach([
                ['val'=>($stats['clients']>0?'+'.$stats['clients']:'+500'),'label'=>'جلسة مكتملة',   'sub'=>'عميلة وثقت بنا','icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>','c'=>'#e8b4b8'],
                ['val'=>'4.9',                                              'label'=>'تقييم العملاء','sub'=>'من أصل 5 نجوم','icon'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>','c'=>'#c9a96e'],
                ['val'=>'10+',                                              'label'=>'خبراء متخصصين','sub'=>'فريق احترافي مدرّب','icon'=>'<circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0112 0v2"/>','c'=>'#c9a96e'],
                ['val'=>'100%',                                             'label'=>'رضا العملاء',  'sub'=>'ضماننا الدائم لكِ','icon'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','c'=>'#e8b4b8'],
            ] as $st)
            <div class="rounded-2xl p-7 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1"
                 style="background:#2a2a2a;border:1px solid rgba(255,255,255,0.06);">
                <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center"
                     style="background:rgba({{ $st['c']==='#e8b4b8'?'232,180,184':'201,169,110' }},0.1);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="{{ $st['c'] }}" stroke-width="1.8" stroke-linecap="round">{!! $st['icon'] !!}</svg>
                </div>
                <div>
                    <div class="text-3xl font-black leading-none" style="color:{{ $st['c'] }};">{{ $st['val'] }}</div>
                    <div class="font-bold text-white text-sm mt-1">{{ $st['label'] }}</div>
                    <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.4);">{{ $st['sub'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =================== CTA - ROSE CARD (no women image) =================== --}}
<section class="py-16" style="background:#1a1a1a;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl overflow-hidden relative" style="background:linear-gradient(135deg,#c9888e 0%,#e8b4b8 50%,#d4a0a5 100%);">
            <div class="absolute inset-0" style="background:radial-gradient(ellipse at 30% 50%, rgba(255,255,255,0.12) 0%, transparent 60%);"></div>
            {{-- Decorative spa image instead of woman --}}
            <div class="absolute inset-0 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1556760544-74068565f05c?w=800&h=400&q=60&auto=format&fit=crop"
                     alt="" class="absolute left-0 top-0 h-full w-1/2 object-cover opacity-20" style="object-position:center;">
            </div>
            <div class="relative z-10 p-10 lg:p-14 text-center md:text-right">
                <div class="text-xs font-bold mb-3 px-3 py-1 rounded-full inline-block" style="background:rgba(255,255,255,0.2);color:white;">عرض خاص لأول مرة</div>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-3 leading-tight">جاهزة للتجربة؟</h2>
                <p class="text-lg mb-2 text-white font-bold" style="opacity:0.9;">احجزي موعدك الآن</p>
                <p class="text-sm mb-3" style="color:rgba(255,255,255,0.8);">واستمتعي بتجربة عناية فاخرة</p>
                <div class="flex items-center justify-center md:justify-start gap-2 mb-8">
                    <span class="text-5xl font-black text-white">15%</span>
                    <div>
                        <div class="font-bold text-white text-sm">خصم خاص</div>
                        <div class="text-xs" style="color:rgba(255,255,255,0.8);">على جميع الخدمات للحجوزات الأولى</div>
                    </div>
                </div>
                <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-black text-base transition-all hover:scale-105"
                   style="background:#1a1a1a;color:white;box-shadow:0 8px 25px rgba(0,0,0,0.3);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    احجزي الآن
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =================== GALLERY (SPA INTERIORS ONLY) =================== --}}
<section class="py-20" style="background:#131313;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <div class="badge-spa mb-4">معرضنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">لحظات من العناية</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;" class="md:grid-cols-3">
            @foreach([
                ['url'=>'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'قاعة السبا الفاخرة'],
                ['url'=>'https://images.unsplash.com/photo-1563788240-4a32624c5e46?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'أحجار الاسترخاء'],
                ['url'=>'https://images.unsplash.com/photo-1556760544-74068565f05c?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'منتجات العناية'],
                ['url'=>'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'كريمات البشرة'],
                ['url'=>'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'أجواء السبا'],
                ['url'=>'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=450&q=80&auto=format&fit=crop','alt'=>'غرفة الاسترخاء'],
            ] as $gimg)
            <div class="rounded-2xl overflow-hidden group cursor-pointer" style="height:220px;">
                <img src="{{ $gimg['url'] }}" alt="{{ $gimg['alt'] }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('about') }}" class="btn-outline" style="color:#e8b4b8;border-color:rgba(232,180,184,0.4);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                مشاهدة المزيد
            </a>
        </div>
    </div>
</section>

{{-- =================== TESTIMONIALS SLIDER =================== --}}
<section class="py-20" style="background:#1a1a1a;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <div class="badge-spa mb-4">آراء عملائنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">ثقتكم هي سر نجاحنا</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div class="swiper testimonials-swiper" style="padding-bottom:50px;">
            <div class="swiper-wrapper">
                @forelse($testimonials as $t)
                <div class="swiper-slide">
                    <div class="testimonial-card text-center mx-auto" style="max-width:640px;">
                        <div class="mb-5 flex justify-center" style="color:rgba(232,180,184,0.3);">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                        </div>
                        <p class="text-base leading-relaxed mb-8" style="color:rgba(255,255,255,0.75);">{{ $t->content }}</p>
                        <div class="flex items-center justify-center gap-4">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-black text-xl flex-shrink-0"
                                 style="background:linear-gradient(135deg,#e8b4b8,#c9888e);border:2px solid rgba(232,180,184,0.4);">
                                {{ mb_substr($t->client_name, 0, 1) }}
                            </div>
                            <div class="text-right">
                                <div class="font-black text-white">{{ $t->client_name }}</div>
                                @if($t->client_city)<div class="text-xs" style="color:rgba(255,255,255,0.4);">{{ $t->client_city }}</div>@endif
                                <div class="flex gap-0.5 mt-1">
                                    @for($i=0;$i<($t->rating??5);$i++)<svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @foreach([
                    ['name'=>'سارة م.','city'=>'بغداد','text'=>'أفضل تجربة ليزر وبشرة! المكان نظيف والعاملات راقيات جداً والنتائج مذهلة','stars'=>5],
                    ['name'=>'نور الهدى','city'=>'النجف','text'=>'جلسات البشرة غيّرت بشرتي ١٨٠ درجة، أنصح الجميع بالتجربة ولن تندمي','stars'=>5],
                    ['name'=>'رنا أ.','city'=>'البصرة','text'=>'خدمة ممتازة ونتائج رائعة، الفريق محترف ومؤدب وسأعود دائماً','stars'=>5],
                ] as $t)
                <div class="swiper-slide">
                    <div class="testimonial-card text-center mx-auto" style="max-width:640px;">
                        <div class="mb-5 flex justify-center" style="color:rgba(232,180,184,0.3);">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                        </div>
                        <p class="text-base leading-relaxed mb-8" style="color:rgba(255,255,255,0.75);">{{ $t['text'] }}</p>
                        <div class="flex items-center justify-center gap-4">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-black text-xl flex-shrink-0"
                                 style="background:linear-gradient(135deg,#e8b4b8,#c9888e);border:2px solid rgba(232,180,184,0.4);">
                                {{ mb_substr($t['name'], 0, 1) }}
                            </div>
                            <div class="text-right">
                                <div class="font-black text-white">{{ $t['name'] }}</div>
                                <div class="text-xs" style="color:rgba(255,255,255,0.4);">{{ $t['city'] }}</div>
                                <div class="flex gap-0.5 mt-1">
                                    @for($i=0;$i<$t['stars'];$i++)<svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
            <div class="swiper-pagination testimonials-pagination"></div>
        </div>
    </div>
</section>

{{-- =================== CONTACT INFO SECTION =================== --}}
<section class="py-20" style="background:#131313;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <div class="badge-spa mb-4">تواصل معنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">نحن هنا لخدمتك</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(1,1fr);gap:1rem;" class="md:grid-cols-2">
            @foreach([
                ['icon'=>'<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.82 19.79 19.79 0 01.21 1.22 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.86-.86a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>','label'=>'اتصال / واتساب','val'=>'+964 456 123 770','c'=>'#e8b4b8'],
                ['icon'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>','label'=>'راسلينا','val'=>'info@nayspa.iq','c'=>'#c9a96e'],
                ['icon'=>'<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>','label'=>'موقعنا','val'=>'بغداد - المنصور - شارع 14 رمضان','c'=>'#e8b4b8'],
                ['icon'=>'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>','label'=>'ساعات العمل','val'=>'السبت - الخميس: 10ص - 10م | الجمعة: 2م - 10م','c'=>'#c9a96e'],
            ] as $ci)
            <div class="flex items-center gap-4 p-5 rounded-2xl" style="background:#2a2a2a;border:1px solid rgba(255,255,255,0.05);">
                <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center"
                     style="background:rgba({{ $ci['c']==='#e8b4b8'?'232,180,184':'201,169,110' }},0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $ci['c'] }}" stroke-width="1.8" stroke-linecap="round">{!! $ci['icon'] !!}</svg>
                </div>
                <div>
                    <div class="text-xs font-bold mb-0.5" style="color:{{ $ci['c'] }};">{{ $ci['label'] }}</div>
                    <div class="text-sm text-white font-medium">{{ $ci['val'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('contact') }}" class="btn-primary px-8 py-3.5">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                ارسلي رسالة
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
        autoplay: { delay: 7000, disableOnInteraction: false, pauseOnMouseEnter: true },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        pagination: { el: '.swiper-pagination', clickable: true },
        on: {
            init() {
                // Play video on first slide immediately
                const first = this.slides[this.activeIndex];
                const v = first?.querySelector('video');
                if (v) { v.muted = true; v.play().catch(() => {}); }
            },
            slideChangeTransitionStart() {
                // Pause all videos, play only the active one
                this.slides.forEach(slide => {
                    const v = slide.querySelector('video');
                    if (v) v.pause();
                });
                const active = this.slides[this.activeIndex];
                const av = active?.querySelector('video');
                if (av) { av.currentTime = 0; av.play().catch(() => {}); }
            }
        }
    });

    // Testimonials Swiper
    new Swiper('.testimonials-swiper', {
        loop: true,
        speed: 700,
        autoplay: { delay: 5000, disableOnInteraction: false },
        slidesPerView: 1,
        pagination: { el: '.testimonials-pagination', clickable: true },
    });

    // Category filter
    function filterServices(cat) {
        document.querySelectorAll('.service-card').forEach(card => {
            card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
        });
        document.querySelectorAll('.cat-tab').forEach(btn => {
            const active = btn.dataset.cat === cat;
            btn.style.cssText = active
                ? 'background:linear-gradient(135deg,#e8b4b8,#c9888e);color:white;'
                : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.65);border:1px solid rgba(255,255,255,0.1);';
        });
    }

    // Scroll reveal
    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(el => { if (el.isIntersecting) el.target.classList.add('visible'); });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
</script>
@endpush

@endsection
