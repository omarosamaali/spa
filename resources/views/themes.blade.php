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
            background: linear-gradient(135deg, #1a1a1a 0%, #2a1a1f 50%, #1a1a1a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .theme-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }

        .theme-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px rgba(0,0,0,0.5) !important;
        }

        .theme-swatch {
            height: 120px;
            width: 100%;
            display: flex;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
        }

        .theme-swatch-col {
            flex: 1;
            transition: flex 0.3s ease;
        }

        .theme-card:hover .theme-swatch-col:first-child {
            flex: 2;
        }

        .preview-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .preview-btn:hover {
            filter: brightness(1.1);
            transform: scale(1.02);
        }

        .active-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .color-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
        }
    </style>
</head>
<body>

    {{-- ======= HERO ======= --}}
    <header class="themes-hero py-16 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <div class="mb-4">
                @include('partials.site-logo', ['size' => 'md', 'center' => true])
            </div>
            <h1 class="text-4xl font-light tracking-widest text-white mt-6" style="font-family:'Cormorant Garamond',serif; letter-spacing:0.25em;">
                THEME COLLECTION
            </h1>
            <p class="mt-3 text-gray-400 text-sm tracking-wide">
                اكتشف ثيمات NAY SPA — كل ثيم تجربة بصرية فريدة
            </p>
            <div class="section-divider mt-8 max-w-xs mx-auto"></div>
        </div>
    </header>

    {{-- ======= THEMES GRID ======= --}}
    <main class="max-w-7xl mx-auto px-6 py-14">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach($themes as $theme)
            @php
                $isActive  = ($theme['id'] === $activeId);
                $colors    = $theme['preview_colors'];
                $darkMode  = $theme['dark_mode'];
                $cardBg    = $darkMode ? $theme['dark'] : '#faf9f7';
                $textPrimary = $darkMode ? '#ffffff' : '#1a1a1a';
                $textSub   = $darkMode ? 'rgba(255,255,255,0.55)' : 'rgba(0,0,0,0.45)';
            @endphp

            <article class="theme-card rounded-2xl overflow-hidden"
                     style="background:{{ $cardBg }}; box-shadow: 0 4px 24px rgba(0,0,0,0.35); border: 2px solid {{ $isActive ? $theme['primary'] : 'rgba(255,255,255,0.07)' }};">

                {{-- Color Swatch --}}
                <div class="theme-swatch">
                    @foreach($colors as $c)
                    <div class="theme-swatch-col" style="background:{{ $c }};"></div>
                    @endforeach
                </div>

                {{-- Card Content --}}
                <div class="p-5">

                    {{-- Name + Active Badge --}}
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h2 class="font-bold text-lg leading-tight" style="color:{{ $textPrimary }}; font-family:'Cormorant Garamond',serif;">
                            {{ $theme['name'] }}
                        </h2>
                        @if($isActive)
                        <span class="active-badge flex-shrink-0" style="background:{{ $theme['primary'] }}22; color:{{ $theme['primary'] }}; border:1px solid {{ $theme['primary'] }}44;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            مفعّل
                        </span>
                        @endif
                    </div>

                    <p class="text-xs leading-relaxed mb-4" style="color:{{ $textSub }};">
                        {{ $theme['description'] }}
                    </p>

                    {{-- Color Dots --}}
                    <div class="flex items-center gap-1.5 mb-5">
                        @foreach($colors as $c)
                        <div class="color-dot" style="background:{{ $c }};"></div>
                        @endforeach
                        <span class="text-xs mr-auto" style="color:{{ $textSub }};">
                            {{ $theme['dark_mode'] ? '🌙 داكن' : '☀️ فاتح' }}
                        </span>
                    </div>

                    {{-- Preview Button --}}
                    <a href="{{ route('themes.preview', $theme['id']) }}" target="_blank"
                       class="preview-btn w-full"
                       style="background:{{ $theme['primary'] }}; color:{{ $darkMode ? $theme['dark'] : '#ffffff' }};">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    <footer class="py-8 text-center text-xs text-gray-600 border-t" style="border-color:rgba(255,255,255,0.06);">
        <p>© {{ date('Y') }} NAY SPA — جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>
