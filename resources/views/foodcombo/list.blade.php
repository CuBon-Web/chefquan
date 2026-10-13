@extends('layouts.main.master')
@section('title')
Taste Of Vietnam – Chef Quân Signature
@endsection
@section('description')
Tinh hoa ẩm thực Việt được thăng hoa qua bàn tay của Chef Quân – mang đến những món ăn độc đáo, trong không gian sang trọng và gần gũi.
@endsection
@section('image')
{{ !empty($banner[0]->image) ? url($banner[0]->image) : url($setting->logo) }}
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/taste-vn.css') }}">
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  function initSwiper(selector, options) {
    var el = document.querySelector(selector);
    if (!el || typeof Swiper === 'undefined') return null;
    return new Swiper(el, options);
  }

  var heroCurrent = document.querySelector('.tov-hero__counter-current');
  initSwiper('.tov-hero__slider', {
    slidesPerView: 1,
    loop: false,
    speed: 900,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    autoplay: { delay: 6000, disableOnInteraction: false },
    navigation: { nextEl: '.tov-hero__nav--next', prevEl: '.tov-hero__nav--prev' },
    on: {
      slideChange: function () {
        if (heroCurrent) heroCurrent.textContent = String(this.activeIndex + 1).padStart(2, '0');
      }
    }
  });

  initSwiper('.tov-offers__slider', {
    slidesPerView: 1.15,
    spaceBetween: 16,
    watchOverflow: true,
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 18 },
      992: { slidesPerView: 3, spaceBetween: 22 }
    }
  });

  initSwiper('.tov-combo__slider', {
    slidesPerView: 1.15,
    spaceBetween: 16,
    watchOverflow: true,
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 18 },
      992: { slidesPerView: 3, spaceBetween: 22 }
    }
  });

  initSwiper('.tov-reviews__slider', {
    slidesPerView: 1.05,
    spaceBetween: 16,
    watchOverflow: true,
    navigation: { nextEl: '.tov-reviews__nav--next', prevEl: '.tov-reviews__nav--prev' },
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 18 },
      992: { slidesPerView: 3, spaceBetween: 20 }
    }
  });

  var tabs = document.querySelectorAll('.tov-menu__tab');
  var panels = document.querySelectorAll('.tov-menu__panel');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = tab.getAttribute('data-target');
      tabs.forEach(function (t) {
        var active = t === tab;
        t.classList.toggle('is-active', active);
        t.setAttribute('aria-selected', active ? 'true' : 'false');
      });
      panels.forEach(function (p) {
        p.classList.toggle('is-active', p.id === target);
      });
    });
  });
});
</script>
@endsection
@section('content')
@php
    $heroDefaults = [
        'eyebrow' => 'Nhà hàng ẩm thực Việt',
        'title' => 'Không gian trải nghiệm ẩm thực Chef Quân Signature',
        'description' => 'Tinh hoa ẩm thực Việt được thăng hoa qua bàn tay của Chef Quân – mang đến những món ăn độc đáo, trong không gian sang trọng và gần gũi.',
        'button_text' => 'Đặt bàn ngay',
        'video_text' => 'Khám phá nhà hàng',
    ];
    $heroSlides = collect($tovBanners ?? [])->filter(function ($b) { return !empty($b->image); })->values();
    if ($heroSlides->isEmpty()) {
        $fallbackVideo = ($tasteVideos ?? collect())->first();
        $heroSlides = collect([(object) array_merge($heroDefaults, [
            'image' => 'frontend/images/tov-hero.jpg',
            'image_mobile' => '',
            'button_link' => '',
            'video_link' => $fallbackVideo->link ?? '',
        ])]);
    }
    $menuIcons = [
        '<path d="M8 26c1.5-6 5-10 12-11 7 1 10.5 5 12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M6 26h28M14 30h12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        '<path d="M10 14h20l-2 16H12L10 14z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M15 14c0-3 2-5 5-5s5 2 5 5" stroke="currentColor" stroke-width="1.6"/>',
        '<path d="M6 20c4-6 10-8 16-6 4 1 8 4 12 6-4 2-8 5-12 6-6 2-12 0-16-6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="27" cy="19" r="1.4" fill="currentColor"/>',
        '<path d="M8 18h24v4a12 12 0 01-24 0v-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M15 8c-1 2 1 3 0 5M20 7c-1 2 1 3 0 5M25 8c-1 2 1 3 0 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
        '<path d="M12 18h16l-3 14H15l-3-14z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 18c0-4 3-8 6-8s6 4 6 8" stroke="currentColor" stroke-width="1.6"/>',
        '<path d="M13 8h14l-2 24H15L13 8z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 15h12" stroke="currentColor" stroke-width="1.6"/>',
    ];
