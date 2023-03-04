@php
    $idProduct              = $product->id ?? 0;
    $idPrice                = $product->price->id ?? 0;
    $keyId                  = !empty($product->id)&&!empty($product->price->id) ? $product->id.$product->price->id : null;
    $eventUpdateCart        = 'updateCart("js_updateCart_idWrite_'.$keyId.'", "js_updateCart_total", "js_updateCart_count", "js_addToCart_quantity_'.$keyId.'", "cartMain")';
    $eventRemoveProductCart = 'removeProductCart("'.$idProduct.'", "'.$idPrice.'", "js_updateCart_idWrite_'.$keyId.'", "js_updateCart_total", "js_updateCart_count")';
    $title                  = $product->name ?? $product->seo->title ?? null;
    /* ảnh */
    $image                  = config('image.default_square');
    if(!empty($product->price->files[0]->file_path)&&file_exists(Storage::path($product->price->files[0]->file_path))) $image = Storage::url($product->price->files[0]->file_path);
@endphp

<div class="cartProductBox_body_item_info">
    <a href="/{{ $product->seo->slug_full ?? null }}" class="cartProductBox_body_item_info_image">
        <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
    </a>
    <div class="cartProductBox_body_item_info_content">
        <a href="/{{ $product->seo->slug_full ?? null }}" class="cartProductBox_body_item_info_content_title maxLine_2">
            {{ $title }}
        </a>
        <div class="cartProductBox_body_item_info_content_option"> 
            {{ $product->price->name ?? null }}
        </div>
    </div>
</div>
<div class="cartProductBox_body_item_price">
    <div class="cartProductBox_body_item_price_now">{!! !empty($product->price->price) ? number_format($product->price->price).config('main.currency_unit') : '-' !!}</div>
    @if(!empty($product->price->price_before_promotion)&&$product->price->price_before_promotion>$product->price->price)
        <div class="cartProductBox_body_item_price_old">
            <div class="cartProductBox_body_item_price_old_percent">
                -{{ $product->price->sale_off }}%
            </div>
            <div class="cartProductBox_body_item_price_old_number">
                {!! number_format($product->price->price_before_promotion).config('main.currency_unit') !!}
            </div>
        </div>
    @endif
</div>
<div class="cartProductBox_body_item_quantity">
    <div class="inputQty small">
        <div class="inputQty_button minus" onClick="plusMinusQuantity('js_addToCart_quantity_{{ $keyId }}', 'minus');{{ $eventUpdateCart }}"><i class="fa-solid fa-minus"></i></div>
        <input id="js_addToCart_quantity_{{ $keyId }}" type="number" name="quantity" value="{{ $product->cart['quantity'] ?? 0 }}" data-product_info_id="{{ $idProduct }}" data-product_price_id="{{ $idPrice }}" onkeyup="{{ $eventUpdateCart }}" />
        <div class="inputQty_button plus" onClick="plusMinusQuantity('js_addToCart_quantity_{{ $keyId }}', 'plus');{{ $eventUpdateCart }}"><i class="fa-solid fa-plus"></i></div>       
    </div>
</div>
@php
    $money = 0;
    if(!empty($product->price->price)&&!empty($product->cart['quantity'])) $money = number_format($product->price->price*$product->cart['quantity']);
@endphp
<div class="cartProductBox_body_item_money">
    <div>{!! $money.config('main.currency_unit') !!}</div>
    <div class="cartProductBox_body_item_money_icon" onClick="{{ $eventRemoveProductCart }}"><img src="{{ Storage::url('images/svg/icon-trash.svg') }}" alt="xóa sản phẩm khỏi giỏ hàng" title="xóa sản phẩm khỏi giỏ hàng" /></div>
</div>