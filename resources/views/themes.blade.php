<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثيمات NAY SPA</title>
    @include('partials.site-favicon')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #0d0d0d;
            color: #e8e0dd;
            min-height: 100vh;
        }

        .themes-hero {
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1010 50%, #0d0d0d 100%);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* ─── Theme Card ──────────────────────────────── */
        .theme-card {
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s ease;
            cursor: default;
        }
        .theme-card:hover {
            transform: translateY(-6px) scale(1.01);
        }

        /* ─── Browser Mockup Frame ─────────────────────── */
        .browser-frame {
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            position: relative;
        }
        .browser-bar {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
        }
        .browser-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }
        .browser-url {
            flex: 1;
            height: 12px;
            border-radius: 6px;
            margin: 0 6px;
            opacity: 0.25;
            background: rgba(255,255,255,0.5);
        }

        /* ─── Mini Site Inside Frame ──────────────────── */
        .mini-site {
            position: relative;
            overflow: hidden;
        }
        .mini-nav {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            gap: 6px;
        }
        .mini-logo-block {
            width: 32px;
            height: 8px;
            border-radius: 3px;
        }
        .mini-nav-links {
            display: flex;
            gap: 4px;
            margin-right: auto;
        }
        .mini-nav-link {
            width: 20px;
            height: 4px;
            border-radius: 2px;
            opacity: 0.3;
        }
        .mini-hero {
            position: relative;
            padding: 14px 12px 18px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .mini-hero-badge {
            width: 36px;
            height: 5px;
            border-radius: 3px;
            opacity: 0.7;
        }
        .mini-hero-title-1 {
            height: 9px;
            border-radius: 4px;
            opacity: 0.95;
        }
        .mini-hero-title-2 {
            height: 9px;
            border-radius: 4px;
            opacity: 0.8;
            width: 60%;
        }
        .mini-hero-subtitle {
            height: 4px;
            border-radius: 2px;
            opacity: 0.45;
            width: 80%;
            margin-top: 2px;
        }
        .mini-hero-subtitle-2 {
            height: 4px;
            border-radius: 2px;
            opacity: 0.3;
            width: 65%;
        }
        .mini-hero-btns {
            display: flex;
            gap: 4px;
            margin-top: 5px;
        }
        .mini-hero-btn {
            height: 10px;
            border-radius: 5px;
        }
        .mini-content-row {
            display: flex;
            gap: 4px;
            padding: 6px 10px;
        }
        .mini-card {
            flex: 1;
            border-radius: 4px;
            height: 22px;
        }
        .mini-footer {
            height: 14px;
            opacity: 0.4;
        }

        /* ─── Layout Variants ─────────────────────────── */
        /* classic: left-aligned */
        .layout-classic .mini-hero { align-items: flex-start; }
        /* centered: centered */
        .layout-centered .mini-hero { align-items: center; text-align: center; }
        .layout-centered .mini-hero-title-1,
        .layout-centered .mini-hero-title-2,
        .layout-centered .mini-hero-subtitle,
        .layout-centered .mini-hero-subtitle-2 { margin-left: auto; margin-right: auto; }
        .layout-centered .mini-hero-btns { justify-content: center; }
        /* minimal: centered, thin title */
        .layout-minimal .mini-hero { align-items: center; }
        .layout-minimal .mini-hero-title-1 { height: 11px; font-weight: 300; width: 70%; }
        .layout-minimal .mini-hero-title-2 { display: none; }
        /* nature: bottom center */
        .layout-nature .mini-hero { justify-content: flex-end; align-items: center; min-height: 80px; padding-top: 30px; }
        /* editorial: left with side bar */
        .layout-editorial .mini-hero { align-items: flex-start; padding-right: 18px; }
        .layout-editorial::before {
            content: '';
            position: absolute;
            right: 12px;
            top: 10px;
            bottom: 10px;
            width: 2px;
            border-radius: 1px;
            background: currentColor;
            opacity: 0.2;
        }
        /* bold: left, very large title */
        .layout-bold .mini-hero { align-items: flex-start; }
        .layout-bold .mini-hero-title-1 { height: 14px; width: 80%; }
        .layout-bold .mini-hero-title-2 { height: 14px; width: 65%; }

        /* ─── Card Info ───────────────────────────────── */
        .preview-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 9px 0;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: filter 0.2s, transform 0.15s;
            width: 100%;
        }
        .preview-btn:hover {
            filter: brightness(1.12);
            transform: scale(1.02);
        }
        .active-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
        }
        .color-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.2);
            flex-shrink: 0;
        }
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.07), transparent);
        }
    </style>
