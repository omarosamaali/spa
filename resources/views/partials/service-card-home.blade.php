@php
    $cardImg = $img ?? '';
    $cardName = $name ?? '';
    $cardDesc = $desc ?? '';
    $cardPrice = $price ?? null;
    $cardDuration = $duration ?? null;
    $cardCat = $category ?? 'all';
    $cardBookingUrl = $bookingUrl ?? route('booking');
    $cardVariant = $variant ?? 'home';
    $cardIcon = isset($icon) && $icon !== '' ? $icon : null;
    $fallbackImg = \App\Models\Service::categoryStockImage($cardCat !== 'all' ? $cardCat : null);
@endphp
<a href="{{ $cardBookingUrl }}"
   class="service-card service-card--visual service-card--clickable service-card--{{ $cardVariant }} group no-underline"
   style="width: 100%;"
   data-category="{{ $cardCat }}"
   aria-label="احجزي {{ $cardName }}">
    <img src="{{ $cardImg }}" alt=""
         class="service-card__img transition-transform duration-500 group-hover:scale-105"
         loading="lazy"
         onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
    <div class="service-card__overlay" aria-hidden="true"></div>
    @if($cardDuration)
    <span class="service-card__duration">⏱ {{ $cardDuration }} د</span>
    @endif
    <div class="service-card__content">
        <h3 class="service-card__title">
            @if($cardIcon)<span class="service-card__icon" aria-hidden="true">{{ $cardIcon }}</span>@endif
            <span>{{ $cardName }}</span>
        </h3>
        @if($cardDesc)
        <p class="service-card__desc">{{ $cardDesc }}</p>
        @endif
        <div class="service-card__footer">
            @if($cardPrice)
            <span class="service-card__price">{{ is_numeric($cardPrice) ? number_format($cardPrice) : $cardPrice }} <span>د.ع</span></span>
            @else
            <span></span>
            @endif
            <span class="btn-service-ghost">احجزي الآن</span>
        </div>
    </div>
</a>
