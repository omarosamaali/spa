@php
    $links = $siteContact['social'] ?? [];
    $variant = $variant ?? 'footer';
@endphp

@if(count($links) > 0)
    @if($variant === 'contact')
    <div class="grid grid-cols-2 gap-3">
        @foreach($links as $s)
        <a href="{{ $s['url'] }}" target="_blank" rel="noopener"
           class="flex items-center gap-2 p-3 rounded-xl transition-all hover:opacity-80 no-underline"
           style="background:{{ $s['bg'] }}; border:1px solid {{ $s['border'] }}">
            @include('partials.social-icon', ['platform' => $s['key']])
            <span class="text-xs font-bold" style="color:{{ $s['color'] }}">{{ $s['label'] }}</span>
        </a>
        @endforeach
    </div>
    @else
    <div class="flex flex-wrap gap-3 mb-6">
        @foreach($links as $s)
        <a href="{{ $s['url'] }}" target="_blank" rel="noopener"
           class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 no-underline"
           style="background:rgba(255,255,255,0.1)"
           title="{{ $s['label'] }}">
            @include('partials.social-icon', ['platform' => $s['key'], 'size' => 18])
        </a>
        @endforeach
    </div>
    @endif
@endif