</head>
<body>

    {{-- ======= HERO HEADER ======= --}}
    <header class="themes-hero py-14 text-center">
        <div class="max-w-2xl mx-auto px-6">
            <div class="mb-4 flex justify-center">
                @include('partials.site-logo', ['size' => 'md', 'center' => true])
            </div>
            <h1 class="text-3xl font-light tracking-widest text-white mt-5" style="font-family:'Cormorant Garamond',serif; letter-spacing:0.22em;">
                THEME COLLECTION
            </h1>
            <p class="mt-2 text-gray-500 text-sm tracking-wide">اكتشف 10 هويات بصرية مختلفة لـ NAY SPA</p>
            <div class="section-divider mt-7 max-w-xs mx-auto"></div>
        </div>
    </header>

    {{-- ======= THEMES GRID ======= --}}
    <main class="max-w-7xl mx-auto px-5 py-12">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">

            @foreach($themes as $theme)
            @php
                $isActive    = ($theme['id'] === $activeId);
                $colors      = $theme['preview_colors'];
                $primary     = $colors[0];
                $accent      = $colors[2] ?? $colors[1];
                $darkBg      = $colors[3];
                $darkMode    = $theme['dark_mode'];
                $cardBg      = '#1a1a1a';
                $bodyText    = '#e8e0dd';
                $subText     = 'rgba(232,224,221,0.5)';
                $innerBg     = $darkMode ? $darkBg : '#faf9f6';
                $innerText   = $darkMode ? 'rgba(255,255,255,0.9)' : 'rgba(0,0,0,0.85)';
                $navBg       = $theme['nav_gradient'] ?? "linear-gradient(135deg,{$darkBg},#000)";
                $heroGrad    = $theme['hero_gradient'];
                $layout      = $theme['hero_layout'] ?? 'classic';
                // Parse primary hex to rgb for glow
                $rgb = sscanf(ltrim($primary,'#'),"%02x%02x%02x");
                $rgbStr = implode(',',$rgb);
                $layoutLabel = [
                    'classic'   => 'كلاسيك',
                    'centered'  => 'مركزي',
                    'minimal'   => 'مينيمال',
                    'nature'    => 'طبيعة',
                    'editorial' => 'إيديتوريال',
                    'bold'      => 'بولد',
                ][$layout] ?? $layout;
            @endphp

            <article class="theme-card rounded-2xl overflow-hidden"
                     style="background:{{ $cardBg }}; box-shadow: 0 4px 28px rgba(0,0,0,0.5){{ $isActive ? ', 0 0 0 2px '.$primary : '' }};">

                {{-- ── BROWSER MOCKUP ── --}}
                <div class="browser-frame" style="background:{{ $innerBg }};">

                    {{-- Browser chrome bar --}}
                    <div class="browser-bar" style="background:{{ $darkMode ? 'rgba(0,0,0,0.6)' : 'rgba(0,0,0,0.12)' }};">
                        <div class="browser-dot" style="background:#ff5f57;"></div>
                        <div class="browser-dot" style="background:#febc2e;"></div>
                        <div class="browser-dot" style="background:#28c840;"></div>
                        <div class="browser-url"></div>
                    </div>

                    {{-- Mini site --}}
                    <div class="mini-site layout-{{ $layout }}">

                        {{-- Mini Nav --}}
                        <div class="mini-nav" style="background:{{ $navBg }};">
                            <div class="mini-logo-block" style="background:{{ $primary }};"></div>
                            <div class="mini-nav-links">
                                <div class="mini-nav-link" style="background:{{ $primary }};"></div>
                                <div class="mini-nav-link" style="background:rgba(255,255,255,0.4);"></div>
                                <div class="mini-nav-link" style="background:rgba(255,255,255,0.4);"></div>
                            </div>
                            <div class="h-5 w-10 rounded" style="background:{{ $primary }};opacity:0.8;"></div>
                        </div>

                        {{-- Mini Hero --}}
                        <div class="mini-hero" style="background:{{ $heroGrad }}, url() center/cover;">
                            {{-- hero bg fill --}}
                            <div class="absolute inset-0 -z-10" style="background:{{ $darkMode ? $darkBg : '#6b4f3a' }};"></div>

                            <div class="mini-hero-badge" style="background:{{ $primary }};"></div>
                            <div class="mini-hero-title-1 w-full" style="background:{{ $innerText === 'rgba(0,0,0,0.85)' ? 'rgba(255,255,255,0.9)' : 'rgba(255,255,255,0.92)' }};"></div>
                            <div class="mini-hero-title-2" style="background:{{ $primary }};"></div>
                            <div class="mini-hero-subtitle" style="background:rgba(255,255,255,0.4);"></div>
                            <div class="mini-hero-subtitle-2" style="background:rgba(255,255,255,0.25);"></div>
                            <div class="mini-hero-btns">
                                <div class="mini-hero-btn w-16" style="background:{{ $primary }};"></div>
                                <div class="mini-hero-btn w-12" style="background:transparent;border:1px solid {{ $primary }};opacity:0.6;"></div>
                            </div>
                        </div>

                        {{-- Mini Content Cards --}}
                        <div class="mini-content-row" style="background:{{ $darkMode ? $theme['dark_2'] ?? $darkBg : '#f0ede8' }};">
                            @for($i=0;$i<3;$i++)
                            <div class="mini-card" style="background:{{ $primary }}18; border:1px solid {{ $primary }}30;">
                                <div style="height:8px;margin:4px 5px 3px;border-radius:3px;background:{{ $primary }};opacity:0.6;"></div>
                                <div style="height:4px;margin:0 5px;border-radius:2px;background:rgba(255,255,255,0.2);width:70%;"></div>
                            </div>
                            @endfor
                        </div>

                        {{-- Mini Footer --}}
                        <div class="mini-footer" style="background:{{ $darkMode ? $theme['dark_3'] ?? $darkBg : '#e8e0d8' }};"></div>

                    </div>{{-- end mini-site --}}

                    {{-- Glow overlay on active --}}
                    @if($isActive)
                    <div class="absolute inset-0 pointer-events-none rounded-[inherit]" style="box-shadow:inset 0 0 0 2px {{ $primary }};"></div>
                    @endif

                </div>{{-- end browser-frame --}}

                {{-- ── CARD INFO ── --}}
                <div class="p-4">

                    {{-- Name + active badge --}}
                    <div class="flex items-start justify-between gap-2 mb-1.5">
                        <h2 class="font-bold text-[0.95rem] leading-tight" style="color:{{ $bodyText }}; font-family:'Cormorant Garamond',serif; letter-spacing:0.05em;">
                            {{ $theme['name'] }}
                        </h2>
                        @if($isActive)
                        <span class="active-badge flex-shrink-0" style="background:{{ $primary }}22; color:{{ $primary }}; border:1px solid {{ $primary }}44;">
                            ✓ مفعّل
                        </span>
                        @endif
                    </div>

                    <p class="text-[0.72rem] mb-3 leading-snug" style="color:{{ $subText }};">
                        {{ $theme['description'] }}
                    </p>

                    {{-- Color dots + layout label --}}
                    <div class="flex items-center gap-1.5 mb-4">
                        @foreach($colors as $c)
                        <div class="color-dot" style="background:{{ $c }};"></div>
                        @endforeach
                        <span class="text-[0.65rem] mr-auto px-1.5 py-0.5 rounded-full" style="color:{{ $primary }}; background:{{ $primary }}15; border:1px solid {{ $primary }}25;">
                            {{ $layoutLabel }}
                        </span>
                    </div>

                    {{-- Preview button --}}
                    <a href="{{ route('themes.preview', $theme['id']) }}" target="_blank"
                       class="preview-btn"
                       style="background:{{ $primary }}; color:{{ $darkMode ? $darkBg : '#ffffff' }};">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        معاينة الثيم
                    </a>

                </div>

            </article>
            @endforeach

        </div>

    </main>

    {{-- ======= FOOTER ======= --}}
    <footer class="py-7 text-center text-xs border-t" style="color:rgba(255,255,255,0.2); border-color:rgba(255,255,255,0.05);">
        <p>© {{ date('Y') }} NAY SPA — جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>
