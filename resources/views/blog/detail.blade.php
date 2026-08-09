@extends('layouts.main.master')
@section('title')
    {{ $blog_detail->seo_title ? $blog_detail->seo_title : languageName($blog_detail->title) }}
@endsection
@section('description')
    {{ $blog_detail->meta_description ? $blog_detail->meta_description : languageName($blog_detail->description) }}
@endsection
@section('image')
    {{ url('' . $blog_detail->image) }}
@endsection
@section('schema')
    @php
        $cleanText = function ($value) {
            $text = (string) $value;
            // Remove zero-width chars that usually appear from copy/paste.
            return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
        };
        $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $postTitle = $cleanText(languageName($blog_detail->title));
        $postDescription = $cleanText(
            $blog_detail->meta_description ?: strip_tags(languageName($blog_detail->description))
        );
        $postContentText = trim($cleanText(strip_tags(languageName($blog_detail->content))));
        preg_match_all('/[\p{L}\p{N}]+/u', $postContentText, $wordMatches);
        $postWordCount = count($wordMatches[0]);
        $postUrl = url()->current();
        $homeUrl = route('home');
        $categoryUrl = route('listCateBlog', ['slug' => $blog_detail->category]);
        $siteName = $setting->webname ?? ($setting->company ?? 'Website');
        $publisherName = $setting->company ?? $siteName;
        $publisherLogo = !empty($setting->logo) ? url($setting->logo) : url('' . $blog_detail->image);
    @endphp
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": {!! json_encode(url('/') . '#website', $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "name": {!! json_encode($siteName, $jsonFlags) !!}
    },
    {
      "@type": "Organization",
      "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!},
      "name": {!! json_encode($publisherName, $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "logo": {
        "@type": "ImageObject",
        "url": {!! json_encode($publisherLogo, $jsonFlags) !!}
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": {!! json_encode($postUrl . '#breadcrumb', $jsonFlags) !!},
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Trang chủ",
          "item": {!! json_encode($homeUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": {!! json_encode($cleanText(languageName($blog_detail->category)), $jsonFlags) !!},
          "item": {!! json_encode($categoryUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": {!! json_encode($postTitle, $jsonFlags) !!},
          "item": {!! json_encode($postUrl, $jsonFlags) !!}
        }
      ]
    },
    {
      "@type": "BlogPosting",
      "@id": {!! json_encode($postUrl . '#article', $jsonFlags) !!},
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": {!! json_encode($postUrl, $jsonFlags) !!}
      },
      "headline": {!! json_encode($postTitle, $jsonFlags) !!},
      "description": {!! json_encode($postDescription, $jsonFlags) !!},
      "articleSection": {!! json_encode($cleanText(languageName($blog_detail->category)), $jsonFlags) !!},
      "keywords": {!! json_encode(implode(', ', $blogTags ?? []), $jsonFlags) !!},
      "inLanguage": "vi-VN",
      "wordCount": {{ $postWordCount }},
      "datePublished": {!! json_encode(optional($blog_detail->created_at)->toIso8601String(), $jsonFlags) !!},
      "dateModified": {!! json_encode(optional($blog_detail->updated_at)->toIso8601String(), $jsonFlags) !!},
      "image": [
        {
          "@type": "ImageObject",
          "url": {!! json_encode(url(''.$blog_detail->image), $jsonFlags) !!}
        }
      ],
      "author": {
        "@type": "Person",
        "name": {!! json_encode($cleanText($blog_detail->author ?: 'Admin'), $jsonFlags) !!}
      },
      "publisher": {
        "@type": "Organization",
        "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!}
      }
    }
  ]
}
</script>
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
    <div class="image-layer" style="background-image: url({{ url($blog_detail->image) }});"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>{{ languageName($blog_detail->title) }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><span>{{ languageName($blog_detail->category) }}</span></li>
                <li><span>{{ languageName($blog_detail->title) }}</span></li>
            </ul>
        </div>
    </div>
  </section>
  <section class="blog_list_section section-kt">
    <div class="auto-container">
      <div class="row">
          <!-- Blog Left Side -->            
        <div class="col-lg-8">
          <div class="rte_content text-white">
            {!!languageName($blog_detail->content)!!}
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
    </div>
  </section>
@endsection
