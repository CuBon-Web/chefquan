@extends('layouts.main.master')
@section('title')
Video – Kể chuyện Việt qua một món ăn
@endsection
@section('description')
Những câu chuyện phía sau nguyên liệu, bí quyết chế biến và văn hóa Việt Nam.
@endsection
@section('image')
{{ !empty($banner[0]->image) ? url($banner[0]->image) : url($setting->logo) }}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<section class="inner-banner">
    <div class="image-layer" style="background-image: url({{ !empty($banner[0]->image) ? url($banner[0]->image) : '/frontend/images/banner-image-4.jpg' }});"></div>
    <div class="auto-container">
        <div class="inner">
            <h1>Video</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><span>Video</span></li>
            </ul>
        </div>
    </div>
</section>

<section class="video-page section-kt">
    <div class="auto-container">
        <div class="video-page__header title-box centered">
            <div class="subtitle"><span>Taste Of Vietnam</span></div>
            <h2>Kể chuyện Việt qua một món ăn</h2>
            <p class="video-page__lead">Những câu chuyện phía sau nguyên liệu, bí quyết chế biến và văn hóa Việt Nam.</p>
        </div>

        @if(isset($video) && $video->count() > 0)
        <div class="video-page__grid">
            @foreach ($video as $item)
            @php
                $videoName = trim((string) ($item->name ?? ''));
                $videoLink = trim((string) ($item->link ?? ''));
                $videoCover = !empty($item->image) ? url($item->image) : asset('frontend/images/resource/maindish1.jpg');
            @endphp
            <article class="video-page-card">
                <a class="video-page-card__media lightbox-image"
                   href="{{ $videoLink !== '' ? $videoLink : 'javascript:;' }}"
                   title="{{ $videoName }}">
                    <img src="{{ $videoCover }}" alt="{{ $videoName }}" width="640" height="400" loading="lazy" decoding="async">
                    <span class="video-page-card__play" aria-hidden="true"></span>
                </a>
                <h3 class="video-page-card__title">{{ $videoName }}</h3>
            </article>
            @endforeach
        </div>

        @if(method_exists($video, 'links'))
        <div class="video-page__pagination pagination_block">
            {{ $video->links() }}
        </div>
        @endif
        @else
        <div class="video-page__empty">
            <p>Nội dung đang được cập nhật.</p>
        </div>
        @endif
    </div>
</section>
@endsection
