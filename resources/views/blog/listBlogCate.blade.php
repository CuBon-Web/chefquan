@extends('layouts.main.master')
@section('title')
{{$title_page}} 
@endsection
@section('description')
{{$title_page}} 
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('schema')
@php
    $cleanText = function ($value) {
        $text = (string) $value;
        // Remove zero-width chars that usually appear from copy/paste.
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    };
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    $currentUrl = url()->current();
    $homeUrl = route('home');
    $siteUrl = url('/');
    $categoryUrl = route('listCateBlog', ['slug' => $cate_name]);
    $pageTitle = $cleanText($title_page);
    $siteName = $cleanText($setting->webname ?? $setting->company ?? $title_page);
    $publisherName = $cleanText($setting->company ?? $siteName);
    $publisherLogo = !empty($setting->logo)
        ? url($setting->logo)
        : (!empty($banner[0]->image) ? url($banner[0]->image) : null);

    $itemListElements = [];
    foreach ($blog as $index => $item) {
        $postUrl = route('detailBlog', ['slug' => $item->slug]);
        $postImage = !empty($item->image) ? url($item->image) : null;
        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => $postUrl,
            'item' => array_filter([
                '@type' => 'BlogPosting',
                'headline' => $cleanText(languageName($item->title)),
                'description' => $cleanText(strip_tags(languageName($item->description))),
                'datePublished' => optional($item->created_at)->toIso8601String(),
                'image' => $postImage,
                'mainEntityOfPage' => $postUrl,
            ], function ($value) {
                return !is_null($value) && $value !== '';
            }),
        ];
    }

    $schemaGraph = [
        [
            '@type' => 'WebSite',
            '@id' => $siteUrl . '#website',
            'url' => $siteUrl,
            'name' => $siteName,
            'inLanguage' => 'vi-VN',
        ],
        array_filter([
            '@type' => 'Organization',
            '@id' => $siteUrl . '#organization',
            'name' => $publisherName,
            'url' => $siteUrl,
            'logo' => $publisherLogo ? [
                '@type' => 'ImageObject',
                'url' => $publisherLogo,
            ] : null,
        ], function ($value) {
            return !is_null($value) && $value !== '';
        }),
        [
            '@type' => 'BreadcrumbList',
            '@id' => $currentUrl . '#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Trang chủ',
                    'item' => $homeUrl,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $pageTitle,
                    'item' => $categoryUrl,
                ],
            ],
        ],
        [
            '@type' => 'CollectionPage',
            '@id' => $currentUrl . '#collection',
            'url' => $currentUrl,
            'name' => $pageTitle,
            'description' => $pageTitle,
            'inLanguage' => 'vi-VN',
            'isPartOf' => [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
            ],
        ],
        [
            '@type' => 'ItemList',
            '@id' => $currentUrl . '#itemlist',
            'name' => $pageTitle,
            'numberOfItems' => count($itemListElements),
            'itemListElement' => $itemListElements,
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], $jsonFlags) !!}</script>
@endsection
@section('css')
<style>
  /* Sticky sidebar: page-wrapper overflow breaks position:sticky */
  .page-wrapper { overflow: visible !important; }
  .blog_list_section .blog_right_side {
    position: -webkit-sticky;
    position: sticky;
    top: 120px;
    z-index: 2;
  }
  @media (max-width: 991px) {
    .blog_list_section .blog_right_side {
      position: static;
      top: auto;
    }
  }
</style>
@endsection
@section('js')

@endsection
@section('content')
<section class="inner-banner">
    <div class="image-layer" style="background-image: url({{ $banner[0]->image }});"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>{{ $title_page }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><span>{{ $title_page }}</span></li>
            </ul>
        </div>
    </div>
  </section>
  <section class="blog_list_section section-kt">
    <div class="auto-container">
      <div class="row">
          <!-- Blog Left Side -->            
        <div class="col-lg-8">
          <div class="blog_left_side">
            <div class="row">
                @foreach ($blog as $item)
                <div class="col-lg-6">
                    <!-- Blog post -->
                    <div class="blog_panel" data-aos="fade-up" data-aos-duration="1500">
                        <div class="main_img">
                            <a href="{{route('detailBlog',['slug'=>$item->slug])}}"><img src="{{url($item->image)}}" alt="{{languageName($item->title)}}"></a>
                        </div>
                        <div class="blog_info">
                            <ul>
                                <li> {{date_format($item->created_at,'d/m/Y')}} </li>
                                <li> By: Admin </li>
                             </ul>
                            <h4><a href="{{route('detailBlog',['slug'=>$item->slug])}}">{{languageName($item->title)}}</a></h4>
                            <p>{!!languageName($item->description)!!}</p>
                            <div class="link-box">
                                <a href="{{route('detailBlog',['slug'=>$item->slug])}}" class="theme-btn btn-style-two clearfix">
                                    <span class="btn-wrap">
                                        <span class="text-one">Xem thêm</span>
                                        <span class="text-two">Xem thêm</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
          </div>
        </div>

        <!-- blog Right Side -->
        <div class="col-lg-4">
          <div class="blog_right_side">
           
            <!-- Recent Post -->
            <div class="recent_post_block bg_box" data-aos="fade-up" data-aos-duration="1500">
              <h6>Bài viết mới</h6>
              <ul class="recent_blog_list">
                @foreach ($blognew as $item)
                <li>
                  <a href="{{route('detailBlog',['slug'=>$item->slug])}}">
                    <div class="img">
                      <img src="{{url($item->image)}}" alt="{{languageName($item->title)}}">
                    </div>
                    <div class="text">
                      <p>{!!languageName($item->description)!!}</p>
                      <span>{{date_format($item->created_at,'d/m/Y')}}</span>
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>

            <!-- Categories List -->
            <div class="categories_block bg_box" data-aos="fade-up" data-aos-duration="1500">
              <h6>Taste Of Vietnam</h6>
              <ul>
                @foreach ($foodComboHome as $item)
                    @php
                                                                $comboImages = $item->images_array;
                                                                $cover = !empty($comboImages[0]) ? $comboImages[0] : asset('frontend/images/resource/maindish1.jpg');
                                                            @endphp
                    <li><a href="{{ route('foodComboDetail', ['slug' => $item->slug]) }}">{{($item->name)}}</a></li>
                    @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination Block Start -->
      <div class="pagination_block" data-aos="fade-up" data-aos-duration="1500">
        <div class="row">
          <div class="col-lg-8">
           {{$blog->links()}}
          </div>
        </div>
      </div>
      <!-- Pagination Block End -->
    </div>
  </section>
@endsection