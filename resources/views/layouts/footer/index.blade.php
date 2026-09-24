 <!--Main Footer-->
 <footer class="main-footer footer-invite">
   <div class="footer-invite__banner">
       <div class="auto-container">
           <div class="footer-invite__layout">
               <div class="footer-invite__portrait">
                   <img src="{{ asset('frontend/images/men.png') }}" alt="Chef Quân" width="320" height="400" loading="lazy" decoding="async">
               </div>

               <div class="footer-invite__content">
                   <h2 class="footer-invite__script">Hẹn bạn tại bàn ăn</h2>
                   <p class="footer-invite__brand">Chef Quân – Taste Of Vietnam</p>
                   <ul class="footer-invite__meta">
                       <li>
                           <i class="far fa-map-marker-alt" aria-hidden="true"></i>
                           <span>{{ $setting->address1 ?: languageName($setting->address) }}</span>
                       </li>
                       <li>
                           <i class="far fa-phone" aria-hidden="true"></i>
                           <a href="tel:{{ $setting->phone1 ?: $setting->phone }}">{{ $setting->phone1 ?: $setting->phone }}</a>
                       </li>
                   </ul>
               </div>

               <div class="footer-invite__action">
                   <a class="footer-invite__btn js-open-booking" href="#bookNowModal" data-open-booking data-toggle="modal" data-target="#bookNowModal">Đặt bàn ngay</a>
               </div>
           </div>
       </div>
   </div>

   <div class="footer-invite__bottom">
       <div class="auto-container">
           <div class="footer-invite__bottom-row">
               <p>© {{ date('Y') }} All Rights Reserved</p>
               <p class="developer_text">Crafted by <a href="" target="_blank" rel="noopener">Tuấn Anh Dev</a></p>
           </div>
       </div>
   </div>
</footer>
