@php
    $video = $stepsVideo ?? [];
    $source = $video['source'] ?? null;
@endphp
@if($source)
    @if(($source['type'] ?? '') === 'embed')
    <div class="booking-steps-video booking-steps-video--embed">
        <iframe src="{{ $source['src'] }}"
                title="فيديو الخطوات"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy"></iframe>
    </div>
    @else
    <div class="booking-steps-video booking-steps-video--file">
        <video controls playsinline preload="metadata"
               @if(!empty($source['poster'])) poster="{{ $source['poster'] }}" @endif>
            <source src="{{ $source['src'] }}">
        </video>
    </div>
    @endif
@endif
