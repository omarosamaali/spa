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
    @stack('head')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar gradient-hero py-4" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-2 min-w-0">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white no-underline min-w-0 flex-shrink">
                    <div class="text-right min-w-0">
                        <div class="navbar-brand-text text-xl font-black tracking-wider" style="letter-spacing:3px">NAY SPA</div>
                        <div class="navbar-tagline text-xs opacity-70" style="color:#e8b4b8">جمالك يستحق العناية</div>
                    </div>
                    <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal1)" opacity="0.9"/>
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal2)" opacity="0.75" transform="rotate(60 20 20)"/>
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal1)" opacity="0.65" transform="rotate(120 20 20)"/>
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal2)" opacity="0.6" transform="rotate(180 20 20)"/>
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal1)" opacity="0.55" transform="rotate(240 20 20)"/>
                        <ellipse cx="20" cy="14" rx="5" ry="10" fill="url(#lpetal2)" opacity="0.5" transform="rotate(300 20 20)"/>
                        <circle cx="20" cy="20" r="6" fill="url(#lcenter)"/>
                        <defs>
                            <linearGradient id="lpetal1" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#f5dfe1"/><stop offset="100%" stop-color="#c9888e" stop-opacity="0.5"/></linearGradient>
                            <linearGradient id="lpetal2" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#c9a96e"/><stop offset="100%" stop-color="#e8b4b8" stop-opacity="0.4"/></linearGradient>
                            <radialGradient id="lcenter" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#e8b4b8"/><stop offset="100%" stop-color="#c9888e"/></radialGradient>
                        </defs>
                    </svg>
                </a>

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
                            <span>+964 456 123 770</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>info@nayspa.iq</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>بغداد - المنصور - شارع 14 رمضان</span>
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
                            <span>السبت - الخميس: 10:00 ص - 10:00 م</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>الجمعة: 2:00 م - 10:00 م</span>
                        </div>
                    </div>
                </div>

                {{-- Social --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">تابعينا</h3>
                    <div class="flex gap-3 mb-6">
                        {{-- Instagram --}}
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 hover:bg-pink-600" style="background:rgba(255,255,255,0.1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 hover:bg-blue-600" style="background:rgba(255,255,255,0.1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        {{-- TikTok --}}
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:rgba(255,255,255,0.1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V9.41a8.16 8.16 0 004.77 1.52V7.49a4.85 4.85 0 01-1-.8z"/></svg>
                        </a>
                        {{-- Snapchat --}}
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 hover:bg-yellow-400" style="background:rgba(255,255,255,0.1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.166 3C8.68 3 6 5.677 6 9.16v1.36l-1.558.682a.38.38 0 00-.213.496l.43 1.037c.07.17.252.272.43.248.32-.04.636-.104.942-.19-.309.73-.74 1.397-1.281 1.974-.18.193-.13.5.103.618l.972.494c.18.09.397.038.512-.125.073-.104.15-.206.23-.307.27.066.555.1.844.1.498 0 .985-.094 1.436-.266-.016.175-.024.352-.024.531 0 2.006 1.68 3.648 3.724 3.648 2.044 0 3.724-1.642 3.724-3.648 0-.179-.008-.356-.024-.531.451.172.938.266 1.436.266.29 0 .574-.034.844-.1.08.1.157.203.23.307.115.163.333.215.512.125l.972-.494c.233-.118.283-.425.103-.618-.541-.577-.972-1.244-1.281-1.974.306.086.622.15.942.19.178.024.36-.078.43-.248l.43-1.037a.38.38 0 00-.213-.496L18 10.52V9.16C18 5.677 15.652 3 12.166 3z"/></svg>
                        </a>
                    </div>
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
    <a href="https://wa.me/9647701234567" target="_blank"
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
