@extends('layouts.main.master')
@section('title')
    {{ $setting->company }}
@endsection
@section('description')
    {{ $setting->webname }}
@endsection
@section('image')
    @php
        $ogBanner = $banner->first();
        $ogImage = $ogBanner && $ogBanner->image ? url($ogBanner->image) : url($setting->logo ?? '');
    @endphp
    {{ $ogImage }}
@endsection
@section('css')
@php
    $firstBanner = $banner->first();
    $lcpPc = $firstBanner && !empty($firstBanner->image) ? url($firstBanner->image) : null;
    $lcpMobile = $firstBanner && !empty($firstBanner->image_mobile)
        ? url($firstBanner->image_mobile)
        : $lcpPc;
@endphp
@if($lcpPc)
<link rel="preload" as="image" href="{{ $lcpPc }}" media="(min-width: 768px)" fetchpriority="high">
@endif
@if($lcpMobile)
<link rel="preload" as="image" href="{{ $lcpMobile }}" media="(max-width: 767px)" fetchpriority="high">
@endif
<link rel="stylesheet" href="{{ url('frontend/css/home.css') }}" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="{{ url('frontend/css/home.css') }}"></noscript>
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.why-desc-wrap').forEach(function (wrap) {
    var text = wrap.querySelector('.why-desc');
    var toggle = wrap.querySelector('.why-desc-toggle');
    if (!text || !toggle) return;

    if (text.scrollHeight <= text.clientHeight + 2) {
      toggle.style.display = 'none';
      return;
    }

    toggle.addEventListener('click', function () {
      var expanded = text.classList.toggle('is-expanded');
      toggle.textContent = expanded ? 'Thu gọn' : 'Xem thêm';
    });
  });
});
</script>
@endsection
@section('content')
<h1 class="d-none">{{$setting->company}}</h1>
 

<!-- Banner Section -->
<section class="banner-section">

   <!-- social link -->
   <div class="banner-social-list">
     <span class="line"></span>

     <ul class="custom-ul">
       <li> <a href="#"> FB </a> </li>
       <li><a href="#"> IN </a> </li>
       <li><a href="#"> YT </a> </li>
     </ul>

     <span class="line"></span>
   </div>

   <!-- social link -->
   <div class="banner-call">
     <span class="line"></span>

     <ul class="call-ul">
       <li><a href="tel:{{$setting->phone1}}">Đặt bàn : {{$setting->phone1}}</a></li>
     </ul>

     <span class="line"></span>
   </div>

   <div class="banner-container">
       <div class="banner-slider">
           <div class="swiper-wrapper">
              
               @foreach ($banner as $index => $item)
               @php
                   $bannerPc = !empty($item->image) ? url($item->image) : asset('images/banner2.jpg');
                   $bannerMobile = !empty($item->image_mobile)
                       ? url($item->image_mobile)
                       : (!empty($item->image) ? url($item->image) : asset('images/mobilebanner2.jpg'));
                   $isFirstBanner = $index === 0;
               @endphp
               <div class="swiper-slide slide-item">
                   @if($isFirstBanner)
                   <div class="image-layer image-layer-pc" style="background-image: url({{ $bannerPc }});"></div>
                   <div class="image-layer image-layer-mobile" style="background-image: url({{ $bannerMobile }});"></div>
                   @else
                   <div class="image-layer image-layer-pc" data-bg="{{ $bannerPc }}"></div>
                   <div class="image-layer image-layer-mobile" data-bg="{{ $bannerMobile }}"></div>
                   @endif
                   <div class="auto-container">
                       <div class="row banner-hero-row align-items-center">
                           <div class="content-box">
                               <div class="banner-pc">
                                   <div class="content">
                                       <div class="clearfix">
                                           <div class="inner">
                                               <div class="subtitle"><img class="no-lazy" width="200" height="60" src="{{ url($setting->logo) }}" alt="{{ $setting->company }}" decoding="async" fetchpriority="high"></div>
                                               <h2 cl>{{ $item->title }}</h2>
                                               <div class="text">{!! $item->description !!}</div>
                                               <div class="banner-btns">
                                                   <a href="{{ $item->link }}" class="theme-btn btn-style-one clearfix">
                                                       <span class="btn-wrap">
                                                           <span class="text-one">Xem Thêm</span>
                                                           <span class="text-two">Xem Thêm</span>
                                                       </span>
                                                   </a>
                                                   <a href="{{ route('aboutUs') }}" class="theme-btn btn-style-two clearfix">
                                                       <span class="btn-wrap">
                                                           <span class="text-one">Về Chúng tôi</span>
                                                           <span class="text-two">Về Chúng tôi</span>
                                                       </span>
                                                   </a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="banner-mobile">
                                   <div class="content">
                                       <div class="clearfix">
                                           <div class="inner">
                                               <div class="subtitle"><img class="no-lazy" width="200" height="60" src="{{ url($setting->logo) }}" alt="{{ $setting->company }}" decoding="async"></div>
                                               <h2>{{ $item->title }}</h2>
                                               <div class="text">{!! $item->description !!}</div>
                                               <div class="banner-btns">
                                                   <a href="{{ $item->link }}" class="theme-btn btn-style-one clearfix">
                                                       <span class="btn-wrap">
                                                           <span class="text-one">Xem Thêm</span>
                                                           <span class="text-two">Xem Thêm</span>
                                                       </span>
                                                   </a>
                                                   <a href="{{ route('aboutUs') }}" class="theme-btn btn-style-two clearfix">
                                                       <span class="btn-wrap">
                                                           <span class="text-one">Về Chúng tôi</span>
                                                           <span class="text-two">Về Chúng tôi</span>
                                                       </span>
                                                   </a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               @endforeach
           </div>
           <div class="swiper-button-prev"><span class="fal fa-angle-left"></span></div>
           <div class="swiper-button-next"><span class="fal fa-angle-right"></span></div>
       </div>
   </div>


