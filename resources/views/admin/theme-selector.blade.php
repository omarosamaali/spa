@extends('layouts.admin')

@section('title', 'اختيار الثيم')

@push('head')
<style>
/* ── Browser Mockup ─────────────────────── */
.theme-card { transition: transform 0.25s cubic-bezier(0.34,1.4,0.64,1), box-shadow 0.25s ease; }
.theme-card:hover { transform: translateY(-4px) scale(1.01); }

.browser-frame { border-radius: 10px 10px 0 0; overflow: hidden; }
.browser-bar   { display:flex; align-items:center; gap:5px; padding:5px 9px; }
.browser-dot   { width:6px; height:6px; border-radius:50%; }
.browser-url   { flex:1; height:10px; border-radius:5px; opacity:.2; background:rgba(255,255,255,.5); margin:0 5px; }

.mini-site { position:relative; overflow:hidden; }
.mini-nav  { display:flex; align-items:center; padding:4px 8px; gap:5px; }
.mini-logo-block { width:28px; height:7px; border-radius:3px; }
.mini-nav-links  { display:flex; gap:3px; margin-right:auto; }
.mini-nav-link   { width:16px; height:3px; border-radius:2px; opacity:.28; }
.mini-hero { position:relative; padding:12px 10px 16px; display:flex; flex-direction:column; gap:4px; }
.mini-hero-badge    { width:30px; height:4px; border-radius:2px; opacity:.7; }
.mini-hero-title-1  { height:8px; border-radius:3px; opacity:.92; }
.mini-hero-title-2  { height:8px; border-radius:3px; opacity:.75; width:58%; }
.mini-hero-subtitle { height:3px; border-radius:2px; opacity:.4; width:78%; margin-top:2px; }
.mini-hero-btns     { display:flex; gap:3px; margin-top:4px; }
.mini-hero-btn      { height:9px; border-radius:4px; }
.mini-cards-row { display:flex; gap:3px; padding:5px 8px; }
.mini-card { flex:1; border-radius:3px; height:18px; }
.mini-footer { height:10px; opacity:.35; }

