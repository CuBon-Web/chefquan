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

   <a href="#bookNowModal" class="explore-menu-btn js-open-booking" data-open-booking data-toggle="modal" data-target="#bookNowModal" aria-label="Đặt bàn ngay">
       <span class="icon"> <img src="{{ url('frontend/images/menu-badge-arrow.png') }}" alt="" width="80" height="80" loading="lazy" decoding="async"> </span>
   </a>

   <!-- Curve at bottom -->
   <!-- Default (desktop) curve -->
   <svg class="bottom-curve curve-desktop" viewBox="0 0 1440 65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
     <path fill="#f9f0df" d="M0,65 C360,0 1080,0 1440,65 L1440,65 L0,65 Z" />
   </svg>

   <!-- Less curved version for tablets/mobile -->
 <svg class="bottom-curve curve-mobile" viewBox="0 0 1440 65" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
   <path fill="#f9f0df" d="M0,65 C480,20 960,20 1440,65 L1440,65 L0,65 Z" />
 </svg>



</section>
<!--End Banner Section -->

<!--Category Section-->
<section class="story-section section-kt">
   <div class="auto-container">
       <div class="title-box centered story-intro wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="subtitle story-intro__logo">
            <img class="no-lazy" width="200" height="60" src="{{ url($setting->logo) }}" alt="{{ $setting->company }}" decoding="async">
           </div>
           <div class="story-intro__ornament" aria-hidden="true"></div>
           <h2 class="red-color story-intro__headline">Gìn giữ tinh hoa, lan tỏa hương vị Việt.</h2>
       </div>

       @php
           $storyImages = json_decode($gioithieu->image ?? '[]', true);
           $storyCover = is_array($storyImages) && !empty($storyImages[0]) ? $storyImages[0] : ($setting->logo ?? '');
       @endphp

       <div class="story-showcase">
           <div class="story-showcase__content wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="80ms">
               <div class="story-showcase__eyebrow">Câu chuyện thương hiệu</div>
               <div class="story-showcase__copy">
                   {!! $gioithieu->description !!}
               </div>

               <div class="story-showcase__actions">
                   <a class="story-cta story-cta--primary js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                       <span class="story-cta__icon" aria-hidden="true">
                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                               <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                           </svg>
                       </span>
                       <span class="story-cta__text">
                           <span class="story-cta__label">Đặt bàn ngay</span>
                           <span class="story-cta__value">{{ $setting->phone1 }}</span>
                       </span>
                   </a>
                   <a class="story-cta story-cta--ghost" href="{{ route('aboutUs') }}">
                       <span>Xem thêm</span>
                       <span class="story-cta__arrow" aria-hidden="true">→</span>
                   </a>
               </div>
           </div>

           <div class="story-showcase__visual wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="160ms">
               <div class="story-frame">
                   <span class="story-frame__glow" aria-hidden="true"></span>
                   <div class="story-frame__media">
                       <img src="{{ url($storyCover) }}" alt="{{ $setting->company }}" width="640" height="800" loading="lazy" decoding="async">
                   </div>
                   <div class="story-frame__badge">
                       <span class="story-frame__badge-label">Chef Quân</span>
                       <span class="story-frame__badge-text">Taste of Vietnam</span>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>

