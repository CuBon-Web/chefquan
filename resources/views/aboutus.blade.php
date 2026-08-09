@extends('layouts.main.master')
@section('title')
    Về Chúng Tôi
@endsection
@section('description')
    {{ $setting->company }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ url('frontend/css/breadcrumb_style.scss.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/paginate.scss.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/style_page.scss.css') }}">
@endsection
@section('js')
@endsection
@section('content')
<section class="inner-banner">
    <div class="image-layer" style="background-image: url({{ url($banner[0]->image) }});"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>Về Chúng Tôi</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><span>Về Chúng Tôi</span></li>
            </ul>
        </div>
    </div>
  </section>
  <section class="blog_list_section section-kt">
    <div class="auto-container">
      <div class="row">
          <!-- Blog Left Side -->            
        <div class="col-lg-12">
          <div class="rte_content text-white">
            {!!languageName($gioithieu->content)!!}
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection
