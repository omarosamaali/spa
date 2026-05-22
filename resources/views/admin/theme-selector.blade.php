@extends('layouts.admin')

@section('title', 'اختيار الثيم')

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
           style="background:rgba(255,255,255,0.08); color:#e2e8f0; border:1px solid rgba(255,255,255,0.12);">
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

    @if(session('error'))
    <div class="mb-6 px-4 py-3 rounded-lg text-sm font-medium" style="background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.3);">
        ✗ {{ session('error') }}
    </div>
    @endif

    {{-- Themes Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($themes as $theme)
        @php
            $isActive = ($theme['id'] === $activeId);
            $colors   = $theme['preview_colors'];
            $darkMode = $theme['dark_mode'];
            $cardBg   = $darkMode ? $theme['dark'] : '#ffffff';
            $textClr  = $darkMode ? '#ffffff' : '#1a1a1a';
        @endphp

        <div class="theme-card relative rounded-2xl overflow-hidden transition-all duration-300 {{ $isActive ? 'ring-2 scale-[1.02]' : 'hover:scale-[1.01]' }}"
             style="background:{{ $cardBg }}; border:2px solid {{ $isActive ? $theme['primary'] : 'rgba(255,255,255,0.08)' }}; box-shadow: 0 4px 24px rgba(0,0,0,0.3);">

            {{-- Active Badge --}}
            @if($isActive)
            <div class="absolute top-3 right-3 z-10 px-2 py-0.5 rounded-full text-xs font-bold"
                 style="background:{{ $theme['primary'] }}; color:{{ $cardBg }};">
                ✓ مفعّل
            </div>
            @endif

            {{-- Color Swatch Strip --}}
            <div class="h-24 w-full flex">
                @foreach($colors as $c)
                <div class="flex-1" style="background:{{ $c }};"></div>
                @endforeach
            </div>

            {{-- Card Body --}}
            <div class="p-4">
                {{-- Theme Name --}}
                <h3 class="font-bold text-base tracking-wide mb-1" style="color:{{ $textClr }}; font-family:'Cormorant Garamond',serif, sans-serif;">
                    {{ $theme['name'] }}
                </h3>
                <p class="text-xs mb-3 opacity-70" style="color:{{ $textClr }};">
                    {{ $theme['description'] }}
                </p>

                {{-- Color Dots --}}
                <div class="flex items-center gap-1.5 mb-4">
                    @foreach($colors as $c)
                    <div class="w-4 h-4 rounded-full border border-white/20 shadow" style="background:{{ $c }};"></div>
                    @endforeach
                    <span class="text-xs ml-auto opacity-50" style="color:{{ $textClr }};">
                        {{ $theme['dark_mode'] ? 'داكن' : 'فاتح' }}
                    </span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    {{-- Activate --}}
                    @if(! $isActive)
                    <form method="POST" action="{{ route('admin.theme-selector.set') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="theme_id" value="{{ $theme['id'] }}">
                        <button type="submit"
                                class="w-full py-2 rounded-lg text-xs font-semibold transition-colors"
                                style="background:{{ $theme['primary'] }}; color:{{ $darkMode ? $theme['dark'] : '#ffffff' }};">
                            تفعيل
                        </button>
                    </form>
                    @else
                    <div class="flex-1 py-2 rounded-lg text-xs font-semibold text-center"
                         style="background:{{ $theme['primary'] }}22; color:{{ $theme['primary'] }}; border:1px solid {{ $theme['primary'] }}44;">
                        الثيم الحالي
                    </div>
                    @endif

                    {{-- Preview --}}
                    <a href="{{ route('themes.preview', $theme['id']) }}" target="_blank"
                       class="px-3 py-2 rounded-lg text-xs font-medium transition-colors"
                       style="background:rgba(255,255,255,0.06); color:{{ $textClr }}; border:1px solid rgba(255,255,255,0.12);"
                       title="معاينة على الموقع">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Info Note --}}
    <div class="mt-8 px-4 py-3 rounded-lg text-sm" style="background:rgba(255,255,255,0.04); color:#94a3b8; border:1px solid rgba(255,255,255,0.08);">
        <strong class="text-gray-300">ملاحظة:</strong>
        اللوجو والشعار المرفوعان من صفحة
        <a href="{{ route('admin.branding-settings') }}" class="underline" style="color:var(--spa-primary);">الألوان والشعار</a>
        يظهران على جميع الثيمات. التعديلات اليدوية للألوان من نفس الصفحة تطغى على ألوان الثيم المختار.
    </div>

</div>
@endsection
