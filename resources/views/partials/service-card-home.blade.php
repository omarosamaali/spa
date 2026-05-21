@php
    $cardImg = $img ?? '';
    $cardName = $name ?? '';
    $cardDesc = $desc ?? '';
    $cardPrice = $price ?? null;
    $cardCat = $category ?? 'all';
    $cardBookingUrl = $bookingUrl ?? route('booking');
@endphp
<div class="service-card service-card--visual group" style="width: 100%;" data-category="{{ $cardCat }}">
    <img src="{{ $cardImg }}" alt="{{ $cardName }}"
         class="service-card__img transition-transform duration-500 group-hover:scale-105"
         loading="lazy">
    <div class="service-card__overlay" aria-hidden="true"></div>
    <div class="service-card__content">
        <h3 class="service-card__title">{{ $cardName }}</h3>
        @if($cardDesc)
        <p class="service-card__desc">{{ $cardDesc }}</p>
        @endif
        <div class="service-card__footer">
            @if($cardPrice)
            <span class="service-card__price">{{ is_numeric($cardPrice) ? number_format($cardPrice) : $cardPrice }} <span>د.ع</span></span>
            @else
            <span></span>
            @endif
            <a href="{{ $cardBookingUrl }}" class="btn-service-ghost">احجزي الآن</a>
        </div>
    </div>
</div>