@endphp

<!-- Hero -->
<section class="tov-hero">
    <div class="tov-hero__slider swiper">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $index => $slide)
            @php
                $slideDesktop = url($slide->image);
                $slideMobile = !empty($slide->image_mobile) ? url($slide->image_mobile) : $slideDesktop;
                $slideTitle = trim((string) $slide->title) !== '' ? $slide->title : $heroDefaults['title'];
                $slideButtonText = trim((string) $slide->button_text) !== '' ? $slide->button_text : $heroDefaults['button_text'];
                $slideVideoText = trim((string) $slide->video_text) !== '' ? $slide->video_text : $heroDefaults['video_text'];
            @endphp
            <div class="swiper-slide">
                <div class="tov-hero__bg" style="--tov-bg-desktop: url('{{ $slideDesktop }}'); --tov-bg-mobile: url('{{ $slideMobile }}');"></div>
                <div class="tov-hero__overlay" aria-hidden="true"></div>

                <div class="auto-container tov-hero__container">
                    <div class="tov-hero__content">
                        @if(trim((string) $slide->eyebrow) !== '')
                        <p class="tov-eyebrow tov-eyebrow--light">{{ $slide->eyebrow }}</p>
                        @endif
                        @if($index === 0)
                        <h1 class="tov-hero__title">{{ $slideTitle }}</h1>
                        @else
                        <h2 class="tov-hero__title">{{ $slideTitle }}</h2>
                        @endif
                        @if(trim((string) $slide->description) !== '')
                        <p class="tov-hero__desc">{{ $slide->description }}</p>
                        @endif
                        <div class="tov-hero__actions">
                            @if(trim((string) $slide->button_link) !== '')
                            <a class="tov-btn tov-btn--primary" href="{{ $slide->button_link }}">
                                {{ $slideButtonText }} <span aria-hidden="true">→</span>
                            </a>
                            @else
                            <a class="tov-btn tov-btn--primary js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                                {{ $slideButtonText }} <span aria-hidden="true">→</span>
                            </a>
                            @endif
                            @if(trim((string) $slide->video_link) !== '')
                            <a class="tov-hero__play lightbox-image" href="{{ $slide->video_link }}" title="{{ $slideVideoText }}">
                                <span class="tov-play-icon" aria-hidden="true"></span>
                                <span class="tov-hero__play-text">{{ $slideVideoText }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($heroSlides->count() > 1)
    <div class="auto-container tov-hero__controls-wrap">
        <div class="tov-hero__controls">
            <span class="tov-hero__counter">
                <span class="tov-hero__counter-current">01</span>/<span>{{ str_pad($heroSlides->count(), 2, '0', STR_PAD_LEFT) }}</span>
            </span>
            <button type="button" class="tov-hero__nav tov-hero__nav--prev" aria-label="Slide trước"><span class="fal fa-angle-left"></span></button>
            <button type="button" class="tov-hero__nav tov-hero__nav--next" aria-label="Slide tiếp"><span class="fal fa-angle-right"></span></button>
        </div>
    </div>
    @endif
</section>

<!-- Ưu đãi -->
<section class="tov-offers">
    <div class="auto-container">
        <div class="tov-split">
            <div class="tov-split__intro">
                <p class="tov-eyebrow">Ưu đãi đặc biệt</p>
                <h2 class="tov-heading">Ưu đãi hấp dẫn</h2>
                <p class="tov-text">Trải nghiệm ẩm thực Việt theo cách đặc biệt hơn.</p>
                <a class="tov-btn tov-btn--outline" href="{{ route('khuyenMai') }}">Xem tất cả ưu đãi <span aria-hidden="true">→</span></a>
            </div>

            <div class="tov-split__body">
                <div class="tov-offers__slider swiper">
                    <div class="swiper-wrapper">
                        @forelse(($promotions ?? collect()) as $item)
                        @php
                            $offerDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $item->description)));
                            $offerUrl = !empty($item->slug) ? route('detailKhuyenmai', ['slug' => $item->slug]) : route('khuyenMai');
                        @endphp
                        <div class="swiper-slide">
                            <article class="tov-offer-card">
                                <a class="tov-offer-card__media" href="{{ $offerUrl }}" title="{{ $item->name }}">
                                    <img src="{{ !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg') }}" alt="{{ $item->name }}" width="480" height="300" loading="lazy" decoding="async">
                                    @if(!empty($item->badge))
                                    <span class="promo-badge promo-badge--sm">{{ $item->badge }}</span>
                                    @endif
                                </a>
                                <div class="tov-offer-card__body">
                                    <h3 class="tov-offer-card__title">
                                        <a href="{{ $offerUrl }}">{{ $item->name }}</a>
                                    </h3>
                                    @if($offerDesc !== '')
                                    <p class="tov-offer-card__desc">{{ \Illuminate\Support\Str::limit($offerDesc, 90) }}</p>
                                    @endif
                                    <a class="tov-link js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">Đặt bàn ngay <span aria-hidden="true">→</span></a>
                                </div>
                            </article>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <p class="tov-empty">Chưa có ưu đãi.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Combo -->
