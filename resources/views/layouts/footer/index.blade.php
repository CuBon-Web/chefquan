 <!--Main Footer-->
 <footer class="main-footer">
   <div class="upper-section">
       <div class="fluid-section">
           <div class="row clearfix">
               <!--Footer Col-->
               <div class="footer-col footer-map-col col-lg-6 col-md-12 col-sm-12 px-0">
                   <div class="footer-map">
                       {!!$setting->iframe_map!!}
                   </div>
               </div>
               <!--Footer Col-->
               <div class="footer-col info-col col-lg-6 col-md-12 col-sm-12 px-0">
                   <div class="inner wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                       <div class="content">
                           <div class="logo"><a href="{{ route('home') }}" title="{{$setting->company}}"><img src="{{ url($setting->logo) }}" alt="{{$setting->company}}" title="{{$setting->company}}" width="160" height="50" loading="lazy" decoding="async"></a></div>
                           <div class="info">
                               <h6>visit us </h6>
                               <ul>
                                   <li>{{languageName($setting->address)}}</li>
                                   <li>{{languageName($setting->time_open)}}</li>
                                   <li><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></li>
                                   <li><a href="tel:{{$setting->phone}}">Booking Request : {{$setting->phone}}</a></li>
                                   
                               </ul>
                           </div>
                       </div>

                       <!-- last footer -->
                       <div class="bottom_footer">
                       <!-- container start -->
                         <div class="auto-container">
                           <!-- row start -->
                           <div class="row clearfix">
                             <div class="col-lg-4 col-md-4 col-sm-12">
                                 <p>© 2025 All Rights Reserved</p>
                             </div>

                             

                             <div class="col-lg-4 col-md-4 col-sm-12">
                                 <p class="developer_text">Crafted by <a href="" target="blank">Tuấn Anh Dev</a></p>
                             </div>
                           </div>
                         <!-- row end -->
                         </div>
                         <!-- container end -->
                       </div>

                   </div>
               </div>
               
           </div>
       </div>
   </div>
</footer>