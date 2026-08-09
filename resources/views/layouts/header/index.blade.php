@php
    $headerCartCount = collect($cartcontent ?? [])->sum(function ($item) {
        return (int) ($item['quantity'] ?? 0);
    });
@endphp
  <!-- Main Header-->
  <header class="main-header header-down">
   <div class="header-top">
       <div class="auto-container">
           <div class="inner clearfix">
               <div class="top-left clearfix">
                   <ul class="top-info clearfix">
                       <li><i class="icon far fa-map-marker-alt"></i> {{$setting->address1}}</li>
                       <li><i class="icon far fa-clock"></i> Daily : 8.00 am to 10.00 pm</li>
                   </ul>
               </div>
               <div class="top-right clearfix">
                   <ul class="top-info clearfix">
                       <li><a href="tel:{{$setting->phone1}}"><i class="icon far fa-phone"></i> {{$setting->phone1}}</a></li>
                       <li><a href="mailto:{{$setting->email}}"><i class="icon far fa-envelope"></i> {{$setting->email}}</a></li>
                   </ul>
               </div>
           </div>
       </div>
   </div>
   <!-- Header Upper -->
   <div class="header-upper">        
       <div class="auto-container">
           <!-- Main Box -->
           <div class="main-box clearfix">
               <!--Logo-->
               <div class="logo-box">
                    <div class="logo">
                        <a href="{{route('home')}}" title="{{$setting->company}}">
                           <img class="no-lazy" src="{{url($setting->logo)}}" alt="{{$setting->company}}" title="{{$setting->company}}" width="160" height="50" decoding="async" fetchpriority="high">
                        </a>
                     </div>
               </div>

               <div class="nav-box clearfix">
                   <!--Nav Outer-->
                   <div class="nav-outer clearfix">         
                       <nav class="main-menu">
                           <ul class="navigation clearfix">
                               <li class="dropdown current"><a href="{{route('home')}}">Trang chủ</a>
                               </li>
                               <li><a href="{{route('aboutUs')}}">Chef Quân</a></li>
                               <li class="dropdown has-mega-menu"><a href="javascript:void(0)">Taste Of Vietnam</a>
                                   <ul>
                                   
                                    <li>
                                        <div class="mega-menu">
                                            <div class="menu-inner">
                                                <div class="auto-container">
                                                    <div class="row clearfix">
                                                        @foreach ($foodComboHome as $item)
                                                        @php
                                                                $comboImages = $item->images_array;
                                                                $cover = !empty($comboImages[0]) ? $comboImages[0] : asset('frontend/images/resource/maindish1.jpg');
                                                            @endphp
                                                        <div class="menu-block col-lg-3 col-md-6 col-sm-6">
                                                            <div class="image"><a href="{{ route('foodComboDetail', ['slug' => $item->slug]) }}"><img src="{{ url($cover) }}" alt="{{ $item->name }}" width="280" height="180" loading="lazy" decoding="async"></a></div>
                                                            <div class="title"><a href="{{ route('foodComboDetail', ['slug' => $item->slug]) }}">{{($item->name)}}</a></div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                       
                                   </ul>
                               </li>
                               
                               <li><a href="{{route('allProduct')}}">Bếp Quân</a></li>
                               @foreach ($blogCate as $item)
                                 <li><a href="{{route('listCateBlog', ['slug' => $item->slug]) }}">{{languageName($item->name)}}</a>
                                    
                                 </li>
                               @endforeach
                               
                               <li><a href="{{route('lienHe')}}">Liên hệ</a></li>
                           </ul>
                       </nav>
                       <!-- Main Menu End-->
                   </div>
                   <!--Nav Outer End-->

                   <div class="links-box clearfix">
                       <div class="link link-cart">
                           <a href="{{ route('listCart') }}" class="header-cart-btn" title="Giỏ hàng">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20" aria-hidden="true" fill="currentColor">
                                   <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 27 39.6 53.9l-64 256c-4.5 18.1-21.3 30.9-40.1 30.9H192c-17.7 0-32-14.3-32-32s14.3-32 32-32h318.5l64-256H96.9c-9.2 0-17.7 5.8-20.7 14.1L83.1 96H24C10.7 96 0 85.3 0 72S10.7 48 24 48h8.3l14.3-57.1C51.4 9.7 69.7 0 89.1 0H192c0 .1 0 .1 0 0H69.5C50.1 0 31.8 9.7 24.6 24H24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                               </svg>
                               <span class="header-cart-btn__count cart-count js-cart-count" data-count="{{ $headerCartCount }}" @if($headerCartCount < 1) hidden @endif>{{ $headerCartCount }}</span>
                           </a>
                       </div>
                       <div class="link link-btn">
                           <a href="#bookNowModal" class="theme-btn btn-style-one clearfix js-open-booking" data-open-booking data-toggle="modal" data-target="#bookNowModal">
                               <span class="btn-wrap">
                                   <span class="text-one">Đặt bàn</span>
                                   <span class="text-two">Đặt bàn</span>
                               </span>
                           </a>
                       </div>
                       <div class="link info-toggler">
                           <button class="info-btn">
                               <span class="hamburger">
                                   <span class="top-bun"></span>
                                   <span class="meat"></span>
                                   <span class="bottom-bun"></span>
                               </span>
                           </button>
                       </div>
                   </div>

                   <!-- Hidden Nav Toggler -->
                   <div class="nav-toggler">
                       <button class="hidden-bar-opener">
                           <span class="hamburger">
                               <span class="top-bun"></span>
                               <span class="meat"></span>
                               <span class="bottom-bun"></span>
                           </span>
                       </button>
                   </div>

               </div>

           </div>
       </div>
   </div>
