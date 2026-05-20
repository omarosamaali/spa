@extends('layouts.app')

@section('title', 'NAY SPA - جمالك يستحق العناية')

@section('content')

{{-- =================== HERO SECTION =================== --}}
<section class="relative overflow-hidden" style="min-height:100vh; padding-top:80px; background:#1a1a1a;">

    {{-- Background gradient layers --}}
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 70% 50%, rgba(61,43,46,0.9) 0%, rgba(26,26,26,1) 60%); z-index:0;"></div>
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 20% 80%, rgba(201,169,110,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 10%, rgba(232,180,184,0.07) 0%, transparent 50%); z-index:1;"></div>

    {{-- Subtle grid texture --}}
    <div class="absolute inset-0" style="z-index:1; opacity:0.03; background-image:linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size:60px 60px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative" style="z-index:3;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" style="min-height: calc(100vh - 80px);">

            {{-- ===== Text content ===== --}}
            <div class="text-white py-12 lg:py-0 order-2 lg:order-1">

                {{-- Badge --}}
                <div class="badge-spa mb-6 inline-flex" style="background:rgba(232,180,184,0.12); color:#e8b4b8; border-color:rgba(232,180,184,0.35)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                    مركز تجميل متكامل
                </div>

                <h1 class="font-black mb-4 leading-tight" style="font-size:clamp(2.6rem,5vw,4rem); line-height:1.15">
                    <span style="color:#e8b4b8">جمالك</span> يبدأ<br>من هنا
                </h1>

                <p class="text-lg mb-2 leading-relaxed" style="color:rgba(255,255,255,0.75); max-width:480px">
                    أحدث العلاجات وأفضل الخبرات في مكان واحد
                </p>
                <p class="text-base mb-10" style="color:rgba(255,255,255,0.5)">
                    احجزي موعدك الآن واستمتعي بتجربة فريدة
                </p>

                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('booking') }}" class="btn-primary text-base">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        احجزي موعدك الآن
                    </a>
                    <a href="https://wa.me/9647701234567" class="btn-whatsapp text-base">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                        تواصل واتساب
                    </a>
                </div>

                {{-- Features grid --}}
                <div class="grid grid-cols-4 gap-4 pt-8" style="border-top:1px solid rgba(255,255,255,0.08)">
                    <div class="feature-item text-center">
                        <div class="mb-2 mx-auto flex items-center justify-center w-10 h-10 rounded-xl" style="background:rgba(232,180,184,0.12)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <div class="font-bold text-sm">جودة عالية</div>
                        <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.45)">أفضل المنتجات</div>
                    </div>
                    <div class="feature-item text-center">
                        <div class="mb-2 mx-auto flex items-center justify-center w-10 h-10 rounded-xl" style="background:rgba(232,180,184,0.12)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        </div>
                        <div class="font-bold text-sm">أجهزة حديثة</div>
                        <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.45)">أحدث التقنيات</div>
                    </div>
                    <div class="feature-item text-center">
                        <div class="mb-2 mx-auto flex items-center justify-center w-10 h-10 rounded-xl" style="background:rgba(232,180,184,0.12)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                        </div>
                        <div class="font-bold text-sm">خبرات محترفة</div>
                        <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.45)">فريق متخصص</div>
                    </div>
                    <div class="feature-item text-center">
                        <div class="mb-2 mx-auto flex items-center justify-center w-10 h-10 rounded-xl" style="background:rgba(232,180,184,0.12)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="font-bold text-sm">تعقيم شامل</div>
                        <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.45)">بيئة آمنة 100%</div>
                    </div>
                </div>
            </div>

            {{-- ===== Hero Visual (Decorative) ===== --}}
            <div class="order-1 lg:order-2 flex justify-center lg:justify-end">
                <div class="relative animate-float" style="width:420px; max-width:100%; height:520px;">

                    {{-- Outer ring 3 (slowest) --}}
                    <div class="hero-ring-3 absolute rounded-full" style="inset:-24px; border:1px dashed rgba(232,180,184,0.15); border-radius:50%;"></div>

                    {{-- Outer ring 2 --}}
                    <div class="hero-ring-2 absolute rounded-full" style="inset:-8px; border:1px solid rgba(232,180,184,0.2); border-radius:50%;"></div>

                    {{-- Inner ring 1 --}}
                    <div class="hero-ring-1 absolute" style="inset:0; border-radius:50%; border:2px solid transparent; background:linear-gradient(#1a1a1a,#1a1a1a) padding-box, linear-gradient(135deg,rgba(232,180,184,0.5),rgba(201,169,110,0.3),transparent,rgba(232,180,184,0.5)) border-box;"></div>

                    {{-- Main circle --}}
                    <div class="hero-center-glow absolute rounded-full flex items-center justify-center overflow-hidden"
                         style="inset:20px; background:linear-gradient(160deg,#3d2b2e 0%,#2a1f22 40%,#1f1a1a 100%);">

                        {{-- Inner glow --}}
                        <div class="absolute inset-0 rounded-full" style="background:radial-gradient(ellipse at 40% 30%, rgba(232,180,184,0.18) 0%, transparent 60%), radial-gradient(ellipse at 70% 80%, rgba(201,169,110,0.12) 0%, transparent 50%);"></div>

                        {{-- Decorative geometric lines --}}
                        <svg class="absolute inset-0 w-full h-full hero-shimmer" viewBox="0 0 380 380" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity:0.25">
                            <circle cx="190" cy="190" r="140" stroke="#e8b4b8" stroke-width="0.5" stroke-dasharray="8 6"/>
                            <circle cx="190" cy="190" r="100" stroke="#c9a96e" stroke-width="0.5" stroke-dasharray="4 8"/>
                            <circle cx="190" cy="190" r="60" stroke="#e8b4b8" stroke-width="0.5"/>
                            <line x1="50" y1="190" x2="330" y2="190" stroke="#e8b4b8" stroke-width="0.4" stroke-dasharray="6 8"/>
                            <line x1="190" y1="50" x2="190" y2="330" stroke="#e8b4b8" stroke-width="0.4" stroke-dasharray="6 8"/>
                            <line x1="90" y1="90" x2="290" y2="290" stroke="#c9a96e" stroke-width="0.3" stroke-dasharray="4 10"/>
                            <line x1="290" y1="90" x2="90" y2="290" stroke="#c9a96e" stroke-width="0.3" stroke-dasharray="4 10"/>
                        </svg>

                        {{-- Lotus / Spa SVG icon center --}}
                        <div class="relative z-10 flex flex-col items-center justify-center gap-4">
                            <svg width="110" height="110" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                {{-- Petals --}}
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal1)" opacity="0.85"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal1)" opacity="0.85" transform="rotate(45 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal2)" opacity="0.7" transform="rotate(90 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal2)" opacity="0.7" transform="rotate(135 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal1)" opacity="0.6" transform="rotate(180 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal1)" opacity="0.6" transform="rotate(225 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal2)" opacity="0.55" transform="rotate(270 60 60)"/>
                                <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#petal2)" opacity="0.55" transform="rotate(315 60 60)"/>
                                {{-- Center circle --}}
                                <circle cx="60" cy="60" r="16" fill="url(#center)"/>
                                <circle cx="60" cy="60" r="10" fill="rgba(255,255,255,0.15)"/>
                                {{-- NAY text --}}
                                <text x="60" y="65" text-anchor="middle" font-family="serif" font-size="9" font-weight="bold" fill="white" letter-spacing="2">NAY</text>
                                <defs>
                                    <linearGradient id="petal1" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#f5dfe1"/>
                                        <stop offset="100%" stop-color="#c9888e" stop-opacity="0.6"/>
                                    </linearGradient>
                                    <linearGradient id="petal2" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#c9a96e"/>
                                        <stop offset="100%" stop-color="#e8b4b8" stop-opacity="0.5"/>
                                    </linearGradient>
                                    <radialGradient id="center" cx="50%" cy="50%" r="50%">
                                        <stop offset="0%" stop-color="#e8b4b8"/>
                                        <stop offset="100%" stop-color="#c9888e"/>
                                    </radialGradient>
                                </defs>
                            </svg>

                            <div class="text-center" style="color:rgba(255,255,255,0.6); font-size:0.75rem; letter-spacing:4px; text-transform:uppercase">Beauty &amp; Spa</div>

                            {{-- Small decorative dots --}}
                            <div class="flex gap-2 mt-1">
                                <div class="w-1.5 h-1.5 rounded-full" style="background:#e8b4b8"></div>
                                <div class="w-2.5 h-1.5 rounded-full" style="background:#c9a96e"></div>
                                <div class="w-1.5 h-1.5 rounded-full" style="background:#e8b4b8"></div>
                            </div>
                        </div>

                        {{-- Corner accents --}}
                        <div class="absolute top-6 right-6 w-8 h-8 opacity-30" style="border-top:2px solid #c9a96e; border-right:2px solid #c9a96e; border-radius:0 6px 0 0;"></div>
                        <div class="absolute bottom-6 left-6 w-8 h-8 opacity-30" style="border-bottom:2px solid #c9a96e; border-left:2px solid #c9a96e; border-radius:0 0 0 6px;"></div>
                    </div>

                    {{-- Floating confirmation card --}}
                    <div class="absolute -bottom-2 -right-4 bg-white rounded-2xl p-3.5 shadow-2xl" style="max-width:185px; z-index:20">
                        <div class="flex items-center gap-2 mb-1.5">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center" style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="text-xs font-black" style="color:#1a1a1a">تم الحجز بنجاح</div>
                        </div>
                        <div class="text-xs" style="color:#888">سارة — جلسة بشرة</div>
                        <div class="flex mt-1.5 gap-0.5">
                            @for($i=0;$i<5;$i++)<svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor
                        </div>
                    </div>

                    {{-- Floating stats card --}}
                    <div class="absolute -top-2 -left-4 bg-white rounded-2xl p-3.5 shadow-2xl" style="z-index:20">
                        <div class="text-2xl font-black leading-none" style="color:#c9888e">+500</div>
                        <div class="text-xs mt-0.5" style="color:#888">عميلة راضية</div>
                        <div class="flex gap-1 mt-2">
                            @for($i=0;$i<3;$i++)
                            <div class="w-5 h-5 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold" style="background:linear-gradient(135deg,#e8b4b8,#c9888e); margin-right:-4px">{{ ['س','ن','ر'][$i] }}</div>
                            @endfor
                        </div>
                    </div>

                    {{-- Decorative floating dots --}}
                    <div class="absolute" style="top:15%; right:-30px; width:10px; height:10px; border-radius:50%; background:#c9a96e; opacity:0.6;"></div>
                    <div class="absolute" style="bottom:25%; left:-20px; width:7px; height:7px; border-radius:50%; background:#e8b4b8; opacity:0.5;"></div>
                    <div class="absolute" style="top:60%; right:-18px; width:5px; height:5px; border-radius:50%; background:#e8b4b8; opacity:0.4;"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0" style="z-index:4;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block; width:100%; height:60px;">
            <path d="M0,40 C360,70 1080,10 1440,40 L1440,60 L0,60 Z" fill="#fdf8f5"/>
        </svg>
    </div>
