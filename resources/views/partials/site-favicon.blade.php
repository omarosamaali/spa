@if($siteTheme['has_favicon'])
<link rel="icon" href="{{ $siteTheme['favicon_url'] }}" type="image/png">
<link rel="shortcut icon" href="{{ $siteTheme['favicon_url'] }}">
@else
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='{{ urlencode($siteTheme['primary_dark']) }}'/><circle cx='50' cy='50' r='22' fill='{{ urlencode($siteTheme['primary']) }}'/></svg>">
@endif