<section class="tov-combo" id="combo">
    <div class="auto-container">
        <div class="tov-split">
            <div class="tov-split__intro">
                <p class="tov-eyebrow tov-eyebrow--light">Combo đặc biệt</p>
                <h2 class="tov-heading tov-heading--light">Combo trải nghiệm Việt</h2>
                <p class="tov-text tov-text--light">Lựa chọn hoàn hảo cho gia đình, bạn bè và đối tác.</p>
                <a class="tov-btn tov-btn--outline-light" href="#combo-list">Khám phá combo <span aria-hidden="true">→</span></a>
            </div>

            <div class="tov-split__body" id="combo-list">
                <div class="tov-combo__slider swiper">
                    <div class="swiper-wrapper">
                        @forelse(($foodCombo ?? collect()) as $item)
                        @php
                            $comboImages = $item->images_array;
                            $comboCover = !empty($comboImages[0]) ? url($comboImages[0]) : asset('frontend/images/resource/maindish1.jpg');
                            $comboDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $item->description)));
                            $comboUrl = route('foodComboDetail', ['slug' => $item->slug]);
                        @endphp
                        <div class="swiper-slide">
                            <article class="tov-combo-card">
                                <a class="tov-combo-card__media" href="{{ $comboUrl }}" title="{{ $item->name }}">
                                    <img src="{{ $comboCover }}" alt="{{ $item->name }}" width="480" height="320" loading="lazy" decoding="async">
                                </a>
                                <div class="tov-combo-card__body">
                                    <h3 class="tov-combo-card__title"><a href="{{ $comboUrl }}">{{ $item->name }}</a></h3>
                                    @if($comboDesc !== '')
                                    <p class="tov-combo-card__desc">{{ \Illuminate\Support\Str::limit($comboDesc, 60) }}</p>
                                    @endif
                                    @if($item->display_price > 0)
                                    <div class="tov-combo-card__price">{{ number_format($item->display_price, 0, ',', '.') }}đ</div>
                                    @endif
                                </div>
                            </article>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <p class="tov-empty tov-empty--light">Chưa có combo.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Thực đơn -->
