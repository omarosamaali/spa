@php $t = $siteTheme; @endphp
<style>
:root {
    --spa-primary: {{ $t['primary'] }};
    --spa-primary-dark: {{ $t['primary_dark'] }};
    --spa-primary-light: {{ $t['primary_light'] }};
    --spa-gold: {{ $t['gold'] }};
    --spa-dark: {{ $t['dark'] }};
    --spa-dark-2: {{ $t['dark_2'] }};
    --color-rose-spa: {{ $t['primary'] }};
    --color-rose-light: {{ $t['primary_light'] }};
    --color-rose-dark: {{ $t['primary_dark'] }};
    --color-gold: {{ $t['gold'] }};
    --color-dark: {{ $t['dark'] }};
    --color-dark-2: {{ $t['dark_2'] }};
}
</style>