</section>

{{-- =================== STATS BAR =================== --}}
<section style="background:#fdf8f5; padding: 0 0 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-10">
            <div class="text-center py-6 px-4 rounded-2xl" style="background:white; box-shadow:0 4px 20px rgba(0,0,0,0.05)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9888e">
                    {{ $stats['clients'] > 0 ? '+' . $stats['clients'] : '+500' }}
                </div>
                <div class="text-sm font-medium" style="color:#888">عميلة راضية</div>
            </div>

            <div class="text-center py-6 px-4 rounded-2xl" style="background:white; box-shadow:0 4px 20px rgba(0,0,0,0.05)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2" stroke-linecap="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9888e">{{ $stats['years'] }}+</div>
                <div class="text-sm font-medium" style="color:#888">سنوات خبرة</div>
            </div>

            <div class="text-center py-6 px-4 rounded-2xl" style="background:white; box-shadow:0 4px 20px rgba(0,0,0,0.05)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2" stroke-linecap="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9888e">{{ $stats['services'] > 0 ? $stats['services'] . '+' : '15+' }}</div>
                <div class="text-sm font-medium" style="color:#888">خدمة متميزة</div>
            </div>

            <div class="text-center py-6 px-4 rounded-2xl" style="background:white; box-shadow:0 4px 20px rgba(0,0,0,0.05)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#f5dfe1,#e8b4b8)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="text-3xl font-black mb-1" style="color:#c9888e">{{ $stats['rating'] }}%</div>
                <div class="text-sm font-medium" style="color:#888">رضا العميلات</div>
            </div>
        </div>
    </div>