<section class="tov-menu">
    <div class="auto-container">
        <div class="tov-menu__layout">
            <div class="tov-menu__intro">
                <p class="tov-eyebrow">Thực đơn nhà hàng</p>
                <h2 class="tov-heading">Tinh hoa ẩm thực Việt</h2>
                <p class="tov-text">Mỗi món ăn là một câu chuyện, là sự kết hợp tinh tế giữa nguyên liệu bản địa, kỹ thuật hiện đại và tâm huyết của Chef Quân.</p>
                <p class="tov-menu__signature">Chef Quân</p>
            </div>

            @if(($menuCategories ?? collect())->isNotEmpty())
            <ul class="tov-menu__tabs" role="tablist">
                @foreach($menuCategories as $index => $cate)
                <li>
                    <button type="button"
                            class="tov-menu__tab {{ $index === 0 ? 'is-active' : '' }}"
                            role="tab"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            data-target="tov-menu-panel-{{ $cate->id }}">
                        <svg viewBox="0 0 40 40" fill="none" aria-hidden="true">{!! $menuIcons[$index % count($menuIcons)] !!}</svg>
                        <span>{{ languageName($cate->name) }}</span>
                    </button>
                </li>
                @endforeach
            </ul>

            <div class="tov-menu__panels">
                @foreach($menuCategories as $index => $cate)
                <div class="tov-menu__panel {{ $index === 0 ? 'is-active' : '' }}" id="tov-menu-panel-{{ $cate->id }}" role="tabpanel">
                    <div class="tov-menu__panel-head">
                        <h3>{{ languageName($cate->name) }}</h3>
                        <a class="tov-link" href="{{ route('allListProCate', ['danhmuc' => $cate->slug]) }}">Xem tất cả <span aria-hidden="true">→</span></a>
                    </div>
                    <div class="tov-menu__grid">
                        @foreach($cate->menuProducts as $pro)
                        @php
                            $proImages = json_decode($pro->images, true) ?? [];
                            $proThumb = !empty($proImages[0]) ? url($proImages[0]) : asset('frontend/images/resource/maindish1.jpg');
                            $proName = languageName($pro->name);
                            $proUrl = route('detailProduct', [
                                'cate' => $pro->cate_slug,
                                'type' => $pro->type_slug ?: 'loai',
                                'id' => $pro->slug,
                            ]);
                            $proPrice = (float) $pro->discount > 0 ? (float) $pro->discount : (float) $pro->price;
                            $proDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) languageName($pro->description))));
                        @endphp
                        <article class="tov-dish-card">
                            <a class="tov-dish-card__media" href="{{ $proUrl }}" title="{{ $proName }}">
                                <img src="{{ $proThumb }}" alt="{{ $proName }}" width="400" height="300" loading="lazy" decoding="async">
                            </a>
                            <div class="tov-dish-card__body">
                                <h4 class="tov-dish-card__title"><a href="{{ $proUrl }}">{{ $proName }}</a></h4>
                                @if($proDesc !== '')
                                <p class="tov-dish-card__desc">{{ \Illuminate\Support\Str::limit($proDesc, 50) }}</p>
                                @endif
                                <div class="tov-dish-card__foot">
                                    <span class="tov-dish-card__price">{{ $proPrice > 0 ? number_format($proPrice, 0, ',', '.') . 'đ' : 'Liên hệ' }}</span>
                                    <a class="tov-dish-card__more" href="{{ $proUrl }}" aria-label="Xem {{ $proName }}">+</a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="tov-empty">Thực đơn đang được cập nhật.</p>
            @endif
        </div>
    </div>
</section>

