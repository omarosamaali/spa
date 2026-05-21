@php
    $size = $size ?? 32;
    $showText = $showText ?? true;
    $textClass = $textClass ?? '';
@endphp
<a href="{{ route('home') }}" class="flex items-center gap-2 text-white no-underline min-w-0 flex-shrink {{ $linkClass ?? '' }}">
    @if($showText)
    <div class="text-right min-w-0 {{ $textClass }}">
        <div class="navbar-brand-text text-xl font-black tracking-wider" style="letter-spacing:3px">{{ $siteTheme['site_name'] }}</div>
        @if(!empty($siteTheme['site_tagline']))
        <div class="navbar-tagline text-xs opacity-70" style="color:var(--spa-primary)">{{ $siteTheme['site_tagline'] }}</div>
        @endif
    </div>
    @endif
    @if($siteTheme['has_logo'])
    <img src="{{ $siteTheme['logo_url'] }}" alt="{{ $siteTheme['site_name'] }}"
         style="height:{{ $size }}px;width:auto;max-width:{{ $size * 2.5 }}px;object-fit:contain;"
         class="flex-shrink-0">
    @else
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
        <ellipse cx="20" cy="14" rx="5" ry="10" fill="var(--spa-primary-light)" opacity="0.9"/>
        <ellipse cx="20" cy="14" rx="5" ry="10" fill="var(--spa-gold)" opacity="0.75" transform="rotate(60 20 20)"/>
        <ellipse cx="20" cy="14" rx="5" ry="10" fill="var(--spa-primary-light)" opacity="0.65" transform="rotate(120 20 20)"/>
        <ellipse cx="20" cy="14" rx="5" ry="10" fill="var(--spa-gold)" opacity="0.6" transform="rotate(180 20 20)"/>
        <circle cx="20" cy="20" r="6" fill="var(--spa-primary)"/>
    </svg>
    @endif
</a>
