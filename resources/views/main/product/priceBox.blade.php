@php
    $dataPrice  = $prices[0] ?? null;
    if(!empty(request('product_price_id'))){
        foreach($prices as $price){
            if($price->id==request('product_price_id')) $dataPrice = $price;
            break;
        }
    }
@endphp

@if(!empty($dataPrice))
    <div class="productDetailBox_detail_price_real">{{ number_format($dataPrice->price) }}{!! config('main.currency_unit') !!}</div>
    @if(!empty($dataPrice->price_before_promotion)&&$dataPrice->price_before_promotion!=$dataPrice->price)
        <div class="productDetailBox_detail_price_old">{{ number_format($dataPrice->price_before_promotion) }}{!! config('main.currency_unit') !!}</div>
    @endif
    @if(!empty($dataPrice->sale_off))
        <div class="productDetailBox_detail_price_saleoff">- {{ $dataPrice->sale_off }}%</div>
    @endif
@endif