</section>
<!--End Banner Section -->

<!--Category Section-->
<section class="story-section section-kt">
   <div class="auto-container">

       @php
           $storyImages = json_decode($gioithieu->image ?? '[]', true);
           $storyCover = is_array($storyImages) && !empty($storyImages[0]) ? $storyImages[0] : ($setting->logo ?? '');
       @endphp

       <div class="story-showcase">
           

           <div class="story-showcase__visual wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="160ms">
               <div class="story-frame">
                   <span class="story-frame__glow" aria-hidden="true"></span>
                   <div class="story-frame__media">
                       <img src="{{ url($storyCover) }}" alt="{{ $setting->company }}" width="640" height="800" loading="lazy" decoding="async">
                   </div>
               </div>
           </div>
           <div class="story-showcase__content wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="80ms">
                <h2 class="story-chef__title">Chef Quân</h2>
                <p class="story-chef__tagline">Người kể chuyện ẩm thực Việt</p>
                {!! $gioithieu->description !!}

                <ul class="story-chef__stats">
                    <li class="story-chef__stat">
                        <span class="story-chef__stat-icon" aria-hidden="true">
                            <img src="/frontend/images/icon1.png" alt="">
                        </span>
                        <strong class="story-chef__stat-title">20+ năm</strong>
                        <span class="story-chef__stat-text">Kinh nghiệm trong nghề</span>
                    </li>
                    <li class="story-chef__stat">
                        <span class="story-chef__stat-icon" aria-hidden="true">
                            <img src="/frontend/images/icon2.png" alt="">
                        </span>
                        <strong class="story-chef__stat-title">3 lần liên tiếp</strong>
                        <span class="story-chef__stat-text">Đầu bếp tiêu biểu Quốc gia</span>
                    </li>
                    <li class="story-chef__stat">
                        <span class="story-chef__stat-icon" aria-hidden="true">
                            <img src="/frontend/images/icon3.png" alt="">
                        </span>
                        <strong class="story-chef__stat-title">Chủ tịch</strong>
                        <span class="story-chef__stat-text">Hội Đầu bếp Việt Nam</span>
                    </li>
                    <li class="story-chef__stat">
                        <span class="story-chef__stat-icon" aria-hidden="true">
                            <img src="/frontend/images/icon4.png" alt="">
                        </span>
                        <strong class="story-chef__stat-title">Thành viên danh dự</strong>
                        <span class="story-chef__stat-text">Worldchefs (Thế giới)</span>
                    </li>
                </ul>

                <a class="story-chef__btn" href="{{ route('aboutUs') }}">Khám phá Chef Quân</a>
           </div>
       </div>
   </div>
