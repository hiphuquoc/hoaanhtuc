@if(!empty($product))
    @php
        $idProduct          = $product->id ?? 0;
        $idPrice            = $product->price->id ?? 0;
        $keyId              = !empty($product->id)&&!empty($product->price->id) ? $product->id.$product->price->id : null;
        $eventUpdateCart    = 'updateCart("js_updateCart_idWrite_'.$keyId.'", "js_updateCart_total", "js_updateCart_count", "js_addToCart_quantity_'.$keyId.'")';
        $title              = $product->name ?? $product->seo->title ?? null;
        /* ảnh */
        $image              = config('image.default_square');
        if(!empty($product->price->files[0]->file_path)&&file_exists(Storage::path($product->price->files[0]->file_path))) $image = Storage::url($product->price->files[0]->file_path);
    @endphp
    <a href="/{{ $product->seo->slug_full ?? null }}" class="cartBox_list_item_image">
        <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
    </a>
    <div class="cartBox_list_item_content">
        <a href="/{{ $product->seo->slug_full ?? null }}" class="cartBox_list_item_content_title maxLine_2">
            {{ $title }}
        </a>
        <div class="cartBox_list_item_content_price">
            {{ !empty($product->price->price) ? number_format($product->price->price) : 0 }}đ {{ !empty($product->price->name) ? '/'.$product->price->name : null }}
        </div>
        <div class="cartBox_list_item_content_orther">
            <div class="cartBox_list_item_content_orther_quantity">
                <div class="inputQty mini">
                    <div class="inputQty_button minus" onClick="plusMinusQuantity('js_addToCart_quantity_{{ $keyId }}', 'minus');{{ $eventUpdateCart }}"><i class="fa-solid fa-minus"></i></div>
                    <input id="js_addToCart_quantity_{{ $keyId }}" type="number" name="quantity" value="{{ $product->cart['quantity'] ?? 0 }}" data-product_info_id="{{ $idProduct }}" data-product_price_id="{{ $idPrice }}" onkeyup="{{ $eventUpdateCart }}" />
                    <div class="inputQty_button plus" onClick="plusMinusQuantity('js_addToCart_quantity_{{ $keyId }}', 'plus');{{ $eventUpdateCart }}"><i class="fa-solid fa-plus"></i></div>       
                </div>
            </div>
            @if(!empty($product->cart['quantity'])&&!empty($product->price->price))
                <div class="cartBox_list_item_content_orther_total">
                    Thành tiền: <span>{!! number_format($product->cart['quantity']*$product->price->price).config('main.currency_unit') !!}</span>
                </div>
            @endif
        </div>
    </div>
@endif