</header>
<!--End Main Header -->

<!--Menu Backdrop-->
<div class="menu-backdrop"></div>
<!-- Hidden Navigation Bar -->
<section class="hidden-bar">
   <!-- Hidden Bar Wrapper -->
   <div class="inner-box">
       <div class="cross-icon hidden-bar-closer"><span class="far fa-close"></span></div>
       <div class="logo-box">
         <a href="{{route('home')}}" title="{{$setting->company}}">
            <img src="{{url($setting->logo)}}" alt="{{$setting->company}}" title="{{$setting->company}}" width="160" height="50" loading="lazy" decoding="async">
         </a>
       </div>
       
       <!-- .Side-menu -->
       <div class="side-menu">
            <ul class="navigation clearfix">
               <li><a href="{{route('home')}}">Trang chủ</a>
               </li>
               <li class="dropdown"><a href="">Taste Of Vietnam</a>
                   <ul>
                    @foreach ($foodComboHome as $item)
                    @php
                                                                $comboImages = $item->images_array;
                                                                $cover = !empty($comboImages[0]) ? $comboImages[0] : asset('frontend/images/resource/maindish1.jpg');
                                                            @endphp
                    <li><a href="{{ route('foodComboDetail', ['slug' => $item->slug]) }}">{{($item->name)}}</a></li>
                    @endforeach
                   </ul>
               </li>
               <li><a href="{{route('aboutUs')}}">Chef Quân</a></li>
               <li><a href="{{route('allProduct')}}">Bếp Quân</a></li>
               @foreach ($blogCate as $item)
               <li><a href="{{route('listCateBlog', ['slug' => $item->slug]) }}">{{languageName($item->name)}}</a></li>
               @endforeach
               <li><a href="{{route('lienHe')}}">Liên hệ</a></li>
               <li>
                  <a href="{{ route('listCart') }}">
                     Giỏ hàng
                     <span class="header-cart-btn__count cart-count js-cart-count" data-count="{{ $headerCartCount }}" @if($headerCartCount < 1) hidden @endif>{{ $headerCartCount }}</span>
                  </a>
               </li>
           </ul>
       </div><!-- /.Side-menu -->
   
   </div><!-- / Hidden Bar Wrapper -->
</section>
<!-- / Hidden Bar -->

<!--Info Back Drop-->
<div class="info-back-drop"></div>

<!-- Hidden Bar -->
<section class="info-bar">
   <div class="inner-box">
       <div class="cross-icon"><span class="far fa-close"></span></div>
       <div class="image-box"><img src="/frontend/images/sidebar-image.jpg" alt="" title="" width="320" height="200" loading="lazy" decoding="async"></div>
       <div class="logo-box"><a href="{{route('home')}}" title="{{$setting->company}}"><img src="{{url($setting->logo)}}" alt="{{$setting->company}}" title="{{$setting->company}}" width="160" height="50" loading="lazy" decoding="async"></a></div>

       <h5>{{$setting->company}}</h5>
       <ul class="info">
           <li>{{$setting->address1}}</li>
           <li> <span class="ib-ttl"> Giờ mở cửa </span>- </li>
           <li><span class="ib-ttl"> Giờ đóng cửa</span> - </li>
           <li><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></li>
       </ul>
       <div class="booking-info">
           <div class="bk-no"><a href="tel:{{$setting->phone1}}">Đặt bàn: {{$setting->phone1}}</a></div>
       </div>
   </div>
</section>
<!--End Hidden Bar -->