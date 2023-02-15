<div id="cartMessage" class="cartMessage">
    <div class="cartMessage_bg" onClick="openCloseModal('cartMessage');"></div> 
    <div class="cartMessage_box">
        <div class="cartMessage_box_head">
            Đã thêm <span class="highLight">{{ $quantity ?? '-' }}</span> sản phẩm vào giỏ hàng!
        </div>
        <div class="cartMessage_box_body">
            @if(!empty($image))
                <div class="cartMessage_box_body_image">
                    <img src="{{ $image }}" alt="{{ $title ?? null }}" title="{{ $title ?? null }}" />
                </div>
            @endif
            <div class="cartMessage_box_body_content">
                <div class="cartMessage_box_body_content_title maxLine_3">{{ $title ?? 'Không xác định' }}</div>
                <div class="cartMessage_box_body_content_type">{{ $option ?? 'Không xác định' }}</div>
                <div class="cartMessage_box_body_content_price">{{ !empty($price) ? number_format($price).'đ' : '-' }}</div>
            </div>
        </div>
        <div class="cartMessage_box_footer">
            <a href="{{ route('main.cart') }}" class="button">Xem giỏ hàng</a>
        </div>
    </div>
</div>