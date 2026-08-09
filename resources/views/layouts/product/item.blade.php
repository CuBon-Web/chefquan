@php
    $img = json_decode($pro->images, true) ?? [];
    $productUrl = route('detailProduct', [
        'cate' => $pro->cate_slug,
        'type' => $pro->type_slug ? $pro->type_slug : 'loai',
        'id' => $pro->slug,
    ]);

    $productName = languageName($pro->name);
    $cateName = $pro->cate ? languageName($pro->cate->name) : '';
    $thumb = $img[0] ?? '';
    $lazySrc = asset('frontend/images/lazy.png');

    $originalPrice = (float) $pro->price;
    $salePrice = (float) $pro->discount;
    $variantMinPrice = isset($pro->variant_min_price) ? (float) $pro->variant_min_price : null;
    $variantMaxPrice = isset($pro->variant_max_price) ? (float) $pro->variant_max_price : null;
    if (!is_null($variantMinPrice)) {
        $salePrice = $variantMinPrice;
    }

    $discountPercent = 0;
    if ($originalPrice > 0 && $salePrice > 0 && $salePrice < $originalPrice) {
        $discountPercent = 100 - ceil(($salePrice / $originalPrice) * 100);
    }

    $hasVariant = (int) $pro->status_variant === 1;
@endphp
<article class="convenient-product">
   <a href="{{ $productUrl }}">
   <div class="convenient-product__media">
       <img src="{{ $thumb }}" alt="{{ $productName }}" width="400" height="400" loading="lazy" decoding="async">
   </div>
   <div class="convenient-product__body">
       <h3 class="convenient-product__title">{{ $productName }}</h3>
       <div class="price-box">
         @if (!is_null($variantMinPrice) && !is_null($variantMaxPrice))
            @if ($variantMinPrice > 0 && $variantMaxPrice > 0 && $variantMinPrice != $variantMaxPrice)
               <span class="price-box__current">{{ number_format($variantMinPrice) }}₫ - {{ number_format($variantMaxPrice) }}₫</span>
            @elseif ($variantMinPrice > 0)
               <span class="price-box__current">{{ number_format($variantMinPrice) }}₫</span>
            @elseif ($variantMaxPrice > 0)
               <span class="price-box__current">{{ number_format($variantMaxPrice) }}₫</span>
            @endif
            @if ($originalPrice > 0 && $salePrice > 0 && $salePrice < $originalPrice)
            <span class="compare-price">{{ number_format($originalPrice) }}₫</span>
            @endif
         @elseif ($salePrice > 0)
            <span class="price-box__current">{{ number_format($salePrice) }}₫</span>
            @if ($originalPrice > 0 && $salePrice < $originalPrice)
            <span class="compare-price">{{ number_format($originalPrice) }}₫</span>
            @endif
         @elseif ($originalPrice > 0)
            <span class="price-box__current">{{ number_format($originalPrice) }}₫</span>
         @else
            <span class="price-box__contact">Liên hệ</span>
         @endif
      </div>
       <p class="convenient-product__text">{{ Str::limit(languageName($pro->description), 50) }}</p>
       <a href="{{ $productUrl }}" class="convenient-btn convenient-btn--outline">Xem ngay</a>
   </div>
   </a>
</article>