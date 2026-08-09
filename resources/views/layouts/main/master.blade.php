{{-- https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-2-Standard-Hero/index.html --}}
<!DOCTYPE html>
<html lang="vi">
   <head>
      @php
      $seoCanonical = trim($__env->yieldContent('canonical')) ?: seo_canonical_url();
      $seoRobots = trim($__env->yieldContent('robots')) ?: seo_robots_directive();
      $seoTitle = trim($__env->yieldContent('title'));
      $seoDescription = trim($__env->yieldContent('description'));
      $seoImage = trim($__env->yieldContent('image'));
      $seoSiteName = $setting->webname ?? ($setting->company ?? config('app.name'));
      @endphp
      <meta charset="UTF-8" />
      <meta name="theme-color" content="#3c0202">
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ $seoTitle }}</title>
      <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
      <meta http-equiv="Content-Language" content="vi" />
      <link rel="alternate" href="{{ $seoCanonical }}" hreflang="vi" />
      <meta name="description" content="{{ $seoDescription }}">
      <meta name="robots" content="{{ $seoRobots }}" />
      <meta name="googlebot" content="{{ $seoRobots }}">
      <meta name="revisit-after" content="3 days" />
      <meta name="rating" content="General">
      <meta name="application-name" content="{{ $seoSiteName }}" />
      <meta name="theme-color" content="#3c0202" />
      <meta name="msapplication-TileColor" content="#3c0202" />
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="apple-mobile-web-app-title" content="{{ $seoSiteName }}" />
      @if ($seoImage)
      <link rel="apple-touch-icon-precomposed" href="{{ $seoImage }}" sizes="700x700">
      @endif
      <meta property="og:url" content="{{ $seoCanonical }}">
      <meta property="og:title" content="{{ $seoTitle }}">
      <meta property="og:description" content="{{ $seoDescription }}">
      <meta property="og:image" content="{{ $seoImage }}">
      <meta property="og:site_name" content="{{ $seoSiteName }}">
      <meta property="og:image:alt" content="{{ $seoTitle }}">
      <meta property="og:type" content="website" />
      <meta property="og:locale" content="vi_VN" />
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content="{{ $seoTitle }}" />
      <meta name="twitter:description" content="{{ $seoDescription }}" />
      <meta name="twitter:image" content="{{ $seoImage }}" />
      <meta name="twitter:url" content="{{ $seoCanonical }}" />
      <meta itemprop="name" content="{{ $seoTitle }}">
      <meta itemprop="description" content="{{ $seoDescription }}">
      <meta itemprop="image" content="{{ $seoImage }}">
      <meta itemprop="url" content="{{ $seoCanonical }}">
      <link rel="canonical" href="{{ $seoCanonical }}">
      @if ($seoImage)
      <link rel="image_src" href="{{ $seoImage }}" />
      @endif
      <link rel="shortcut icon" href="{{ url('' . $setting->favicon) }}" type="image/x-icon">
      <link rel="icon" href="{{ url('' . $setting->favicon) }}" type="image/x-icon">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      @hasSection('schema')
      @yield('schema')
      @else
      @include('partials.seo-organization')
      @endif

      <link rel="preconnect" href="{{ url('/') }}" crossorigin>
      <link rel="dns-prefetch" href="//fonts.googleapis.com">
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link rel="dns-prefetch" href="//kalanidhithemes.com">

      @stack('preload')

      <!-- Critical CSS -->
      <link href="/frontend/css/bootstrap.css" rel="stylesheet">
      <link href="/frontend/css/style.css" rel="stylesheet">
      <link href="/frontend/main/rtecontent.css" rel="stylesheet" media="print" onload="this.media='all'">
      <noscript><link href="/frontend/main/rtecontent.css" rel="stylesheet"></noscript>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link href="/frontend/css/responsive.css" rel="stylesheet">
      <link href="/frontend/css/booking-modal.css" rel="stylesheet" media="print" onload="this.media='all'">
      <noscript><link href="/frontend/css/booking-modal.css" rel="stylesheet"></noscript>
      <link href="/frontend/callbutton/call-button.css" rel="stylesheet" media="print" onload="this.media='all'">
      <noscript><link href="/frontend/callbutton/call-button.css" rel="stylesheet"></noscript>
      @yield('css')
   </head>
   <body>
      <div class="page-wrapper"> 
  
         <!-- Preloader -->
         <div class="loader-wrap">
             <div class="preloader">
                 <div class="preloader-close">x</div>
                 <div id="handle-preloader" class="handle-preloader">
                     <div class="animation-preloader">
                         <div class="spinner"></div>
                        
                     </div>  
                 </div>
             </div>
         </div>
         <!-- Preloader End -->
         
       @include('layouts.header.index')
     
        @yield('content')
     
        @include('layouts.footer.index')
     
     </div>
     <!--End pagewrapper--> 
     
     <!-- Floating Đặt bàn -->
     <a
        href="#bookNowModal"
        class="cq-fab-booking js-open-booking totop"
        data-open-booking
        data-toggle="modal"
        data-target="#bookNowModal"
        aria-label="Đặt bàn ngay"
     >
        <span class="cq-fab-booking__glow" aria-hidden="true"></span>
        <span class="cq-fab-booking__icon" aria-hidden="true">
           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/>
              <path d="M3 9V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2"/>
              <path d="M8 13h.01"/>
              <path d="M12 13h.01"/>
              <path d="M16 13h.01"/>
           </svg>
        </span>
        <span class="cq-fab-booking__text">
           <span class="cq-fab-booking__eyebrow">Reservation</span>
           <span class="cq-fab-booking__label">Đặt bàn ngay</span>
        </span>
     </a>

     @include('partials.book-now-modal')
     @include('partials.call-button')
     
      <script defer src="/frontend/js/jquery.js"></script>
      <script defer src="/frontend/js/popper.min.js"></script>
      <script defer src="/frontend/js/bootstrap.min.js"></script>
      <script defer src="/frontend/js/jquery-ui.js"></script>
      <script defer src="/frontend/js/jquery.fancybox.js"></script>
      <script defer src="/frontend/js/swiper.js"></script>
      <script defer src="/frontend/js/owl.js"></script>
      <script defer src="/frontend/js/appear.js"></script>
      <script defer src="/frontend/js/wow.js"></script>
      <script defer src="/frontend/js/parallax.min.js"></script>
      <script defer src="/frontend/js/custom-script.js"></script>
      <script defer src="/frontend/js/lazy-media.js"></script>
      <script defer src="/frontend/js/booking-modal.js"></script>
      <script defer src="/frontend/callbutton/call-button.js"></script>
      @yield('js')
   </body>
</html>
