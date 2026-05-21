<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NAY SPA - جمالك يستحق العناية')</title>
    <meta name="description" content="@yield('description', 'أحدث العلاجات وأفضل الخبرات في مكان واحد. احجزي موعدك الآن واستمتعي بتجربة فريدة.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.site-theme-vars')
    @include('partials.site-favicon')
    @stack('head')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar gradient-hero py-4" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-2 min-w-0">
                @include('partials.site-logo', ['size' => 32])

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>
                    <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">الخدمات</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">عن المركز</a>
                    <a href="#" class="nav-link">الأسعار</a>
                    <a href="#" class="nav-link">المدونة</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">تواصل معنا</a>
                    <div class="relative group">
                        <button class="nav-link flex items-center gap-1">العربية ▾</button>
                    </div>
                </div>

                {{-- Book Now Button --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('booking') }}" class="btn-primary hidden sm:inline-flex text-sm" style="padding:0.5rem 1rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        احجز الآن
                    </a>
                    {{-- Mobile menu button --}}
                    <button class="md:hidden text-white p-1" onclick="toggleMenu()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <button onclick="toggleMenu()" class="absolute top-6 left-6 text-white p-1">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <a href="{{ route('home') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">الرئيسية</a>
        <a href="{{ route('services') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">الخدمات</a>
        <a href="{{ route('about') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">عن المركز</a>
        <a href="{{ route('contact') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">تواصل معنا</a>
        <a href="{{ route('booking') }}" class="btn-primary text-xl mt-4" onclick="toggleMenu()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            احجز الآن
        </a>
    </div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="background:#1a1a1a; color:white; padding: 4rem 0 2rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

                {{-- Contact --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">تواصل معنا</h3>
                    <div class="space-y-3 text-sm" style="color:rgba(255,255,255,0.75)">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.82 19.79 19.79 0 01.21 1.22 2 2 0 012.18 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.86-.86a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/></svg>
                            <a href="{{ $siteContact['tel_url'] }}" class="hover:text-white transition-colors no-underline" style="color:inherit; direction:ltr">{{ $siteContact['phone'] }}</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="{{ $siteContact['mailto_url'] }}" class="hover:text-white transition-colors no-underline" style="color:inherit">{{ $siteContact['email'] }}</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $siteContact['address'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">روابط سريعة</h3>
                    <div class="space-y-2 text-sm" style="color:rgba(255,255,255,0.75)">
                        <div><a href="{{ route('home') }}" class="hover:text-white transition-colors">الرئيسية</a></div>
                        <div><a href="{{ route('services') }}" class="hover:text-white transition-colors">الخدمات</a></div>
                        <div><a href="{{ route('about') }}" class="hover:text-white transition-colors">عن المركز</a></div>
                        <div><a href="{{ route('booking') }}" class="hover:text-white transition-colors">الأسعار</a></div>
                        <div><a href="{{ route('contact') }}" class="hover:text-white transition-colors">تواصل معنا</a></div>
                    </div>
                </div>

                {{-- Working Hours --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">ساعات العمل</h3>
                    <div class="space-y-2 text-sm" style="color:rgba(255,255,255,0.75)">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>السبت — الخميس: {{ $siteContact['hours_weekdays'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>الجمعة: {{ $siteContact['hours_friday'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Social --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">تابعينا</h3>
                    @include('partials.social-links', ['variant' => 'footer'])
                    <h4 class="font-bold mb-3 text-sm" style="color:#e8b4b8">حمّل التطبيق</h4>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold transition-all hover:opacity-80" style="background:rgba(255,255,255,0.1)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                            App Store
                        </a>
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold transition-all hover:opacity-80" style="background:rgba(255,255,255,0.1)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M3.18 23.76c.3.17.64.19.96.07l12.45-6.97-2.68-2.67L3.18 23.76zm-1.54-19c-.1.22-.16.47-.16.74v17c0 .27.06.52.16.74l.08.08 9.53-9.52v-.22L1.64 4.68l-.08.08zm20.08 8.26l-2.7-1.52-3.03 3.03 3.03 3.03 2.72-1.52c.78-.43.78-1.15-.02-1.58v.04zM4.14.17L16.59 7.14l-2.68 2.68L3.18.24a.96.96 0 01.96-.07z"/></svg>
                            Google Play
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6 text-center text-sm" style="border-color:rgba(255,255,255,0.1); color:rgba(255,255,255,0.5)">
                جميع الحقوق محفوظة © NAY SPA {{ date('Y') }}
            </div>
        </div>
    </footer>

    {{-- WhatsApp Floating Button --}}
    <a href="{{ $siteContact['whatsapp_url'] }}" target="_blank" rel="noopener"
       class="fixed bottom-6 left-6 w-14 h-14 rounded-full flex items-center justify-center shadow-xl z-50 transition-all hover:scale-110"
       style="background:linear-gradient(135deg,#25d366,#128c7e);box-shadow:0 4px 20px rgba(37,211,102,0.4);">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
    </a>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('open');
        }

        // Sticky navbar effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
