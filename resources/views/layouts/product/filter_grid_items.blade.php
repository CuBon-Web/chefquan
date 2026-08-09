@if (count($product) > 0)
    @foreach ($product as $item)
        @php
            $itemTags = [];
            if (!empty($item->tags)) {
                $decodedTags = json_decode($item->tags, true);
                if (is_array($decodedTags)) {
                    $itemTags = $decodedTags;
                }
            }
            $itemPriceForFilter = (float) ($item->discount > 0 ? $item->discount : $item->price);
        @endphp
        <div
            class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 col-fix product-list-col item mb-3"
            data-tags="{{ implode(',', $itemTags) }}"
            data-name="{{ strtolower(trim((string) languageName($item->name))) }}"
            data-price="{{ $itemPriceForFilter }}"
            data-product-id="{{ $item->id }}"
        >
            @include('layouts.product.item', ['pro' => $item])
        </div>
    @endforeach
@else
    <div class="col-12">
        <div class="shop-empty-alert mb-0">Không có sản phẩm nào phù hợp.</div>
    </div>
@endif