<section class="menu-card-style-section section-kt">
   <div class="auto-container">
       <div class="title-box centered mb-5 wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="title-badge"> <img src="{{ url($setting->logo) }}" alt="{{ $setting->company }}" width="120" height="40" loading="lazy" decoding="async"> </div>
           <h2>Taste Of Vietnam</h2>
       </div>
       <div class="menu-card-main">
       <!-- menu card corner images -->
           <img class="menu-card-corner top-left" src="{{ url('frontend/images/menucard-corner-left-top.png') }}" alt="" width="80" height="80" loading="lazy" decoding="async">
           <img class="menu-card-corner top-right" src="{{ url('frontend/images/menucard-corner-right-top.png') }}" alt="" width="80" height="80" loading="lazy" decoding="async">
           <img class="menu-card-corner bottom-left" src="{{ url('frontend/images/menucard-corner-left-bottom.png') }}" alt="" width="80" height="80" loading="lazy" decoding="async">
           <img class="menu-card-corner bottom-right" src="{{ url('frontend/images/menucard-corner-right-bottom.png') }}" alt="" width="80" height="80" loading="lazy" decoding="async">
       @forelse(($foodCombos ?? collect()) as $index => $combo)
       @php
           $comboImages = $combo->images_array;
           $cover = !empty($comboImages[0]) ? $comboImages[0] : asset('frontend/images/resource/maindish1.jpg');
           $hasSale = $combo->sale_price !== null && (float) $combo->sale_price > 0 && (float) $combo->sale_price < (float) $combo->price;
           $imageWow = $index % 2 === 0 ? 'fadeInLeft' : 'fadeInRight';
           $contentWow = $index % 2 === 0 ? 'fadeInRight' : 'fadeInLeft';
       @endphp
       <div class="menu-card-style {{ $index % 2 === 0 ? 'alternate' : '' }}">
           <div class="row clearfix">
               <div class="image-col col-lg-6 col-md-12 col-sm-12 wow {{ $imageWow }}" data-wow-duration="1000ms" data-wow-delay="60ms">
                   <div class="inner">
                       <div class="image">
                           <a href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}">
                               <img src="{{ url($cover) }}" alt="{{ $combo->name }}" width="800" height="600" loading="lazy" decoding="async">
                           </a>
                       </div>
                   </div>
               </div>

               <div class="menu-col col-lg-6 col-md-12 col-sm-12 wow {{ $contentWow }}" data-wow-duration="1000ms" data-wow-delay="140ms">
                   <div class="inner">
                       <div class="title-box-2">
                        <div class="combo-heading {{ $hasSale ? 'is-sale' : '' }}">
                           @if($hasSale)
                             <div class="combo-heading__note">Ưu đãi đặc biệt</div>
                           @endif
                           <h3 class="combo-heading__title">
                               <a href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}">{{ $combo->name }}</a>
                           </h3>
                           <span class="combo-heading__leader" aria-hidden="true"></span>
                           <div class="combo-heading__price">
                                @if($hasSale)
                                    <strong class="combo-heading__current">{{ number_format((float) $combo->sale_price) }}₫</strong>
                                    <del class="combo-heading__old">{{ number_format((float) $combo->price) }}₫</del>
                                   
                                @else
                                    <strong class="combo-heading__current">{{ number_format((float) $combo->price) }}₫</strong>
                                @endif
                            </div>
                        </div>
                           @if($combo->description)
                           <div class="description">
                            {!! $combo->description !!}
                           </div>
                           @endif
                           <div class="menu">
                            {!! $combo->menu !!}
                           </div>
                           <div class="combo-actions">
                               <a class="combo-more-btn combo-more-btn--primary js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                                   <span>Đặt bàn</span>
                               </a>
                               <a class="combo-more-btn combo-more-btn--ghost" href="{{ route('foodComboDetail', ['slug' => $combo->slug]) }}">
                                   <span>Xem thêm</span>
                               </a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       @empty
       <div class="text-center py-4">
           <p>Chưa có combo món ăn để hiển thị.</p>
       </div>
       @endforelse

       </div>
   </div>
</section>
<!-- Convenient Foods Section -->
<section class="convenient-section">
   <div class="auto-container">
       <div class="convenient-panel wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="60ms">
           <div class="convenient-products">
               <div class="convenient-products__head wow fadeInDown" data-wow-duration="800ms" data-wow-delay="0ms">
                   <h2 class="convenient-script">Sản phẩm</h2>
                   <div class="convenient-eyebrow">Hương vị truyền thống</div>
               </div>

               <div class="convenient-products-slider swiper">
                   <div class="swiper-wrapper">
                    @foreach ($homePro as $item)
                    <div class="swiper-slide">
                        @include('layouts.product.item', ['pro' => $item])
                    </div>
                    @endforeach
                   </div>

                   <div class="convenient-nav convenient-nav--prev"><span class="fal fa-angle-left"></span></div>
                   <div class="convenient-nav convenient-nav--next"><span class="fal fa-angle-right"></span></div>
               </div>
           </div>
       </div>
   </div>
</section>
<!-- End Convenient Foods Section -->


