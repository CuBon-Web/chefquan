@extends('layouts.main.master')
@php
    $comboImages = array_values(array_filter($combo->images_array ?: []));
    if (empty($comboImages) && !empty($setting->logo)) {
        $comboImages = [$setting->logo];
    }
    $cover = $comboImages[0] ?? ($setting->logo ?? '');
    $hasSale = $combo->sale_price !== null && (float) $combo->sale_price > 0 && (float) $combo->sale_price < (float) $combo->price;
    $hasManyImages = count($comboImages) > 1;
@endphp
@section('title')
{{ $combo->name }} | {{ $setting->company }}
@endsection
@section('description')
{{ $combo->description ?: ($setting->description ?? $setting->company) }}
@endsection
@section('image')
{{ $cover ? url($cover) : url($setting->logo ?? '') }}
@endsection
@section('css')
<style>.foodcombo-detail {
  padding: 20px 10px 15px;
}
.foodcombo-detail__price {
  font-size: 28px;
  font-weight: 700;
  color: var(--main-color);
  margin: 5px 0 12px;
}
.foodcombo-detail__price del {
  font-size: 18px;
  font-weight: 500;
  margin-right: 10px;
  color: rgba(255,255,255,0.45);
}
.foodcombo-detail__menu,
.foodcombo-detail__content {
  margin-top: 28px;
}
.foodcombo-detail__menu h3,
.foodcombo-detail__content h3 {
  margin-bottom: 14px;
    color: #ffffff;
    font-family: "Great Vibes", "Playfair Display", cursive;
}

.menu-one .foodcombo-gallery-slider {
  position: relative;
  overflow: hidden;
}

.menu-one .foodcombo-gallery-slider .swiper-slide {
  height: auto;
}

.menu-one .foodcombo-gallery-slider .image {
  width: 100%;
}

.menu-one .foodcombo-gallery-slider .image img {
  width: 100%;
  display: block;
  min-height: 500px;
    object-fit: cover;
}

.menu-one .foodcombo-gallery-nav {
  position: absolute;
  top: 50%;
  z-index: 5;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  transform: translateY(-50%);
  background: #3c0202;
  color: #e6b15c;
  border: 1px solid rgba(230, 177, 95, 0.55);
  cursor: pointer;
  transition: background 0.3s ease, color 0.3s ease;
  border-radius: 50%;
}

.menu-one .foodcombo-gallery-nav:hover {
  background: var(--main-color);
}

.menu-one .foodcombo-gallery-nav--prev {
  left: 14px;
}

.menu-one .foodcombo-gallery-nav--next {
  right: 14px;
}

.menu-one .foodcombo-gallery-pagination {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 39px;
  z-index: 5;
  text-align: center;
}

.menu-one .foodcombo-gallery-pagination .swiper-pagination-bullet {
  background: #fff;
  opacity: 0.55;
}

.menu-one .foodcombo-gallery-pagination .swiper-pagination-bullet-active {
  background: var(--main-color);
  opacity: 1;
}

.menu-one .combo-actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 12px;
  margin-top: 28px;
}

.menu-one .combo-more-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  min-width: 160px;
  padding: 12px 26px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  text-decoration: none;
  border: 1px solid transparent;
  border-radius: 10px;
  transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease,
    border-color 0.3s ease, color 0.3s ease;
}

.menu-one .combo-more-btn--primary {
  color: #3c0202;
  background: linear-gradient(135deg, #f0c987 0%, var(--main-color) 100%);
  box-shadow: 0 10px 24px rgba(230, 177, 95, 0.32);
}

.menu-one .combo-more-btn--primary::before {
  content: "☎";
  font-size: 14px;
  line-height: 1;
}

.menu-one .combo-more-btn--primary:hover {
  color: #3c0202;
  transform: translateY(-2px);
  box-shadow: 0 14px 30px rgba(230, 177, 95, 0.45);
  text-decoration: none;
}

@media (max-width: 767px) {
  .menu-one .combo-actions {
    margin-top: 22px;
  }

  .menu-one .combo-more-btn {
    width: 100%;
    min-width: 0;
  }
}
</style>
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper === 'undefined') return;
  var el = document.querySelector('.foodcombo-gallery-slider');
  if (!el) return;
  var slides = el.querySelectorAll('.swiper-slide').length;
  new Swiper(el, {
    slidesPerView: 1,
    spaceBetween: 0,
    speed: 650,
    loop: slides > 1,
    watchOverflow: true,
    navigation: slides > 1 ? {
      nextEl: el.querySelector('.foodcombo-gallery-nav--next'),
      prevEl: el.querySelector('.foodcombo-gallery-nav--prev'),
    } : undefined,
    pagination: slides > 1 ? {
      el: el.querySelector('.foodcombo-gallery-pagination'),
      clickable: true,
    } : undefined,
  });
});
</script>
@endsection
@section('content')
<section class="inner-banner">
  <div class="image-layer" style="background-image: url({{ url($cover) }});"></div>
  <div class="auto-container">
      <div class="inner">
          <h1 >{{ $combo->name }}</h1>
          @if($combo->description)
          <div class="sub_text"><p>{{ $combo->description }}</p></div>
          @endif
      </div>
  </div>
</section>
<section class="menu-one alternate">
  <div class="auto-container">
      <div class="row clearfix">
          <div class="image-col col-lg-6 col-md-12 col-sm-12">
              <div class="inner">
                  <div class="foodcombo-gallery-slider swiper">
                      <div class="swiper-wrapper">
                          @foreach($comboImages as $img)
                          <div class="swiper-slide">
                              <div class="image">
                                  <img src="{{ url($img) }}" alt="{{ $combo->name }}">
                              </div>
                          </div>
                          @endforeach
                      </div>
                      @if($hasManyImages)
                      <div class="foodcombo-gallery-nav foodcombo-gallery-nav--prev"><span class="fal fa-angle-left"></span></div>
                      <div class="foodcombo-gallery-nav foodcombo-gallery-nav--next"><span class="fal fa-angle-right"></span></div>
                      <div class="foodcombo-gallery-pagination"></div>
                      @endif
                  </div>
              </div>
          </div>
          <div class="menu-col col-lg-6 col-md-12 col-sm-12">
              <div class="inner">
                  <div class="title-box">
                      <h3>{{ $combo->name }}</h3>
                  </div>
                  <div class="foodcombo-detail__price">
                    @if($hasSale)
                      <del>{{ number_format((float) $combo->price) }}₫</del>
                      <span>{{ number_format((float) $combo->sale_price) }}₫</span>
                    @else
                      <span>{{ number_format((float) $combo->price) }}₫</span>
                    @endif
                  </div>
                  @if($combo->menu)
                    <div class="foodcombo-detail__menu" style="margin-top:0;">{!! $combo->menu !!}</div>
                  @endif
                  <div class="combo-actions">
                    <a class="combo-more-btn combo-more-btn--primary js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                        <span>Đặt bàn</span>
                    </a>
                </div>
              </div>
          </div>
      </div>
  </div>
</section>
@if($combo->content)
<section class="foodcombo-detail">
  <div class="auto-container">
      <div class="foodcombo-detail__content" style="margin-top:0;">
        <h3>Chi tiết</h3>
        {!! $combo->content !!}
      </div>
  </div>
</section>
@endif
@endsection