</section>

<section class="menu-card-style-section taste-vn-section section-kt">
   <div class="auto-container">
       <div class="taste-vn__header title-box centered mb-5 wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <h2 class="taste-vn__title">Taste Of Vietnam</h2>
           <p class="taste-vn__subtitle">Không chỉ là một nhà hàng. Đó là một hành trình qua hương vị Việt.</p>
       </div>

       <div class="taste-vn__grid">
       @forelse(($foodCombos ?? collect()) as $index => $combo)
       @php
           $comboImages = $combo->images_array;
           $cover = !empty($comboImages[0]) ? $comboImages[0] : asset('frontend/images/resource/maindish1.jpg');
           $comboName = trim((string) $combo->name);
           $tasteLabel = 'Hương vị';
           $tasteName = $comboName;
           if (preg_match('/^hương\s*vị\s*[:\-\/]?\s*(.+)$/iu', $comboName, $m)) {
               $tasteName = trim($m[1]);
           }
           $tasteDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($combo->description ?? ''))));
           if ($tasteDesc === '') {
               $tasteDesc = 'Khám phá hành trình ẩm thực cùng Chef Quân.';
           }
           $iconType = $index % 4;
       @endphp
           <article class="taste-vn-card wow fadeInUp" data-wow-duration="900ms" data-wow-delay="{{ ($index % 4) * 80 }}ms">
               <a class="taste-vn-card__media" href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}" title="{{ $comboName }}">
                   <img src="{{ url($cover) }}" alt="{{ $comboName }}" width="640" height="420" loading="lazy" decoding="async">
               </a>
               <div class="taste-vn-card__body">
                   <div class="taste-vn-card__top">
                       <span class="taste-vn-card__icon" aria-hidden="true">
                           @if($iconType === 0)
                           <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 28c2-6 4.5-10 8-12 3.5 2 6 6 8 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M10 28h20M14 22c1.5 1.5 3.5 2.2 6 2.2s4.5-.7 6-2.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="20" cy="12" r="2.2" stroke="currentColor" stroke-width="1.6"/></svg>
                           @elseif($iconType === 1)
                           <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 22c2.5-5 6-8 12-9 6 1 9.5 4 12 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M11 22h18M14 26h12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16 14c1.2-2 2.8-3 4-3s2.8 1 4 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                           @elseif($iconType === 2)
                           <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 26c2-7 5.5-12 10-14 4.5 2 8 7 10 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 26h16M15 18c1.4 1.5 3 2.2 5 2.2s3.6-.7 5-2.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="20" cy="10" r="1.8" fill="currentColor"/></svg>
                           @else
                           <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="18" r="7" stroke="currentColor" stroke-width="1.6"/><path d="M12 28c2.2-3 5-4.5 8-4.5s5.8 1.5 8 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M20 11v14M15 18h10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                           @endif
                       </span>
                       <div class="taste-vn-card__heading">
                           {{-- <span class="taste-vn-card__eyebrow">{{ $tasteLabel }}</span> --}}
                           <h3 class="taste-vn-card__name">
                               <a href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}">{{ $tasteName }}</a>
                           </h3>
                       </div>
                   </div>
                   <p class="taste-vn-card__desc">{{ \Illuminate\Support\Str::limit($tasteDesc, 90) }}</p>
                   <a class="taste-vn-card__link" href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}">
                       Khám phá <span aria-hidden="true">→</span>
                   </a>
               </div>
           </article>
       @empty
           <div class="taste-vn__empty">
               <p>Chưa có combo món ăn để hiển thị.</p>
           </div>
       @endforelse
       </div>
   </div>