<!--Why Us Section-->
<section class="why-us-two section-kt">
   <div class="auto-container">
       <div class="title-box centered mb-5 wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="subtitle"><span>why choose us</span></div>
           <h2>Tại sao chọn chúng tôi</h2>
       </div>
       <div class="row clearfix">
           <!--Block-->
           @foreach ($whyChoose as $item)
            <div class="why-block-two col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="inner-box wow fadeInUp" data-wow-duration="900ms" data-wow-delay="{{ ($loop->index % 4) * 100 }}ms">
                    <div class="image-box"><img src="{{ url($item->image) }}" alt="{{ $item->title }}" width="400" height="400" loading="lazy" decoding="async"></div>
                    <div class="over-box">
                        <h6>{{ $item->title }}</h6>
                        <div class="why-desc-wrap">
                            <p class="why-desc">{{ $item->description }}</p>
                            <button type="button" class="why-desc-toggle">Xem thêm</button>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
       </div>

       <div class="fact-counter">
           <div class="row clearfix">
               <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="850ms" data-wow-delay="0ms">
                   <div class="inner clearfix">
                       <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="20" data-speed="2000">20</span><i>năm</i></div></div>
                       <div class="fact-title">kinh nghiệm</div>
                       <p> Hơn 20 năm gắn bó với nghề bếp và hành trình phát triển ẩm thực Việt.</p>
                   </div>
               </div>
               <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="850ms" data-wow-delay="100ms">
                   <div class="inner clearfix">
                       <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="3" data-speed="1500">0</span><i>lần</i></div></div>
                       <div class="fact-title">Đầu bếp Tiêu biểu</div>
                       <p>Được vinh danh 3 năm liên tiếp: 2017 – 2018 – 2019.</p>
                   </div>
               </div>
               <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="850ms" data-wow-delay="200ms">
                   <div class="inner clearfix">
                       <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="200" data-speed="1000">200</span><i>+</i></div></div>
                       <div class="fact-title">Món Ăn</div>
                       <p> Những món ăn được nghiên cứu, sáng tạo và hoàn thiện qua hành trình gắn bó với ẩm thực Việt. </p>
                   </div>
               </div>
               <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="850ms" data-wow-delay="300ms">
                   <div class="inner clearfix">
                       <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="10" data-speed="1000">0</span><i>+</i></div></div>
                       <div class="fact-title">Sự kiện & hoạt động ẩm thực</div>
                       <p> Hành trình tham gia, đồng hành và lan tỏa giá trị ẩm thực Việt qua nhiều hoạt động ý nghĩa. </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>

<!--Testimonials Section-->
<section class="testimonials-two section-kt">
   <div class="auto-container">
       
       <div class="title-box centered mb-5 wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="subtitle"><span>testimonials</span></div>
           <h2 class="red-color">Khách hàng nói gì về chúng tôi</h2>
       </div>
       <div class="carousel-box wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="100ms">
           <div class="testimonial-slider owl-theme owl-carousel">
            @foreach ($ReviewCus as $item)
                 <!--Slide Item-->
               <div class="testi-block">
                <div class="inner-box">
                    <div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></div>
                    <div class="text">{{languageName($item->content)}}</div>
                    <div class="auth-info">
                        <div class="image"><img src="{{ url($item->avatar) }}" alt="{{ languageName($item->name) }}" width="80" height="80" loading="lazy" decoding="async"></div>
                        <div class="auth-title">{{languageName($item->name)}} -<span class="location">{{languageName($item->position)}}</span> </div>
                    </div>
                </div>
            </div>
            @endforeach
              


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

<!--Recnt Updates Section-->
<section class="news-section section-kt">
   <div class="auto-container">
       <div class="title-box centered mb-5 wow fadeInUp" data-wow-duration="900ms" data-wow-delay="0ms">
           <div class="subtitle"><span>recent updates</span></div>
           <h2 class="red-color">Bài viết mới nhất</h2>
       </div>
       <div class="news-slider-wrap wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="100ms">
           <div class="news-slider swiper">
               <div class="swiper-wrapper">
                   @forelse(($hotnews ?? collect()) as $index => $item)
                   @php
                       $blogUrl = route('detailBlog', ['slug' => $item->slug]);
                       $blogTitle = languageName($item->title);
                       $blogDate = $item->created_at ? $item->created_at->locale('vi') : null;
                   @endphp
                   <div class="swiper-slide">
                       <div class="news-block">
                           <div class="inner-box">
                               <div class="image-box">
                                   <div class="image">
                                       <a href="{{ $blogUrl }}" title="{{ $blogTitle }}">
                                           <img src="{{ url($item->image) }}" alt="{{ $blogTitle }}" width="600" height="400" loading="lazy" decoding="async">
                                       </a>
                                   </div>
                                   <div class="over-content">
                                       @if($blogDate)
                                       <div class="date">{{ $blogDate->format('d') }} <span>{{ $blogDate->translatedFormat('M') }} | {{ $blogDate->format('Y') }}</span></div>
                                       @endif
                                       @if(!empty($item->category))
                                       <div class="cat">{{ $item->category }}</div>
                                       @endif
                                       <h4><a href="{{ $blogUrl }}" title="{{ $blogTitle }}">{{ $blogTitle }}</a></h4>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   @empty
                   <div class="swiper-slide">
                       <div class="news-block">
                           <div class="inner-box">
                               <div class="image-box">
                                   <div class="over-content">
                                       <h4>Chưa có bài viết.</h4>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   @endforelse
               </div>
           </div>
           <div class="news-nav news-nav--prev"><span class="fal fa-angle-left"></span></div>
           <div class="news-nav news-nav--next"><span class="fal fa-angle-right"></span></div>
       </div>
       
   </div>
</section>
@endsection
