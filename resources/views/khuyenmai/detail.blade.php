@extends('layouts.main.master')
@php
    $promoName = trim((string) $detail->name);
    $promoDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $detail->description)));
    $promoImage = !empty($detail->image) ? url($detail->image) : asset('frontend/images/resource/maindish1.jpg');
    $promoContent = trim((string) $detail->content);
    $promoPeriod = $detail->period_text;
    $promoExpired = $detail->is_expired;
    $promoLink = trim((string) $detail->link);
    $hotline = trim((string) ($setting->phone1 ?: $setting->phone));
@endphp
@section('title')
{{ $promoName }}
@endsection
@section('description')
{{ $promoDesc !== '' ? \Illuminate\Support\Str::limit($promoDesc, 160) : $promoName }}
@endsection
@section('image')
{{ $promoImage }}
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/taste-vn.css') }}">
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var el = document.querySelector('.promo-more__slider');
  if (!el || typeof Swiper === 'undefined') return;
  new Swiper(el, {
    slidesPerView: 1.15,
    spaceBetween: 16,
    watchOverflow: true,
    navigation: { nextEl: '.promo-more__nav--next', prevEl: '.promo-more__nav--prev' },
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 18 },
      992: { slidesPerView: 3, spaceBetween: 22 }
    }
  });
});
</script>
@endsection
@section('content')
<section class="inner-banner">
    <div class="image-layer" style="background-image: url('{{ $promoImage }}');"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>{{ $promoName }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><a href="{{ route('khuyenMai') }}">Ưu đãi</a></li>
                <li><span>{{ $promoName }}</span></li>
            </ul>
        </div>
    </div>
</section>

<section class="promo-detail">
    <div class="auto-container">
        <div class="promo-detail__layout">
            <article class="promo-detail__main">
                <figure class="promo-detail__media">
                    <img src="{{ $promoImage }}" alt="{{ $promoName }}" width="960" height="600" decoding="async">
                    @if(!empty($detail->badge))
                    <span class="promo-badge">{{ $detail->badge }}</span>
                    @endif
                </figure>

                <div class="promo-detail__meta">
                    <span class="promo-status {{ $promoExpired ? 'promo-status--ended' : 'promo-status--active' }}">
                        {{ $promoExpired ? 'Đã kết thúc' : 'Đang diễn ra' }}
                    </span>
                    @if($promoPeriod !== '')
                    <span class="promo-detail__period">
                        <i class="far fa-calendar-alt" aria-hidden="true"></i> {{ $promoPeriod }}
                    </span>
                    @endif
                </div>

                <h2 class="promo-detail__title">{{ $promoName }}</h2>

                @if($promoDesc !== '')
                <p class="promo-detail__lead">{{ $promoDesc }}</p>
                @endif

                @if($promoContent !== '')
                <div class="promo-detail__content rte_content">
                    {!! $promoContent !!}
                </div>
                @endif
            </article>

            <aside class="promo-detail__aside">
                <div class="promo-card">
                    <h3 class="promo-card__title">Thông tin ưu đãi</h3>
                    <ul class="promo-card__list">
                        @if(!empty($detail->badge))
                        <li>
                            <span>Ưu đãi</span>
                            <strong>{{ $detail->badge }}</strong>
                        </li>
                        @endif
                        <li>
                            <span>Thời gian áp dụng</span>
                            <strong>{{ $promoPeriod !== '' ? $promoPeriod : 'Đến khi có thông báo mới' }}</strong>
                        </li>
                        <li>
                            <span>Tình trạng</span>
                            <strong class="{{ $promoExpired ? 'is-ended' : 'is-active' }}">{{ $promoExpired ? 'Đã kết thúc' : 'Đang diễn ra' }}</strong>
                        </li>
                    </ul>

                    @if(!$promoExpired)
                    <a class="tov-btn tov-btn--primary promo-card__btn js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                        Đặt bàn nhận ưu đãi <span aria-hidden="true">→</span>
                    </a>
                    @endif
                    @if($promoLink !== '')
                    <a class="tov-btn tov-btn--outline promo-card__btn" href="{{ $promoLink }}" target="_blank" rel="noopener">
                        Xem thêm chi tiết <span aria-hidden="true">→</span>
                    </a>
                    @endif

                    @if($hotline !== '')
                    <div class="promo-card__hotline">
                        <span>Hotline đặt bàn</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hotline) }}">
                            <i class="far fa-phone" aria-hidden="true"></i> {{ $hotline }}
                        </a>
                    </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

@if(($otherPromotions ?? collect())->isNotEmpty())
<section class="promo-more">
    <div class="auto-container">
        <div class="promo-more__head">
            <div>
                <p class="tov-eyebrow">Ưu đãi đặc biệt</p>
                <h2 class="tov-heading">Ưu đãi khác</h2>
            </div>
            <div class="promo-more__actions">
                <a class="tov-link" href="{{ route('khuyenMai') }}">Xem tất cả <span aria-hidden="true">→</span></a>
                @if($otherPromotions->count() > 3)
                <button type="button" class="tov-reviews__nav promo-more__nav--prev" aria-label="Ưu đãi trước"><span class="fal fa-angle-left"></span></button>
                <button type="button" class="tov-reviews__nav promo-more__nav--next" aria-label="Ưu đãi tiếp"><span class="fal fa-angle-right"></span></button>
                @endif
            </div>
        </div>

        <div class="promo-more__slider swiper">
            <div class="swiper-wrapper">
                @foreach($otherPromotions as $item)
                @php
                    $itemUrl = route('detailKhuyenmai', ['slug' => $item->slug]);
                    $itemDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $item->description)));
                @endphp
                <div class="swiper-slide">
                    <article class="tov-offer-card">
                        <a class="tov-offer-card__media" href="{{ $itemUrl }}" title="{{ $item->name }}">
                            <img src="{{ !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg') }}" alt="{{ $item->name }}" width="480" height="300" loading="lazy" decoding="async">
                            @if(!empty($item->badge))
                            <span class="promo-badge promo-badge--sm">{{ $item->badge }}</span>
                            @endif
                        </a>
                        <div class="tov-offer-card__body">
                            <h3 class="tov-offer-card__title"><a href="{{ $itemUrl }}">{{ $item->name }}</a></h3>
                            @if($itemDesc !== '')
                            <p class="tov-offer-card__desc">{{ \Illuminate\Support\Str::limit($itemDesc, 90) }}</p>
                            @endif
                            <a class="tov-link" href="{{ $itemUrl }}">Xem chi tiết <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endsection
