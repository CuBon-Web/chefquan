@extends('layouts.main.master')
@section('title')
{{ $title }}
@endsection
@section('description')
Danh sách {{ $title }}
@endsection
@section('image')
@php
    $listOgImage = isset($banner[0]) && !empty($banner[0]->image)
        ? url($banner[0]->image)
        : url($setting->logo ?? '');
@endphp
{{ $listOgImage }}
@endsection
@section('css')
@endsection
@section('js')

@endsection
@section('content')
@php
    $hasSeoContent = !empty($content) && $content !== 'none';
@endphp
<section class="inner-banner">
    <div class="image-layer" style="background-image: url({{ url($listOgImage) }});"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>{{ $title }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><span>{{ languageName($title) }}</span></li>
            </ul>
        </div>
    </div>
  </section>

  <section class="page shop-list-section pt-5 pb-5">
    <div class="container">
       <div class="wrap_background_aside padding-top-15 margin-bottom-40 pg_page">


          <div class="row shop-list-layout">


             <div class="col-lg-12 col-md-12 shop-list-main">
        

                <div class="all-products">
                   <div
                      class="row row-fix product-list-row"
                      data-cate="{{ $cate_slug ?? '' }}"
                      data-type="{{ $type_slug ?? '' }}"
                      data-typetwo="{{ $type_two_slug ?? '' }}"
                   >
                      @include('layouts.product.filter_grid_items', ['product' => $list])
                   </div>
                </div>

                <nav class="shop-pagination" aria-label="Phân trang sản phẩm">
                   {{ $list->links() }}
                </nav>
             </div>
          </div>

          @if ($hasSeoContent)
          <div class="row">
             <div class="col-12">
                <div class="shop-list-seo">{!! $content !!}</div>
             </div>
          </div>
          @endif
       </div>
    </div>
 </section>
@endsection
