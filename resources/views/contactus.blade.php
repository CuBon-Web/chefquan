@extends('layouts.main.master')
@section('title')
Liên hệ với chúng tôi
@endsection
@section('description')
Liên hệ với chúng tôi
@endsection
@section('image')
{{url(''.$setting->logo)}}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
@php
    $contactPhone1 = trim((string) ($setting->phone1 ?? ''));
    $contactPhone2 = trim((string) ($setting->phone2 ?? ''));
    $contactPhone1Digits = preg_replace('/[^0-9+]/', '', $contactPhone1);
    $contactPhone2Digits = preg_replace('/[^0-9+]/', '', $contactPhone2);
    $contactEmail = trim((string) ($setting->email ?? ''));
    $contactAddressMain = trim((string) ($setting->address2 ?? ''));
    $contactAddressOffice = trim((string) ($setting->address1 ?? ''));
    $contactAddress = $contactAddressMain !== '' ? $contactAddressMain : $contactAddressOffice;
@endphp
<section class="inner-banner">
   <div class="image-layer" style="background-image: url(/frontend/images/banner-image-4.jpg);"></div>
   <div class="auto-container">
       <div class="inner">
           <h1>Contact Us</h1>
           <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
       </div>
   </div>
</section>
<section class="contact-page section-kt">

   <!--Location form Section-->
   <div class="auto-container">
       <div class="c-page-form-box">
           <div class="row clearfix">

           <!--form image Section-->
           <div class="loc-block info-block col-lg-5 col-md-12 col-sm-12">
               <div class="contact-image">
                   <img src="{{$banner[0]->image}}" alt="image">
               </div>
               <h5> {{languageName($setting->company)}} </h5>
               <div class="text">
                   {!!languageName($setting->address1)!!} <br> <br> 
                   <span class="c-info-ttl"> Lunch Time </span> - 10.00 am – 3:30 pm <br>  <span class="c-info-ttl">Dinner Time </span> - 08.00 pm – 10:30 pm <br>  <br> 
                   <span class="more-link"> Booking : <a href="tel:+85-123-456789">{{$contactPhone1}}</a> </span> <br>  
                   <span class="more-link"> Email: <a href="mailto:{{$contactEmail}}">{{$contactEmail}}</a></span>

               </div>
           </div>

           <!--Vertical line -->
           <div class="col-12 col-md-1 d-flex justify-content-center middle-line-wrapper">
             <div class="middle-line-container">
               <div class="dot top-dot"></div>
               <div class="v-line"></div>
               <div class="dot bottom-dot"></div>
             </div>
           </div>

           <!--form Section-->
           <div class="loc-block col-lg-6 col-md-12 col-sm-12">
               <div class="form-side">
                   <div class="title-box centered">
                       <div class="subtitle"><span>Write to us</span></div>
                       <h2>Liên hệ với chúng tôi</h2>
                       <div class="text desc">Liên hệ với chúng tôi - chúng tôi sẽ trả lời trong vòng 24 giờ và làm việc với bạn!</div>
                   </div>
                   <div class="default-form reservation-form">
                       <form method="post" action="{{route('postcontact')}}">
                        @csrf
                           <div class="clearfix">
                               <div class="form-group">
                                   <div class="field-inner">
                                       <input type="text" name="name" value="" placeholder="Your Name" required="">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <div class="field-inner">
                                       <input type="text" name="email" value="" placeholder="Your Email" required="">
                                   </div>
                               </div>
                               <div class="form-group ">
                                   <div class="field-inner">
                                       <input type="text" name="phone" value="" placeholder="Phone Number" required="">
                                   </div>
                               </div>
                           
                               <div class="form-group ">
                                   <div class="field-inner">
                                       <textarea name="mess" placeholder="Special Request" required=""></textarea>
                                   </div>
                               </div>

                               <div class="form-group">
                                   <button type="submit" class="theme-btn btn-style-one clearfix">
                                       <span class="btn-wrap">
                                           <span class="text-one">Gửi thông tin</span>
                                           <span class="text-two">Gửi thông tin</span>
                                       </span>
                                   </button>
                               </div>
                           </div>
                       </form>
                   </div>
               </div>
           </div>

           </div>
       </div>
   </div>

</section>
@endsection