</section>

{{-- =================== SERVICES SECTION =================== --}}
<section class="py-20" style="background:#fdf8f5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">خدماتنا</div>
            <h2 class="text-3xl md:text-4xl font-black mb-4" style="color:#1a1a1a">اختري ما يناسبك</h2>
            <div class="section-divider mb-4"></div>
        </div>

        {{-- Services grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            @forelse($services as $service)
            <div class="service-card text-center group">
                <div class="relative overflow-hidden" style="height:160px; background:linear-gradient(135deg,#f5dfe1,#fdf0f2)">
                    @if($service->image)
                        <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="text-5xl opacity-40">{{ $service->icon ?? '✨' }}</div>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 w-10 h-10 rounded-full flex items-center justify-center text-xl" style="background:linear-gradient(135deg,#e8b4b8,#c9888e); box-shadow:0 4px 10px rgba(232,180,184,0.5)">
                        {{ $service->icon ?? '✨' }}
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-black mb-1" style="color:#1a1a1a">{{ $service->name }}</h3>
                    <p class="text-xs mb-3 leading-relaxed" style="color:#666">{{ $service->description }}</p>
                    @if($service->price)
                    <div class="text-sm font-bold mb-3" style="color:#c9888e">{{ number_format($service->price) }} د.ع</div>
                    @endif
                    <a href="{{ route('booking', ['service_id' => $service->id]) }}"
                       class="btn-primary text-xs w-full justify-center" style="padding:0.5rem 1rem">
                        احجزي الآن
                    </a>
                </div>
            </div>
            @empty
            {{-- Static fallback with SVG icons --}}
            @foreach([
                [
                    'name'=>'الليزر',
                    'desc'=>'إزالة الشعر بتقنيات حديثة آمنة وفعالة',
                    'color_from'=>'#f5dfe1','color_to'=>'#fde8ea',
                    'svg'=>'<circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>',
                ],
                [
                    'name'=>'البشرة',
                    'desc'=>'جلسات تنظيف ونضارة وتثبيت البشرة',
                    'color_from'=>'#fde8d8','color_to'=>'#fdf0e8',
                    'svg'=>'<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
                ],
                [
                    'name'=>'البوتوكس والفيلر',
                    'desc'=>'إبراز جمالك بشكل طبيعي وآمن',
                    'color_from'=>'#e8f0fe','color_to'=>'#eef4ff',
                    'svg'=>'<path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>',
                ],
                [
                    'name'=>'المساج',
                    'desc'=>'استرخاء تام وتجديد الحيوية',
                    'color_from'=>'#e8f5e9','color_to'=>'#f1f9f1',
                    'svg'=>'<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/><path d="M12 8v8M8 12h8"/>',
                ],
                [
                    'name'=>'الأظافر',
                    'desc'=>'تصميم الأظافر بأحدث الستايلات',
                    'color_from'=>'#fce4ec','color_to'=>'#fdf0f4',
                    'svg'=>'<path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>',
                ],
            ] as $s)
            <div class="service-card text-center group">
                <div class="flex items-center justify-center" style="height:160px; background:linear-gradient(135deg,{{ $s['color_from'] }},{{ $s['color_to'] }})">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg" style="background:white">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9888e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                {!! $s['svg'] !!}
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-black mb-1" style="color:#1a1a1a">{{ $s['name'] }}</h3>
                    <p class="text-xs mb-3" style="color:#666">{{ $s['desc'] }}</p>
                    <a href="{{ route('booking') }}" class="btn-primary text-xs w-full justify-center" style="padding:0.5rem 1rem">احجزي الآن</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('services') }}" class="btn-outline" style="color:#c9888e; border-color:#e8b4b8; background:transparent">
                عرض جميع الخدمات
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =================== HOW TO BOOK SECTION =================== --}}
<section class="py-20 gradient-hero relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image:radial-gradient(circle at 50% 50%, #e8b4b8 0%, transparent 60%);"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">خطوات الحجز</div>
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
                {{-- Connector line --}}
                @if($i < 3)
                <div class="absolute hidden md:block" style="top:32px; right:0; width:50%; z-index:0; height:2px; background:linear-gradient(90deg,rgba(232,180,184,0.5),rgba(232,180,184,0.1)); margin-right:50%;"></div>
                @endif

                {{-- Step circle --}}
                <div class="step-icon-wrap mb-4">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $step['svg'] !!}
                    </svg>
                </div>

                <div class="text-xs font-bold mb-1 px-2 py-0.5 rounded-full" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border:1px solid rgba(232,180,184,0.25)">
                    الخطوة {{ $step['num'] }}
                </div>
                <h3 class="text-base font-black mt-2 mb-2">{{ $step['title'] }}</h3>
                <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,0.6); max-width:150px">{{ $step['desc'] }}</p>
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