/* layout variants */
.layout-classic   .mini-hero { align-items:flex-start; }
.layout-centered  .mini-hero { align-items:center; }
.layout-centered  .mini-hero-title-1,
.layout-centered  .mini-hero-title-2,
.layout-centered  .mini-hero-subtitle { margin-left:auto; margin-right:auto; }
.layout-centered  .mini-hero-btns { justify-content:center; }
.layout-minimal   .mini-hero { align-items:center; }
.layout-minimal   .mini-hero-title-1 { height:10px; width:68%; font-weight:300; }
.layout-minimal   .mini-hero-title-2 { display:none; }
.layout-nature    .mini-hero { justify-content:flex-end; align-items:center; min-height:72px; padding-top:28px; }
.layout-editorial .mini-hero { align-items:flex-start; padding-right:16px; }
.layout-editorial .mini-site::before { content:''; position:absolute; right:10px; top:14px; bottom:10px; width:1.5px; border-radius:1px; background:currentColor; opacity:.18; }
.layout-bold .mini-hero { align-items:flex-start; }
.layout-bold .mini-hero-title-1 { height:12px; width:80%; }
.layout-bold .mini-hero-title-2 { height:12px; width:62%; }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">اختيار ثيم الموقع</h1>
            <p class="text-gray-400 mt-1 text-sm">اختر الثيم الذي سيظهر على الموقع العام للعملاء</p>
        </div>
        <a href="{{ route('themes') }}" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors"
           style="background:rgba(255,255,255,0.07); color:#e2e8f0; border:1px solid rgba(255,255,255,0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            صفحة الثيمات العامة
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 px-4 py-3 rounded-lg text-sm font-medium" style="background:rgba(16,185,129,0.15); color:#6ee7b7; border:1px solid rgba(16,185,129,0.3);">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Themes Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($themes as $theme)
        @php
            $isActive  = ($theme['id'] === $activeId);
            $colors    = $theme['preview_colors'];
            $primary   = $colors[0];
            $darkBg    = $colors[3];
            $darkMode  = $theme['dark_mode'];
            $navGrad   = $theme['nav_gradient'];
            $heroGrad  = $theme['hero_gradient'];
            $layout    = $theme['hero_layout'] ?? 'classic';
            $innerBg   = $darkMode ? $darkBg : '#faf9f6';
            $layoutLabel = [
                'classic'   => 'كلاسيك',
                'centered'  => 'مركزي',
                'minimal'   => 'مينيمال',
                'nature'    => 'طبيعة',
                'editorial' => 'إيديتوريال',
                'bold'      => 'بولد',
            ][$layout] ?? $layout;
        @endphp

        <div class="theme-card rounded-2xl overflow-hidden"
             style="background:#1a1a1a; box-shadow:0 4px 20px rgba(0,0,0,0.5) {{ $isActive ? ', 0 0 0 2px '.$primary : '' }};">

            {{-- ── BROWSER MOCKUP ── --}}
            <div class="browser-frame" style="background:{{ $innerBg }}; position:relative;">

                {{-- Active badge overlay --}}
                @if($isActive)
                <div class="absolute top-2 right-2 z-10 px-2 py-0.5 rounded-full text-[10px] font-bold"
                     style="background:{{ $primary }}; color:{{ $darkBg }};">
                    ✓ مفعّل
                </div>
                @endif

                {{-- Chrome bar --}}
                <div class="browser-bar" style="background:{{ $darkMode ? 'rgba(0,0,0,0.55)' : 'rgba(0,0,0,0.1)' }};">
                    <div class="browser-dot" style="background:#ff5f57;"></div>
                    <div class="browser-dot" style="background:#febc2e;"></div>
                    <div class="browser-dot" style="background:#28c840;"></div>
                    <div class="browser-url"></div>
                </div>

                {{-- Mini site --}}
                <div class="mini-site layout-{{ $layout }}">
                    {{-- Nav --}}
                    <div class="mini-nav" style="background:{{ $navGrad }};">
                        <div class="mini-logo-block" style="background:{{ $primary }};"></div>
                        <div class="mini-nav-links">
                            <div class="mini-nav-link" style="background:{{ $primary }};"></div>
                            <div class="mini-nav-link" style="background:rgba(255,255,255,.4);"></div>
                            <div class="mini-nav-link" style="background:rgba(255,255,255,.4);"></div>
                        </div>
                        <div style="height:16px;width:32px;border-radius:3px;background:{{ $primary }};opacity:.85;"></div>
                    </div>

                    {{-- Hero --}}
                    <div class="mini-hero" style="background:{{ $heroGrad }},linear-gradient({{ $darkBg }},{{ $darkBg }});">
                        <div class="mini-hero-badge" style="background:{{ $primary }};"></div>
                        <div class="mini-hero-title-1 w-full" style="background:rgba(255,255,255,.9);"></div>
                        <div class="mini-hero-title-2" style="background:{{ $primary }};"></div>
                        <div class="mini-hero-subtitle" style="background:rgba(255,255,255,.35);"></div>
                        <div class="mini-hero-btns">
                            <div class="mini-hero-btn w-14" style="background:{{ $primary }};"></div>
                            <div class="mini-hero-btn w-10" style="background:transparent;border:1px solid {{ $primary }};opacity:.55;"></div>
                        </div>
                    </div>

                    {{-- Content cards --}}
                    <div class="mini-cards-row" style="background:{{ $darkMode ? ($theme['dark_2'] ?? $darkBg) : '#f0ede8' }};">
                        @for($i=0; $i<3; $i++)
                        <div class="mini-card" style="background:{{ $primary }}18; border:1px solid {{ $primary }}30;">
                            <div style="height:6px;margin:3px 4px 2px;border-radius:2px;background:{{ $primary }};opacity:.6;"></div>
                            <div style="height:3px;margin:0 4px;border-radius:1px;background:rgba(255,255,255,.18);width:65%;"></div>
                        </div>
                        @endfor
                    </div>

                    <div class="mini-footer" style="background:{{ $darkMode ? ($theme['dark_3'] ?? $darkBg) : '#e5ddd5' }};"></div>
                </div>
            </div>{{-- end browser-frame --}}

            {{-- ── CARD INFO ── --}}
            <div class="p-4">

                {{-- Name + layout badge --}}
                <div class="flex items-center justify-between gap-2 mb-1">
                    <h3 class="font-bold text-[0.92rem] text-white tracking-wide" style="font-family:'Cormorant Garamond',Georgia,serif;">
                        {{ $theme['name'] }}
                    </h3>
                    <span class="text-[0.62rem] px-1.5 py-0.5 rounded-full flex-shrink-0"
                          style="background:{{ $primary }}18; color:{{ $primary }}; border:1px solid {{ $primary }}30;">
                        {{ $layoutLabel }}
                    </span>
                </div>

                <p class="text-[0.7rem] mb-3 leading-snug" style="color:rgba(255,255,255,0.45);">
                    {{ $theme['description'] }}
                </p>

                {{-- Color dots --}}
                <div class="flex items-center gap-1.5 mb-4">
                    @foreach($colors as $c)
                    <div class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="background:{{ $c }}; border:1px solid rgba(255,255,255,.15); box-shadow:0 1px 3px rgba(0,0,0,.3);"></div>
                    @endforeach
                    <span class="text-[0.6rem] mr-auto" style="color:rgba(255,255,255,0.3);">
                        {{ $theme['dark_mode'] ? '🌙 داكن' : '☀️ فاتح' }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    @if(! $isActive)
                    <form method="POST" action="{{ route('admin.theme-selector.set') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="theme_id" value="{{ $theme['id'] }}">
                        <button type="submit"
                                class="w-full py-2 rounded-lg text-xs font-semibold transition-all hover:opacity-90"
                                style="background:{{ $primary }}; color:{{ $darkBg }};">
                            تفعيل
                        </button>
                    </form>
                    @else
                    <div class="flex-1 py-2 rounded-lg text-xs font-semibold text-center"
                         style="background:{{ $primary }}20; color:{{ $primary }}; border:1px solid {{ $primary }}40;">
                        الثيم الحالي
                    </div>
                    @endif

                    <a href="{{ route('themes.preview', $theme['id']) }}" target="_blank"
                       class="px-3 py-2 rounded-lg text-xs transition-colors flex items-center"
                       style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);" title="معاينة">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Info note --}}
    <div class="mt-8 px-4 py-3 rounded-lg text-sm" style="background:rgba(255,255,255,0.03); color:#64748b; border:1px solid rgba(255,255,255,0.07);">
        <strong class="text-gray-400">ملاحظة:</strong>
        اللوجو المرفوع من
        <a href="{{ route('admin.branding-settings') }}" class="underline" style="color:var(--spa-primary);">الألوان والشعار</a>
        يظهر على جميع الثيمات. التعديلات اليدوية للألوان تطغى على ألوان الثيم المختار.
    </div>

</div>
@endsection
