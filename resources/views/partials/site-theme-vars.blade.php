@php $t = $siteTheme; @endphp
<style>
:root {
    --spa-primary: {{ $t['primary'] }};
    --spa-primary-dark: {{ $t['primary_dark'] }};
    --spa-primary-light: {{ $t['primary_light'] }};
    --spa-gold: {{ $t['gold'] }};
    --spa-dark: {{ $t['dark'] }};
    --spa-dark-2: {{ $t['dark_2'] }};
    --spa-dark-3: {{ $t['dark_3'] ?? $t['dark'] }};
    --spa-text-body: {{ $t['text_body'] ?? '#e8e0dd' }};
    --spa-hero-gradient: {{ $t['hero_gradient'] ?? '' }};
    --spa-nav-gradient: {{ $t['nav_gradient'] ?? '' }};
    /* legacy aliases */
    --color-rose-spa: {{ $t['primary'] }};
    --color-rose-light: {{ $t['primary_light'] }};
    --color-rose-dark: {{ $t['primary_dark'] }};
    --color-gold: {{ $t['gold'] }};
    --color-dark: {{ $t['dark'] }};
    --color-dark-2: {{ $t['dark_2'] }};
}
</style>
