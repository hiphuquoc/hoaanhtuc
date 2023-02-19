@foreach($prices as $price)
    @php
        $selected = null;
        if($loop->index==0) $selected = 'selected';
    @endphp
    <div data-product_price_id="{{ $price->id }}" class="productDetailBox_detail_price_item {{ $selected }}">
        <div class="productDetailBox_detail_price_item_real">{{ number_format($price->price) }}{!! config('main.currency_unit') !!}</div>
        @if(!empty($price->price_before_promotion)&&$price->price_before_promotion!=$price->price)
            <div class="productDetailBox_detail_price_item_old">{{ number_format($price->price_before_promotion) }}{!! config('main.currency_unit') !!}</div>
        @endif
        @if(!empty($price->sale_off))
            <div class="productDetailBox_detail_price_item_saleoff">- {{ $price->sale_off }}%</div>
        @endif
    </div>
@endforeach