<!-- Video -->
<section class="tov-video">
    <div class="auto-container">
        <div class="tov-video__layout">
            <div class="tov-video__intro">
                <p class="tov-eyebrow tov-eyebrow--light">Video Signature Chef Quân</p>
                <h2 class="tov-heading tov-heading--light">Hành trình sáng tạo những món ăn Việt</h2>
                <p class="tov-text tov-text--light">Cùng Chef Quân khám phá câu chuyện đằng sau mỗi món ăn, từ nguyên liệu, kỹ thuật chế biến đến tinh thần ẩm thực Việt.</p>
                <a class="tov-btn tov-btn--outline-light" href="{{ route('videoReview') }}">Xem toàn bộ video <span aria-hidden="true">→</span></a>
            </div>

            @php
                $videos = $tasteVideos ?? collect();
                $featuredVideo = $videos->first();
                $sideVideos = $videos->slice(1, 4);
            @endphp
            @if($featuredVideo)
            <div class="tov-video__featured">
                <a class="tov-video-tile tov-video-tile--lg lightbox-image" href="{{ $featuredVideo->link ?: 'javascript:;' }}" title="{{ $featuredVideo->name }}">
                    <img src="{{ !empty($featuredVideo->image) ? url($featuredVideo->image) : asset('frontend/images/resource/maindish1.jpg') }}" alt="{{ $featuredVideo->name }}" width="800" height="500" loading="lazy" decoding="async">
                    <span class="tov-play-icon" aria-hidden="true"></span>
                    <span class="tov-video-tile__caption">{{ $featuredVideo->name }}</span>
                </a>
            </div>
            @if($sideVideos->isNotEmpty())
            <div class="tov-video__grid">
                @foreach($sideVideos as $item)
                <a class="tov-video-tile lightbox-image" href="{{ $item->link ?: 'javascript:;' }}" title="{{ $item->name }}">
                    <img src="{{ !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg') }}" alt="{{ $item->name }}" width="400" height="260" loading="lazy" decoding="async">
                    <span class="tov-play-icon tov-play-icon--sm" aria-hidden="true"></span>
                </a>
                @endforeach
            </div>
            @endif
            @else
            <p class="tov-empty tov-empty--light">Chưa có video.</p>
            @endif
        </div>
    </div>
</section>

<!-- Feedback -->
<section class="tov-reviews">
    <div class="auto-container">
        <div class="tov-split">
            <div class="tov-split__intro">
                <p class="tov-eyebrow">Khách hàng nói gì về chúng tôi</p>
                <h2 class="tov-heading">Những trải nghiệm đáng nhớ</h2>
                <p class="tov-text">Sự hài lòng của thực khách là động lực để chúng tôi luôn nỗ lực mang đến những trải nghiệm tốt nhất.</p>
                <a class="tov-btn tov-btn--outline-accent js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">Đặt bàn trải nghiệm <span aria-hidden="true">→</span></a>
            </div>

            <div class="tov-split__body tov-reviews__body">
                <div class="tov-reviews__slider swiper">
                    <div class="swiper-wrapper">
                        @forelse(($reviews ?? collect()) as $item)
                        <div class="swiper-slide">
                            <article class="tov-review-card">
                                <div class="tov-review-card__head">
                                    <img class="tov-review-card__avatar" src="{{ !empty($item->avatar) ? url($item->avatar) : asset('frontend/images/avatar-default.png') }}" alt="{{ languageName($item->name) }}" width="48" height="48" loading="lazy" decoding="async">
                                    <div>
                                        <strong class="tov-review-card__name">{{ languageName($item->name) }}</strong>
                                        <span class="tov-review-card__role">{{ languageName($item->position) ?: 'Khách hàng' }}</span>
                                    </div>
                                </div>
                                <p class="tov-review-card__text">“{{ \Illuminate\Support\Str::limit(trim(strip_tags((string) languageName($item->content))), 160) }}”</p>
                                <div class="tov-review-card__stars" aria-label="5 sao">★★★★★</div>
                            </article>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <p class="tov-empty">Chưa có đánh giá.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @if(($reviews ?? collect())->count() > 3)
                <div class="tov-reviews__navs">
                    <button type="button" class="tov-reviews__nav tov-reviews__nav--prev" aria-label="Đánh giá trước"><span class="fal fa-angle-left"></span></button>
                    <button type="button" class="tov-reviews__nav tov-reviews__nav--next" aria-label="Đánh giá tiếp"><span class="fal fa-angle-right"></span></button>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