</section>
<!-- Signature Of Chef Quân — Món ăn -->
<section class="signature-section section-kt">
   <div class="auto-container">
       <div class="signature__header title-box centered wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <h2 class="signature__title">Signature Of Chef Quân</h2>
           <p class="signature__subtitle">Những món ăn kể câu chuyện riêng</p>
       </div>

       <div class="signature-slider-wrap wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="80ms">
           <div class="signature-slider swiper">
               <div class="swiper-wrapper">
                   @forelse(($signatureDishes ?? collect()) as $index => $item)
                   @php
                       $dishUrl = route('detailBlog', ['slug' => $item->slug]);
                       $dishTitle = languageName($item->title);
                       $dishDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) languageName($item->description ?? ''))));
                       if ($dishDesc === '') {
                           $dishDesc = 'Khám phá câu chuyện món ăn cùng Chef Quân.';
                       }
                       $dishCover = !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg');
                   @endphp
                   <div class="swiper-slide">
                       <article class="signature-card">
                           <a class="signature-card__media" href="{{ $dishUrl }}" title="{{ $dishTitle }}">
                               <img src="{{ $dishCover }}" alt="{{ $dishTitle }}" width="480" height="320" loading="lazy" decoding="async">
                           </a>
                           <h3 class="signature-card__title">
                               <a href="{{ $dishUrl }}" title="{{ $dishTitle }}">{{ $dishTitle }}</a>
                           </h3>
                           <p class="signature-card__desc">{{ \Illuminate\Support\Str::limit($dishDesc, 72) }}</p>
                       </article>
                   </div>
                   @empty
                   <div class="swiper-slide">
                       <article class="signature-card signature-card--empty">
                           <p class="signature-card__desc">Chưa có bài viết trong danh mục Món ăn.</p>
                       </article>
                   </div>
                   @endforelse
               </div>
           </div>
       </div>

       <div class="signature__actions wow fadeInUp" data-wow-duration="900ms" data-wow-delay="120ms">
           <a class="signature__btn" href="{{ route('listCateBlog', ['slug' => $dishCateSlug ?? 'mon-an']) }}">Xem thêm món ăn</a>
       </div>
   </div>
</section>

<!-- Story Video Section -->
<section class="story-video-section section-kt">
   <div class="auto-container">
       <div class="story-video__layout">
           <div class="story-video__intro wow fadeInLeft" data-wow-duration="900ms" data-wow-delay="0ms">
               <h2 class="story-video__title">Kể chuyện Việt qua một món ăn</h2>
               <p class="story-video__desc">Những câu chuyện phía sau nguyên liệu, bí quyết chế biến và văn hóa Việt Nam.</p>
               <a class="story-video__btn" href="{{ route('videoReview') }}">Xem tất cả video</a>
           </div>

           <div class="story-video__slider-wrap wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="80ms">
               <div class="story-video-slider swiper">
                   <div class="swiper-wrapper">
                       @forelse(($homeVideos ?? collect()) as $item)
                       @php
                           $videoName = trim((string) ($item->name ?? ''));
                           $videoLink = trim((string) ($item->link ?? ''));
                           $videoCover = !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg');
                       @endphp
                       <div class="swiper-slide">
                           <article class="story-video-card">
                               <a class="story-video-card__media lightbox-image"
                                  href="{{ $videoLink !== '' ? $videoLink : 'javascript:;' }}"
                                  title="{{ $videoName }}">
                                   <img src="{{ $videoCover }}" alt="{{ $videoName }}" width="480" height="320" loading="lazy" decoding="async">
                                   <span class="story-video-card__play" aria-hidden="true"></span>
                               </a>
                               <h3 class="story-video-card__title">{{ $videoName }}</h3>
                           </article>
                       </div>
                       @empty
                       <div class="swiper-slide">
                           <article class="story-video-card story-video-card--empty">
                               <p class="story-video-card__title">Chưa có video để hiển thị.</p>
                           </article>
                       </div>
                       @endforelse
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>

