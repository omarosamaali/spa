@extends('layouts.app')

@section('title', 'NAY SPA - جمالك يستحق العناية')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')

{{-- =================== HERO SLIDER =================== --}}
@php
    $heroLayout  = $siteTheme['hero_layout']  ?? 'classic';
    $heroGrad    = $siteTheme['hero_gradient'] ?? 'linear-gradient(135deg,rgba(18,8,14,0.88) 0%,rgba(18,8,14,0.42) 55%,rgba(40,18,28,0.75) 100%)';
    $spaPrimary  = $siteTheme['primary']       ?? '#e8b4b8';
    $spaGold     = $siteTheme['gold']          ?? '#c9a96e';
    $spaDark     = $siteTheme['dark']          ?? '#1a1a1a';
    $heroBottomFade = 'linear-gradient(to top,' . $spaDark . ' 0%,transparent 100%)';
@endphp
<section class="relative overflow-hidden w-full max-w-full" style="height:100vh; min-height:600px; max-height:100dvh;">
    <div class="swiper hero-swiper w-full max-w-full" style="height:100%;">
        <div class="swiper-wrapper">

            @foreach($heroSlides as $slide)
            @php
                $btnUrl = fn($link) => str_starts_with($link ?? '', 'http') ? $link : url($link ?? '/');
                $accentHex = $spaPrimary;
                $accentBg  = 'rgba(' . implode(',', sscanf(ltrim($accentHex,'#'), "%02x%02x%02x")) . ',0.15)';
                $accentBdr = 'rgba(' . implode(',', sscanf(ltrim($accentHex,'#'), "%02x%02x%02x")) . ',0.35)';
            @endphp
            <div class="swiper-slide relative">

                {{-- ── MEDIA BACKGROUND ── --}}
                <div class="absolute inset-0{{ $slide->isVideo() ? ' overflow-hidden' : '' }}">
                    @if($slide->isVideo())
                    <video class="hero-slide-video" autoplay muted loop playsinline preload="auto"
                           poster="{{ $slide->posterSrc() }}">
                        <source src="{{ $slide->mediaSrc() }}" type="video/mp4">
                        @if($slide->mediaSrcAlt())
                        <source src="{{ $slide->mediaSrcAlt() }}" type="video/mp4">
                        @endif
                    </video>
                    @else
                    <img src="{{ $slide->mediaSrc() }}" alt="{{ $slide->title }}"
                         class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0" style="background:{{ $heroGrad }};"></div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 1 · CLASSIC  (LUXÉA)
                     Left-aligned, badge + bold title + buttons
                ═══════════════════════════════════════════ --}}
                @if($heroLayout === 'classic')
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-xl">
                            @if($slide->badge)
                            <div class="badge-spa mb-5 inline-flex" style="background:{{ $accentBg }};color:{{ $accentHex }};border-color:{{ $accentBdr }};">
                                @if($slide->isVideo())
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                @else
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @endif
                                {{ $slide->badge }}
                            </div>
                            @endif
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                {{ $slide->title }}@if($slide->title_highlight)<br><span style="color:{{ $accentHex }};">{{ $slide->title_highlight }}</span>@endif
                            </h1>
                            @if($slide->subtitle)
                            <p class="mb-3" style="color:rgba(255,255,255,0.75);font-size:1rem;line-height:1.7;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $slide->btn_primary_text }}
                                </a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 2 · CENTERED  (AURORA)
                     Centered, decorative divider, diamonds accent
                ═══════════════════════════════════════════ --}}
                @elseif($heroLayout === 'centered')
                <div class="relative z-10 h-full flex items-center justify-center text-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-2xl mx-auto">
                            {{-- Decorative top bar --}}
                            <div class="flex items-center justify-center gap-3 mb-6">
                                <div class="h-px w-16 opacity-60" style="background:{{ $accentHex }};"></div>
                                <span class="text-xs tracking-[0.3em] uppercase opacity-80" style="color:{{ $accentHex }};">LUXURY SPA</span>
                                <div class="h-px w-16 opacity-60" style="background:{{ $accentHex }};"></div>
                            </div>
                            @if($slide->badge)
                            <div class="badge-spa mb-4 inline-flex mx-auto" style="background:{{ $accentBg }};color:{{ $accentHex }};border-color:{{ $accentBdr }};">
                                {{ $slide->badge }}
                            </div>
                            @endif
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.6rem,5.5vw,4.5rem);line-height:1.05;">
                                {{ $slide->title }}@if($slide->title_highlight)<br><span style="color:{{ $accentHex }};">{{ $slide->title_highlight }}</span>@endif
                            </h1>
                            {{-- Diamond divider --}}
                            <div class="flex items-center justify-center gap-2 my-4">
                                <div class="w-1.5 h-1.5 rotate-45" style="background:{{ $accentHex }};opacity:0.4;"></div>
                                <div class="w-2 h-2 rotate-45" style="background:{{ $accentHex }};"></div>
                                <div class="w-1.5 h-1.5 rotate-45" style="background:{{ $accentHex }};opacity:0.4;"></div>
                            </div>
                            @if($slide->subtitle)
                            <p class="mb-3 max-w-lg mx-auto" style="color:rgba(255,255,255,0.72);font-size:1rem;line-height:1.8;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8 justify-center">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">{{ $slide->btn_primary_text }}</a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 3 · MINIMAL  (NIRVANA / SOLÉA / AZURÉ)
                     Ultra-clean, large thin title, minimal overlay
                ═══════════════════════════════════════════ --}}
                @elseif($heroLayout === 'minimal')
                <div class="relative z-10 h-full flex items-center justify-center text-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-3xl mx-auto">
                            <p class="text-xs tracking-[0.5em] uppercase mb-4 opacity-70" style="color:{{ $accentHex }};">— NAY SPA —</p>
                            <h1 class="text-white mb-2" style="font-size:clamp(3rem,7vw,5.5rem);line-height:1.0;font-weight:300;letter-spacing:0.08em;font-family:'Cormorant Garamond',serif;">
                                {{ $slide->title }}
                            </h1>
                            @if($slide->title_highlight)
                            <h1 class="mb-0" style="font-size:clamp(3rem,7vw,5.5rem);line-height:1.0;font-weight:700;letter-spacing:0.04em;font-family:'Cormorant Garamond',serif;color:{{ $accentHex }};">
                                {{ $slide->title_highlight }}
                            </h1>
                            @endif
                            {{-- Thin rule --}}
                            <div class="my-5 mx-auto" style="width:80px;height:1px;background:{{ $accentHex }};opacity:0.6;"></div>
                            @if($slide->subtitle)
                            <p class="mb-3 max-w-md mx-auto" style="color:rgba(255,255,255,0.68);font-size:0.95rem;line-height:1.9;letter-spacing:0.02em;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8 justify-center">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">{{ $slide->btn_primary_text }}</a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 4 · NATURE  (VERA / PURELI)
                     Large organic circle, centered bottom text
                ═══════════════════════════════════════════ --}}
                @elseif($heroLayout === 'nature')
                {{-- Decorative circle --}}
                <div class="absolute z-[5] pointer-events-none" style="top:50%;left:50%;transform:translate(-50%,-52%);width:min(70vw,600px);height:min(70vw,600px);border-radius:50%;border:1px solid {{ $accentHex }}22;"></div>
                <div class="absolute z-[5] pointer-events-none" style="top:50%;left:50%;transform:translate(-50%,-52%);width:min(58vw,500px);height:min(58vw,500px);border-radius:50%;border:1px solid {{ $accentHex }}15;"></div>
                <div class="relative z-10 h-full flex items-end justify-center pb-28 text-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-2xl mx-auto">
                            @if($slide->badge)
                            <div class="badge-spa mb-4 inline-flex mx-auto" style="background:{{ $accentBg }};color:{{ $accentHex }};border-color:{{ $accentBdr }};">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 19a10 10 0 1 0 13.18-13Z"/><path d="M15 7.5v.01"/></svg>
                                {{ $slide->badge }}
                            </div>
                            @endif
                            <h1 class="font-black text-white mb-3" style="font-size:clamp(2.6rem,5.5vw,4.2rem);line-height:1.1;">
                                {{ $slide->title }}@if($slide->title_highlight)<br><span style="color:{{ $accentHex }};">{{ $slide->title_highlight }}</span>@endif
                            </h1>
                            @if($slide->subtitle)
                            <p class="mb-3" style="color:rgba(255,255,255,0.7);font-size:0.95rem;line-height:1.8;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-6 justify-center">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">{{ $slide->btn_primary_text }}</a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 5 · EDITORIAL  (ELIRA / MAISON D'OR)
                     Left title + vertical side accent text
                ═══════════════════════════════════════════ --}}
                @elseif($heroLayout === 'editorial')
                {{-- Vertical accent bar --}}
                <div class="absolute left-8 top-1/2 z-[5] hidden lg:flex flex-col items-center gap-3 pointer-events-none" style="transform:translateY(-50%);">
                    <div class="w-px h-20 opacity-40" style="background:{{ $accentHex }};"></div>
                    <span class="text-[10px] tracking-[0.4em] opacity-60 uppercase" style="writing-mode:vertical-rl;color:{{ $accentHex }};">BEAUTY · LUXURY · CARE</span>
                    <div class="w-px h-20 opacity-40" style="background:{{ $accentHex }};"></div>
                </div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px; padding-right:10%;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 lg:pr-12 w-full box-border">
                        <div class="max-w-2xl mr-auto">
                            {{-- Number / order --}}
                            <div class="flex items-center gap-3 mb-5">
                                <span class="text-[0.7rem] tracking-[0.35em] uppercase opacity-50" style="color:{{ $accentHex }};">{{ date('Y') }}</span>
                                <div class="h-px flex-1 max-w-[60px] opacity-30" style="background:{{ $accentHex }};"></div>
                            </div>
                            @if($slide->badge)
                            <div class="badge-spa mb-4 inline-flex" style="background:{{ $accentBg }};color:{{ $accentHex }};border-color:{{ $accentBdr }};">{{ $slide->badge }}</div>
                            @endif
                            {{-- Large outline + solid split title --}}
                            @if($slide->title_highlight)
                            <h1 class="mb-0 text-white" style="font-size:clamp(3rem,6.5vw,5rem);line-height:0.95;font-weight:900;letter-spacing:-0.01em;">
                                {{ $slide->title }}
                            </h1>
                            <h1 class="mb-4" style="font-size:clamp(3rem,6.5vw,5rem);line-height:0.95;font-weight:900;letter-spacing:-0.01em;-webkit-text-stroke:1.5px {{ $accentHex }};color:transparent;">
                                {{ $slide->title_highlight }}
                            </h1>
                            @else
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(3rem,6.5vw,5rem);line-height:1.0;">
                                {{ $slide->title }}
                            </h1>
                            @endif
                            {{-- Accent rule --}}
                            <div class="flex items-center gap-2 mb-4">
                                <div class="h-0.5 w-10" style="background:{{ $accentHex }};"></div>
                                <div class="h-0.5 w-3 opacity-40" style="background:{{ $accentHex }};"></div>
                            </div>
                            @if($slide->subtitle)
                            <p class="mb-3 max-w-sm" style="color:rgba(255,255,255,0.68);font-size:0.92rem;line-height:1.85;letter-spacing:0.01em;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">{{ $slide->btn_primary_text }}</a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     LAYOUT 6 · BOLD  (BELLA ROSE)
                     Very large pink title + strong CTA
                ═══════════════════════════════════════════ --}}
                @elseif($heroLayout === 'bold')
                {{-- Floating glow orbs --}}
                <div class="absolute z-[4] pointer-events-none" style="top:20%;right:10%;width:300px;height:300px;border-radius:50%;background:{{ $accentHex }};opacity:0.06;filter:blur(80px);"></div>
                <div class="absolute z-[4] pointer-events-none" style="bottom:20%;left:5%;width:200px;height:200px;border-radius:50%;background:{{ $spaGold }};opacity:0.05;filter:blur(60px);"></div>
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-3xl">
                            @if($slide->badge)
                            <div class="badge-spa mb-5 inline-flex" style="background:{{ $accentBg }};color:{{ $accentHex }};border-color:{{ $accentBdr }};">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                {{ $slide->badge }}
                            </div>
                            @endif
                            <h1 class="font-black text-white mb-2" style="font-size:clamp(3.5rem,8vw,6.5rem);line-height:0.92;letter-spacing:-0.02em;">
                                {{ $slide->title }}
                            </h1>
                            @if($slide->title_highlight)
                            <h1 class="font-black mb-4" style="font-size:clamp(3.5rem,8vw,6.5rem);line-height:0.92;letter-spacing:-0.02em;color:{{ $accentHex }};">
                                {{ $slide->title_highlight }}
                            </h1>
                            @endif
                            {{-- Horizontal divider with dot --}}
                            <div class="flex items-center gap-3 my-5">
                                <div class="h-px w-8" style="background:{{ $accentHex }};opacity:0.5;"></div>
                                <div class="w-2 h-2 rounded-full" style="background:{{ $accentHex }};"></div>
                                <div class="h-px flex-1 max-w-[120px]" style="background:{{ $accentHex }};opacity:0.2;"></div>
                            </div>
                            @if($slide->subtitle)
                            <p class="mb-3 max-w-md" style="color:rgba(255,255,255,0.7);font-size:1rem;line-height:1.75;">{{ $slide->subtitle }}</p>
                            @endif
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary" style="font-size:1.05rem;padding:14px 32px;">{{ $slide->btn_primary_text }}</a>
                                @endif
                                @if($slide->btn_secondary_text)
                                <a href="{{ $btnUrl($slide->btn_secondary_url) }}" class="btn-outline">{{ $slide->btn_secondary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @else
                {{-- Fallback = classic --}}
                <div class="relative z-10 h-full flex items-center" style="padding-top:80px;">
                    <div class="hero-slide-inner max-w-7xl mx-auto px-4 sm:px-8 w-full box-border">
                        <div class="max-w-xl">
                            <h1 class="font-black text-white mb-4" style="font-size:clamp(2.8rem,6vw,4.2rem);line-height:1.1;">
                                {{ $slide->title }}@if($slide->title_highlight)<br><span style="color:{{ $accentHex }};">{{ $slide->title_highlight }}</span>@endif
                            </h1>
                            <div class="hero-cta-wrap flex flex-col sm:flex-row gap-3 mt-8">
                                @if($slide->btn_primary_text)
                                <a href="{{ $btnUrl($slide->btn_primary_url) }}" class="btn-primary">{{ $slide->btn_primary_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- end swiper-slide --}}
            @endforeach

        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination" style="bottom:28px;"></div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none" style="background:{{ $heroBottomFade }};height:100px;"></div>
</section>

{{-- Per-theme dynamic styles (override hardcoded colors via CSS vars) --}}
<style>
    .booking-step-line { background: linear-gradient(to bottom, color-mix(in srgb, var(--spa-primary) 55%, transparent), color-mix(in srgb, var(--spa-primary) 8%, transparent)); }
    .step-icon-box { background: color-mix(in srgb, var(--spa-primary) 10%, transparent); border: 1px solid color-mix(in srgb, var(--spa-primary) 25%, transparent); }
    .step-icon-box svg { stroke: var(--spa-primary); }
    .step-num { color: color-mix(in srgb, var(--spa-primary) 18%, transparent); }
    .cta-card { background: linear-gradient(135deg, var(--spa-primary-dark) 0%, var(--spa-primary) 50%, var(--spa-primary-dark) 100%); }
    .testimonial-avatar { background: linear-gradient(135deg, var(--spa-primary), var(--spa-primary-dark)); border: 2px solid color-mix(in srgb, var(--spa-primary) 40%, transparent); }
    .testimonial-quote { color: color-mix(in srgb, var(--spa-primary) 30%, transparent); }
    .stat-primary { stroke: var(--spa-primary); }
    .stat-gold    { stroke: var(--spa-gold); }
    .stat-val-primary { color: var(--spa-primary); }
    .stat-val-gold    { color: var(--spa-gold); }
    .stat-icon-primary { background: color-mix(in srgb, var(--spa-primary) 12%, transparent); }
    .stat-icon-gold    { background: color-mix(in srgb, var(--spa-gold) 12%, transparent); }
    .contact-primary { color: var(--spa-primary); }
    .contact-gold    { color: var(--spa-gold); }
    .contact-icon-primary { background: color-mix(in srgb, var(--spa-primary) 12%, transparent); }
    .contact-icon-gold    { background: color-mix(in srgb, var(--spa-gold) 12%, transparent); }
    .contact-card-bg { background: var(--spa-dark-2); border: 1px solid rgba(255,255,255,0.05); }
    .cat-tab-active { background: linear-gradient(135deg, var(--spa-primary), var(--spa-primary-dark)); color: white; }
    /* Small shape tweaks per layout */
    body[data-layout="minimal"]  .rounded-2xl { border-radius: 8px; }
    body[data-layout="minimal"]  .rounded-xl  { border-radius: 6px; }
    body[data-layout="minimal"]  .rounded-full.cat-tab { border-radius: 6px; }
    body[data-layout="editorial"] .stat-card  { border-right: 3px solid var(--spa-primary); }
    body[data-layout="bold"]     .testimonial-card { border: 1px solid color-mix(in srgb, var(--spa-primary) 20%, transparent); }
    body[data-layout="nature"]   .rounded-2xl { border-radius: 20px; }
    body[data-layout="nature"]   .step-icon-box { border-radius: 50%; }
</style>

{{-- =================== SERVICES + CATEGORY TABS =================== --}}
<section class="py-20" style="background:var(--spa-dark);" id="services-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <div class="badge-spa mb-4">خدماتنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-2">اختاري ما يناسبك</h2>
            <p class="text-sm mb-6" style="color:rgba(255,255,255,0.45);">تصفحي خدماتنا واختاري الخدمة التي تناسبك</p>
            <div class="section-divider"></div>
        </div>

        {{-- Category Tabs --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10" id="cat-tabs">
            @php $cats = array_merge(['all' => 'الكل'], \App\Models\Service::categoryLabels()); @endphp
            @foreach($cats as $key => $label)
            <button onclick="filterServices('{{ $key }}')" data-cat="{{ $key }}"
                    class="cat-tab px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 {{ $key==='all' ? 'cat-tab-active' : '' }}"
                    style="{{ $key!=='all' ? 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.65);border:1px solid rgba(255,255,255,0.1);' : '' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Services Grid — full-bleed image cards --}}
        <div class="services-grid-home" id="services-grid">
            @php
            $sImgs = [
                'laser'   => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&h=800&q=80&auto=format&fit=crop',
                'skin'    => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=800&q=80&auto=format&fit=crop',
                'massage' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=600&h=800&q=80&auto=format&fit=crop',
                'botox'   => 'https://images.unsplash.com/photo-1556760544-74068565f05c?w=600&h=800&q=80&auto=format&fit=crop',
                'nails'   => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=800&q=80&auto=format&fit=crop',
            ];
            @endphp
            @forelse($services as $service)
            @include('partials.service-card-home', [
                'img' => $service->image ? asset('storage/'.$service->image) : ($sImgs[$service->category ?? ''] ?? $sImgs['skin']),
                'name' => $service->name,
                'desc' => $service->description,
                'price' => $service->price,
                'category' => $service->category ?? 'all',
                'bookingUrl' => route('booking', ['service_id' => $service->id]),
            ])
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
            @include('partials.service-card-home', [
                'img' => $sImgs[$s['cat']],
                'name' => $s['name'],
                'desc' => $s['desc'],
                'price' => $s['price'],
                'category' => $s['cat'],
                'bookingUrl' => route('booking'),
            ])
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('services') }}" class="btn-outline" style="color:var(--spa-primary);border-color:color-mix(in srgb,var(--spa-primary) 40%,transparent);">
                عرض جميع الخدمات
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =================== BOOKING STEPS VERTICAL TIMELINE =================== --}}
<section class="py-20" style="background:var(--spa-dark-3);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">خطوات الحجز</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">احجزي في 4 خطوات سهلة</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div class="relative">
            <div class="absolute hidden md:block booking-step-line" style="right:2.5rem;top:24px;bottom:24px;width:2px;border-radius:2px;"></div>

            @foreach([
                ['num'=>'01','title'=>'اختاري الخدمة','desc'=>'تصفحي خدماتنا واختاري ما يناسبك','svg'=>'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
                ['num'=>'02','title'=>'اختاري الوقت','desc'=>'حددي التاريخ والوقت المناسب لك','svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                ['num'=>'03','title'=>'بياناتك','desc'=>'أدخلي بياناتك للتأكيد','svg'=>'<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                ['num'=>'04','title'=>'تم الحجز','desc'=>'تم حجز موعدك بنجاح، نراكِ قريباً','svg'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            ] as $step)
            <div class="flex items-start gap-6 mb-10 last:mb-0 relative">
                <div class="relative flex-shrink-0 z-10">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center step-icon-box">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--spa-primary)" stroke-width="1.8" stroke-linecap="round">
                            {!! $step['svg'] !!}
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-3">
                    <div class="flex items-center gap-4 mb-2">
                        <h3 class="text-lg font-black text-white">{{ $step['title'] }}</h3>
                        <span class="text-3xl font-black step-num" style="line-height:1;">{{ $step['num'] }}</span>
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

{{-- =================== CTA - ROSE CARD =================== --}}
<section class="py-16" style="background:var(--spa-dark);">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl overflow-hidden relative cta-card">
            <div class="absolute inset-0" style="background:radial-gradient(ellipse at 30% 50%, rgba(255,255,255,0.12) 0%, transparent 60%);"></div>
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
                   style="background:var(--spa-dark);color:white;box-shadow:0 8px 25px rgba(0,0,0,0.3);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    احجزي الآن
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =================== GALLERY (SPA INTERIORS ONLY) =================== --}}
<section class="py-20" style="background:var(--spa-dark-3);">
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
            <a href="{{ route('about') }}" class="btn-outline" style="color:var(--spa-primary);border-color:color-mix(in srgb,var(--spa-primary) 40%,transparent);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                مشاهدة المزيد
            </a>
        </div>
    </div>
</section>

{{-- =================== TESTIMONIALS SLIDER =================== --}}
<section class="py-20" style="background:var(--spa-dark);">
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
                        <div class="mb-5 flex justify-center testimonial-quote">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                        </div>
                        <p class="text-base leading-relaxed mb-8" style="color:rgba(255,255,255,0.75);">{{ $t->content }}</p>
                        <div class="flex items-center justify-center gap-4">
                            <div class="testimonial-avatar w-14 h-14 rounded-full flex items-center justify-center text-white font-black text-xl flex-shrink-0">
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
                        <div class="mb-5 flex justify-center testimonial-quote">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                        </div>
                        <p class="text-base leading-relaxed mb-8" style="color:rgba(255,255,255,0.75);">{{ $t['text'] }}</p>
                        <div class="flex items-center justify-center gap-4">
                            <div class="testimonial-avatar w-14 h-14 rounded-full flex items-center justify-center text-white font-black text-xl flex-shrink-0">
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
<section class="py-20" style="background:var(--spa-dark-3);">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <div class="badge-spa mb-4">تواصل معنا</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">نحن هنا لخدمتك</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(1,1fr);gap:1rem;" class="md:grid-cols-2">
            @php
                $homeContactItems = [
                    ['icon'=>'<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.82 19.79 19.79 0 01.21 1.22 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.86-.86a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>','label'=>'اتصال / واتساب','val'=>$siteContact['phone'],'href'=>$siteContact['tel_url'],'accent'=>'primary'],
                    ['icon'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>','label'=>'راسلينا','val'=>$siteContact['email'],'href'=>$siteContact['mailto_url'],'accent'=>'gold'],
                    ['icon'=>'<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>','label'=>'موقعنا','val'=>$siteContact['address'],'href'=>null,'accent'=>'primary'],
                    ['icon'=>'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>','label'=>'ساعات العمل','val'=>'السبت — الخميس: '.$siteContact['hours_weekdays'].' | الجمعة: '.$siteContact['hours_friday'],'href'=>null,'accent'=>'gold'],
                ];
            @endphp
            @foreach($homeContactItems as $ci)
            <div class="flex items-center gap-4 p-5 rounded-2xl contact-card-bg">
                <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center contact-icon-{{ $ci['accent'] }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--spa-{{ $ci['accent']==='gold'?'gold':'primary' }})" stroke-width="1.8" stroke-linecap="round">{!! $ci['icon'] !!}</svg>
                </div>
                <div>
                    <div class="text-xs font-bold mb-0.5 contact-{{ $ci['accent'] }}">{{ $ci['label'] }}</div>
                    @if(!empty($ci['href']))
                    <a href="{{ $ci['href'] }}" class="text-sm text-white font-medium no-underline hover:opacity-80 block" @if(str_contains($ci['href'], 'tel:')) dir="ltr" @endif>{{ $ci['val'] }}</a>
                    @else
                    <div class="text-sm text-white font-medium">{{ $ci['val'] }}</div>
                    @endif
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

{{-- =================== WHY US - STATS 2x2 (آخر قسم) =================== --}}
<section class="py-20" style="background:var(--spa-dark-2);">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <div class="badge-spa mb-4">لماذا نحن؟</div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3">تجربة تستحقينها</h2>
            <div class="section-divider mt-4"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            @foreach([
                ['val'=>($stats['clients']>0?'+'.$stats['clients']:'+500'),'label'=>'جلسة مكتملة',   'sub'=>'عميلة وثقت بنا','icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>','accent'=>'primary'],
                ['val'=>'4.9',                                              'label'=>'تقييم العملاء','sub'=>'من أصل 5 نجوم','icon'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>','accent'=>'gold'],
                ['val'=>'10+',                                              'label'=>'خبراء متخصصين','sub'=>'فريق احترافي مدرّب','icon'=>'<circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0112 0v2"/>','accent'=>'gold'],
                ['val'=>'100%',                                             'label'=>'رضا العملاء',  'sub'=>'ضماننا الدائم لكِ','icon'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','accent'=>'primary'],
            ] as $st)
            <div class="stat-card rounded-2xl p-7 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1"
                 style="background:var(--spa-dark-3);border:1px solid rgba(255,255,255,0.06);">
                <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center stat-icon-{{ $st['accent'] }}">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--spa-{{ $st['accent']==='gold'?'gold':'primary' }})" stroke-width="1.8" stroke-linecap="round">{!! $st['icon'] !!}</svg>
                </div>
                <div>
                    <div class="text-3xl font-black leading-none stat-val-{{ $st['accent'] }}">{{ $st['val'] }}</div>
                    <div class="font-bold text-white text-sm mt-1">{{ $st['label'] }}</div>
                    <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.4);">{{ $st['sub'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        rtl: true,
        speed: 900,
        autoplay: { delay: 7000, disableOnInteraction: false, pauseOnMouseEnter: true },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        navigation: { nextEl: '.hero-swiper .swiper-button-next', prevEl: '.hero-swiper .swiper-button-prev' },
        pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
        watchOverflow: true,
        resistanceRatio: 0,
        on: {
            init() {
                const first = this.slides[this.activeIndex];
                const v = first?.querySelector('video');
                if (v) { v.muted = true; v.play().catch(() => {}); }
            },
            slideChangeTransitionStart() {
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
        rtl: true,
        speed: 700,
        autoplay: { delay: 5000, disableOnInteraction: false },
        slidesPerView: 1,
        pagination: { el: '.testimonials-pagination', clickable: true },
        watchOverflow: true,
    });

    // Category filter — uses CSS vars instead of hardcoded colors
    function filterServices(cat) {
        document.querySelectorAll('.service-card').forEach(card => {
            card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
        });
        document.querySelectorAll('.cat-tab').forEach(btn => {
            if (btn.dataset.cat === cat) {
                btn.classList.add('cat-tab-active');
                btn.style.cssText = '';
            } else {
                btn.classList.remove('cat-tab-active');
                btn.style.cssText = 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.65);border:1px solid rgba(255,255,255,0.1);';
            }
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
