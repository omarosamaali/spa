<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم - NAY SPA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.site-theme-vars')
    @include('partials.site-favicon')
</head>
<body class="admin-panel" style="background:#f5f0f0; color:#1a1a1a; margin:0">

@php
    $unreadContactsCount = \App\Models\ContactMessage::where('is_read', false)->count();
@endphp

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 flex-shrink-0 flex flex-col admin-sidebar" style="min-height:100vh; position:sticky; top:0; height:100vh">

        {{-- Logo --}}
        <div class="p-6" style="border-bottom:1px solid rgba(255,255,255,0.08)">
            @include('partials.site-logo', ['size' => 36, 'textClass' => 'text-sm'])
            <div class="text-xs mt-2 pr-1" style="color:rgba(255,255,255,0.4)">لوحة التحكم</div>
        </div>

        {{-- Navigation --}}
        <nav class="p-4 space-y-1 flex-1">
            @php
            $navItems = [
                ['route'=>'admin.dashboard', 'label'=>'الرئيسية',
                 'svg'=>'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
                ['route'=>'admin.appointments', 'label'=>'الحجوزات',
                 'svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                ['route'=>'admin.services', 'label'=>'الخدمات',
                 'svg'=>'<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/>'],
                ['route'=>'admin.staff', 'label'=>'الأخصائيات',
                 'svg'=>'<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                ['route'=>'admin.theme-selector', 'label'=>'اختيار الثيم',
                 'svg'=>'<circle cx="12" cy="8" r="3"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/><path d="M12 11v4M9 18h6"/>'],
                ['route'=>'admin.branding-settings', 'label'=>'الألوان والشعار',
                 'svg'=>'<circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>'],
                ['route'=>'admin.contact-settings', 'label'=>'إعدادات التواصل',
                 'svg'=>'<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.8 19.79 19.79 0 01.22 2.18 2 2 0 012.22 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/>'],
                ['route'=>'admin.hero-slides', 'label'=>'سلايدر الرئيسية',
                 'svg'=>'<polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>'],
                ['route'=>'admin.contacts', 'label'=>'الرسائل',
                 'svg'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>'],
            ];
            @endphp

            @foreach($navItems as $item)
            @php $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*'); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-bold transition-all"
               style="color:{{ $isActive ? 'var(--spa-primary)' : 'rgba(255,255,255,0.6)' }};
                      background:{{ $isActive ? 'rgba(232,180,184,0.12)' : 'transparent' }}">
                <div class="flex items-center gap-3">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $item['svg'] !!}
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </div>
                {{-- Unread badge for contacts --}}
                @if($item['route'] === 'admin.contacts' && $unreadContactsCount > 0)
                <span class="text-xs font-black px-1.5 py-0.5 rounded-full min-w-[20px] text-center"
                      style="background:var(--spa-primary); color:var(--spa-dark)">
                    {{ $unreadContactsCount > 99 ? '99+' : $unreadContactsCount }}
                </span>
                @endif
            </a>
            @endforeach
        </nav>

        {{-- Footer: user + logout --}}
        <div class="p-4" style="border-top:1px solid rgba(255,255,255,0.08)">
            @auth
            <div class="flex items-center gap-3 px-3 py-2 mb-2 rounded-xl" style="background:rgba(255,255,255,0.05)">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black text-white"
                     style="background:linear-gradient(135deg,var(--spa-primary),var(--spa-primary-dark))">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs truncate" style="color:rgba(255,255,255,0.35)">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm font-bold transition-all hover:opacity-80"
                        style="color:rgba(255,255,255,0.5); background:transparent">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    تسجيل الخروج
                </button>
            </form>
            @endauth
            <a href="{{ route('home') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold transition-all hover:opacity-80 no-underline"
               style="color:rgba(255,255,255,0.35)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                العودة للموقع
            </a>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 overflow-auto">

        {{-- Top bar --}}
        <div class="bg-white px-8 py-4 flex items-center justify-between" style="border-bottom:2px solid #f0e8e9; position:sticky; top:0; z-index:10">
            <h2 class="font-black text-lg" style="color:#1a1a1a">@yield('title', 'لوحة التحكم')</h2>
            <div class="flex items-center gap-3">
                @if($unreadContactsCount > 0)
                <a href="{{ route('admin.contacts', ['filter'=>'unread']) }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all hover:opacity-80"
                   style="background:#fef3c7; color:#d97706">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    {{ $unreadContactsCount }} رسالة جديدة
                </a>
                @endif
                <a href="{{ route('booking') }}" class="btn-primary text-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    حجز جديد
                </a>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-8 mt-4 p-4 rounded-xl flex items-center gap-3 text-sm font-bold" style="background:#d1fae5; color:#059669; border:1px solid #a7f3d0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mx-8 mt-4 p-4 rounded-xl flex items-center gap-3 text-sm font-bold" style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
        @endif

        <div class="p-8">
            @yield('content')
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>