<!-- VICA Section -->
<section class="vica-section section-kt">
   <div class="auto-container">
       <div class="vica__layout wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="vica__brand">
               <img class="vica__brand-mark" src="{{ asset('frontend/images/logovica.png') }}" alt="VICA" width="120" height="120" loading="lazy" decoding="async">
           </div>

           <div class="vica__divider" aria-hidden="true"></div>

           <div class="vica__main">
               <div class="vica__photo">
                   <img src="{{ asset('frontend/images/image1.jpg') }}" alt="Chef Quân – Hội Đầu bếp Việt Nam" width="420" height="280" loading="lazy" decoding="async">
               </div>
               <div class="vica__copy">
                   <h2 class="vica__title">Lan tỏa giá trị nghề bếp</h2>
                   <p class="vica__desc">Chef Quân – Chủ tịch Hội Đầu bếp Việt Nam (VICA) không chỉ nấu ăn, không chỉ giữ nghề, mà còn truyền nghề và xây dựng thế hệ đầu bếp Việt Nam tiếp theo.</p>
                   <a class="vica__btn" href="#">Khám phá VICA</a>
               </div>
           </div>

           <div class="vica__divider" aria-hidden="true"></div>

           <ul class="vica__features">
               <li class="vica__feature">
                   <span class="vica__feature-icon" aria-hidden="true">
                     <img src="/frontend/images/icon5.png" alt="">
                   </span>
                   <span class="vica__feature-text">
                       <strong>Đào tạo</strong>
                       <span>Đầu bếp chuyên nghiệp</span>
                   </span>
               </li>
               <li class="vica__feature">
                   <span class="vica__feature-icon" aria-hidden="true">
                    <img src="/frontend/images/icon6.png" alt="">
                   </span>
                   <span class="vica__feature-text">
                       <strong>Hoạt động</strong>
                       <span>Cộng đồng &amp; sự kiện</span>
                   </span>
               </li>
               <li class="vica__feature">
                   <span class="vica__feature-icon" aria-hidden="true">
                    <img src="/frontend/images/icon7.png" alt="">
                   </span>
                   <span class="vica__feature-text">
                       <strong>Kết nối</strong>
                       <span>Ẩm thực Việt Nam &amp; thế giới</span>
                   </span>
               </li>
           </ul>
       </div>
   </div>
</section>

<!-- Experience — Taste Of Vietnam -->
<section class="experience-section section-kt">
   <div class="auto-container">
       <div class="experience__layout">
           <div class="experience__intro wow fadeInLeft" data-wow-duration="900ms" data-wow-delay="0ms">
               <p class="experience__eyebrow">Trải nghiệm</p>
               <h2 class="experience__title">Taste Of Vietnam</h2>
               <p class="experience__desc">Một không gian Hà Nội xưa trong căn biệt thự Pháp cổ, nơi mỗi món ăn là một câu chuyện.</p>
               <a class="experience__btn js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">Đặt bàn ngay</a>
           </div>

           <div class="experience__slider-wrap wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="80ms">
               <div class="experience-slider swiper">
                   <div class="swiper-wrapper">
                       @forelse(($gallery ?? collect()) as $item)
                       @php
                           $expImg = $item->after ?: $item->before;
                           $expTitle = trim((string) ($item->title ?? ''));
                       @endphp
                       @if(!empty($expImg))
                       <div class="swiper-slide">
                           <figure class="experience-card">
                               <img src="{{ url($expImg) }}" alt="{{ $expTitle !== '' ? $expTitle : 'Taste Of Vietnam' }}" width="360" height="480" loading="lazy" decoding="async">
                           </figure>
                       </div>
                       @endif
                       @empty
                       <div class="swiper-slide">
                           <figure class="experience-card experience-card--empty">
                               <span>Chưa có ảnh album.</span>
                           </figure>
                       </div>
                       @endforelse
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>