{{-- =================== TESTIMONIALS SECTION =================== --}}
<section class="py-20" style="background:#f9f0eb">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">آراء عملائنا</div>
            <h2 class="text-3xl md:text-4xl font-black mb-4" style="color:#1a1a1a">ثقتكم هي سر نجاحنا</h2>
            <div class="section-divider mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($testimonials as $t)
            <div class="testimonial-card">
                <div class="mb-4" style="color:#e8b4b8; opacity:0.5">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p class="leading-relaxed mb-6" style="color:#444; font-size:0.95rem">{{ $t->content }}</p>
                <div class="flex items-center gap-4 justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg"
                             style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                            {{ mb_substr($t->client_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-sm" style="color:#1a1a1a">{{ $t->client_name }}</div>
                            @if($t->client_city)
                            <div class="text-xs" style="color:#888">{{ $t->client_city }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="stars">{{ str_repeat('★', $t->rating) }}</div>
                </div>
            </div>
            @empty
            @foreach([
                ['name'=>'سارة','city'=>'بغداد','text'=>'أفضل تجربة ليزر، المكان نظيف والعاملات راقيات جداً','stars'=>5],
                ['name'=>'نور','city'=>'النجف','text'=>'جلسات البشرة غيّرت بشرتي ١٨٠ درجة، أنصح الجميع','stars'=>5],
                ['name'=>'رنا','city'=>'البصرة','text'=>'خدمة ممتازة ونتائج رائعة، سأعود دائماً','stars'=>5],
            ] as $t)
            <div class="testimonial-card">
                <div class="mb-4" style="color:#e8b4b8; opacity:0.5">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p class="leading-relaxed mb-6" style="color:#444">{{ $t['text'] }}</p>
                <div class="flex items-center gap-4 justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg"
                             style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                            {{ mb_substr($t['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-sm" style="color:#1a1a1a">{{ $t['name'] }}</div>
                            <div class="text-xs" style="color:#888">{{ $t['city'] }}</div>
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
<section class="py-20 relative overflow-hidden" style="background:linear-gradient(135deg,#1a1a1a 0%,#3d2b2e 60%,#2a1a1e 100%)">
    <div class="absolute inset-0" style="background:radial-gradient(ellipse at 50% 50%, rgba(232,180,184,0.08) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-4" style="background-image:radial-gradient(circle, rgba(232,180,184,0.15) 1px, transparent 1px); background-size:40px 40px;"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <div class="badge-spa mb-6 inline-flex" style="background:rgba(232,180,184,0.12); color:#e8b4b8; border-color:rgba(232,180,184,0.25)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            عرض خاص
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-white mb-4">جاهزة لتجربة الفرق؟</h2>
        <p class="text-lg mb-10" style="color:rgba(255,255,255,0.7)">احجزي موعدك الآن واستمتعي بخصم 10% على أول زيارة</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('booking') }}" class="px-10 py-4 rounded-full font-black text-lg transition-all hover:scale-105"
               style="background:white; color:#c9888e; box-shadow:0 8px 30px rgba(0,0,0,0.2)">
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
<script>
    // Scroll reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(el => {
            if (el.isIntersecting) {
                el.target.classList.add('visible');
            }
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush

@endsection
