<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white no-underline">
                    <div class="text-right">
                        <div class="text-xl font-black tracking-wider" style="letter-spacing:3px">NAY SPA</div>
                        <div class="text-xs opacity-70" style="color:#e8b4b8">جمالك يستحق العناية</div>
                    </div>
                    <div class="text-2xl">🌸</div>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('booking') }}" class="btn-primary hidden sm:inline-flex">
                        <span>📅</span> احجز الآن
                    </a>
                    {{-- Mobile menu button --}}
                    <button class="md:hidden text-white text-2xl" onclick="toggleMenu()">☰</button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <button onclick="toggleMenu()" class="absolute top-6 left-6 text-white text-3xl">✕</button>
        <a href="{{ route('home') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">الرئيسية</a>
        <a href="{{ route('services') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">الخدمات</a>
        <a href="{{ route('about') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">عن المركز</a>
        <a href="{{ route('contact') }}" class="text-white text-2xl font-bold" onclick="toggleMenu()">تواصل معنا</a>
        <a href="{{ route('booking') }}" class="btn-primary text-xl mt-4" onclick="toggleMenu()">📅 احجز الآن</a>
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
                        <div class="flex items-center gap-2"><span>📞</span> <span>964+ 770 123 4567</span></div>
                        <div class="flex items-center gap-2"><span>✉️</span> <span>info@nayspa.iq</span></div>
                        <div class="flex items-center gap-2"><span>📍</span> <span>بغداد - المنصور - شارع 14 رمضان</span></div>
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
                        <div class="flex items-center gap-2"><span>🕐</span> <span>السبت - الخميس</span></div>
                        <div style="padding-right:1.5rem">10:00 ص - 10:00 م</div>
                        <div class="flex items-center gap-2 mt-2"><span>🕐</span> <span>الجمعة</span></div>
                        <div style="padding-right:1.5rem">2:00 م - 10:00 م</div>
                    </div>
                </div>

                {{-- Social --}}
                <div>
                    <h3 class="text-lg font-bold mb-4" style="color:#e8b4b8">تابعينا</h3>
                    <div class="flex gap-3 mb-6">
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:rgba(255,255,255,0.1)">📸</a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:rgba(255,255,255,0.1)">👥</a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:rgba(255,255,255,0.1)">👻</a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110" style="background:rgba(255,255,255,0.1)">🎵</a>
                    </div>
                    <h4 class="font-bold mb-3 text-sm" style="color:#e8b4b8">حمّل التطبيق</h4>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold transition-all hover:opacity-80" style="background:rgba(255,255,255,0.1)">🍎 App Store</a>
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold transition-all hover:opacity-80" style="background:rgba(255,255,255,0.1)">🤖 Google Play</a>
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
       class="fixed bottom-6 left-6 w-14 h-14 rounded-full flex items-center justify-center text-2xl shadow-xl z-50 transition-all hover:scale-110"
       style="background:linear-gradient(135deg,#25d366,#128c7e); box-shadow:0 4px 20px rgba(37,211,102,0.4)">
        💬
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