<!--Reservation Section-->
<section class="fluid-section reserve-section splitscreen" id="reservation">
   <div class="outer-container">
       <div class="outer-box">
           <div class="row clearfix">
               <div class="reserv-col col-lg-6 col-md-12 col-sm-12">
                   <div class="inner wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="60ms">
                       <div class="title-box centered">
                           <div class="subtitle"><span>Đặt bàn online</span></div>
                           <h2>Đặt bàn ngay</h2>
                           <div class="request-info">Đặt bàn ngay <a href="tel:{{ $setting->phone1 }}">{{ $setting->phone1 }}</a> hoặc điền vào form đặt bàn</div>
                       </div>
                       <div class="default-form reservation-form">
                           @if(session('success') && !session('open_book_now_modal'))
                           <div class="alert alert-success" style="margin-bottom:20px;">{{ session('success') }}</div>
                           @endif
                           @if(session('error') && !session('open_book_now_modal'))
                           <div class="alert alert-danger" style="margin-bottom:20px;">{{ session('error') }}</div>
                           @endif
                           <form method="post" action="{{ route('postcontact') }}">
                            @csrf
                            <input type="hidden" name="type" value="booking">
                            <input type="hidden" name="redirect_url" value="{{ url()->current() }}#reservation">
                               <div class="row clearfix">
                                   <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                       <div class="field-inner">
                                           <input type="text" name="name" value="{{ old('name') }}" placeholder="Họ và tên *" required autocomplete="name">
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                       <div class="field-inner">
                                           <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại *" required autocomplete="tel">
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                       <div class="field-inner">
                                           <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email">
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                       <div class="field-inner">
                                           <span class="alt-icon far fa-user"></span>
                                           <select class="l-icon" name="guests" required>
                                               <option value="">Số khách *</option>
                                               @for ($i = 1; $i <= 20; $i++)
                                               <option value="{{ $i }}" {{ (string) old('guests') === (string) $i ? 'selected' : '' }}>{{ $i }} khách</option>
                                               @endfor
                                           </select>
                                           <span class="arrow-icon far fa-angle-down"></span>
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                       <div class="field-inner">
                                           <span class="alt-icon far fa-calendar"></span>
                                           <input class="l-icon" type="date" name="booking_date" value="{{ old('booking_date') }}" min="{{ now()->format('Y-m-d') }}" required>
                                           <span class="arrow-icon far fa-angle-down"></span>
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                       <div class="field-inner">
                                           <span class="alt-icon far fa-clock"></span>
                                           <select class="l-icon" name="booking_time" required>
                                                <option value="">Chọn giờ *</option>
                                               @foreach (['10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00'] as $time)
                                               <option value="{{ $time }}" {{ old('booking_time') === $time ? 'selected' : '' }}>{{ $time }}</option>
                                               @endforeach
                                           </select>
                                           <span class="arrow-icon far fa-angle-down"></span>
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                       <div class="field-inner">
                                           <textarea name="mess" placeholder="Ghi chú (sinh nhật, bàn gần cửa sổ...)">{{ old('mess') }}</textarea>
                                       </div>
                                   </div>
                                   <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                       <div class="field-inner">
                                           <button type="submit" class="theme-btn btn-style-one clearfix">
                                               <span class="btn-wrap">
                                                   <span class="text-one">Đặt bàn ngay</span>
                                                   <span class="text-two">Đặt bàn ngay</span>
                                               </span>
                                           </button>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               <div class="graphic-col col-lg-6 col-md-12 col-sm-12">
                   <div class="inner wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="140ms">
                       <div class="graphic-layer" data-bg="https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-2-Standard-Hero/images/background/reservation-bg.jpg"></div>
                       <div class="image"><img src="https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-2-Standard-Hero/images/background/reservation-bg.jpg" alt="Đặt bàn Chef Quân" width="900" height="700" loading="lazy" decoding="async"></div>

                   </div>
               </div>
           </div>

       </div>
   </div>
</section>

@endsection
