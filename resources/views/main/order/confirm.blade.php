@extends('layouts.checkout')
@section('title')
    Xác nhận đơn hàng {{ $order->code }} thành công
@endsection
@section('content')
<div id="js_printContent">
<div class="pageCheckout">
    <div class="pageCheckout_content" style="max-width:660px;">
        <div class="pageCheckout_content_box">
            
            <div class="pageCheckout_content_box_logo">
                {{-- <div class="logoMain"></div> --}}
                <img src="{{ Storage::url(config('main.logo_main')) }}" />
            </div>
            <div class="pageCheckout_content_box_body">
                <!-- lời cảm ơn -->
                <div class="messageOrderSuccess notPrint">
                    <div class="messageOrderSuccess_image">
                        <img src="{{ Storage::url('images/icon-order-succes.png') }}" />
                    </div>
                    <div class="messageOrderSuccess_text">Cảm ơn bạn đã đặt hàng!</div>
                </div>
                <!-- danh sách sản phẩm -->
                <div class="confirmSectionBox">
                    <div class="confirmSectionBox_title" style="margin-bottom:1.25rem;">
                        Đơn hàng: #{{ $order->code }} - đặt lúc {{ date('H:i, d/m/Y', strtotime($order->created_at))}}
                    </div>
                    <div class="confirmSectionBox_body">

                        <div class="checkoutProductBox_body">
                            @foreach($order->products as $product)
                                @php
                                    $title      = $product->infoProduct->name ?? $product->infoProduct->seo->title ?? null;
                                    /* ảnh */
                                    $image      = config('image.default_square');
                                    if(!empty($product->infoPrice->files[0]->file_path)&&file_exists(Storage::path($product->infoPrice->files[0]->file_path))) $image = Storage::url($product->infoPrice->files[0]->file_path);
                                @endphp
                                <div class="checkoutProductBox_body_item">
                                    <div class="checkoutProductBox_body_item_image">
                                        <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
                                        <div class="checkoutProductBox_body_item_image_quantity">{{ $product->quantity }}</div>
                                    </div>
                                    <div class="checkoutProductBox_body_item_content">
                                        <div class="checkoutProductBox_body_item_content_title maxLine_2">
                                            {{ $title }}
                                        </div>
                                        <div class="checkoutProductBox_body_item_content_option">
                                            {{ $product->infoPrice->name ?? null }}
                                        </div>
                                    </div>  
                                    <div class="checkoutProductBox_body_item_price">
                                        {!! number_format($product->price*$product->quantity).config('main.currency_unit') !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- chi tiết thanh toán -->
                <div class="detailPayment" style="margin-top:1rem;">
                    <div class="detailPayment_item">
                        <div>Phí vận chuyển:</div> 
                        <div>{!! !empty($order->ship_cash) ? $order->ship_cash.config('main.currency_unit') : 0 !!}</div>
                    </div>
                    <div class="detailPayment_item">
                        <div>Tổng cộng:</div> 
                        <div class="priceTotal">{!! number_format($order->total).config('main.currency_unit') !!}</div>
                    </div>
                    <div class="detailPayment_item">
                        <div>Hình thức thanh toán</div> 
                        <div>Thanh toán khi nhận hàng (COD)</div>
                    </div>
                </div>

                <!-- thông tin giao hàng -->
                <div class="confirmSectionBox">
                    <div class="confirmSectionBox_title">
                        Thông tin giao hàng
                    </div>
                    <div class="confirmSectionBox_body">
                        <div class="confirmSectionBox_body_item">
                            <div>Người nhận:</div>
                            <div>Phạm Văn Phú</div>
                        </div>
                        <div class="confirmSectionBox_body_item">
                            <div>Số điện thoại:</div>
                            <div>0968617168</div>
                        </div>
                        <div class="confirmSectionBox_body_item">
                            <div>Địa chỉ:</div>
                            <div>443 Mạc Cửu, Phường Vĩnh Thanh, Rạch Giá, Kiên Giang.</div>
                        </div>
                    </div>
                </div>
                <!-- vận chuyển -->
                <div class="confirmSectionBox">
                    <div class="confirmSectionBox_title">
                        Phương thức vận chuyển
                    </div>
                    <div class="confirmSectionBox_body">
                        <div>Miễn phí vận chuyển đơn 498k</div>
                    </div>
                </div>
                
            </div>
            <div class="pageCheckout_content_box_footer">
                Sau khi hoàn tất đơn hàng khoảng 60-90 phút (trong giờ hành chính), {{ config('main.company_name') }} sẽ nhanh chóng gọi điện xác nhận lại thời gian giao hàng với bạn.<br/>
                {{ config('main.company_name') }} xin cảm ơn!
            </div>
        </div>
    </div>
</div>
</div>

<div class="buttonBoxPageConfirm">
    <div class="buttonBoxPageConfirm_box">
        <a href="/"><i class="fa-solid fa-arrow-left"></i>Tiếp tục mua sắm</a> 
        <div class="button" onClick="printContent('js_printContent');"><i class="fa-solid fa-print"></i>In đơn hàng</div>
    </div>
</div>

<script type="text/javascript">
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printableArea = document.getElementById(el);
        var notToPrints = document.getElementsByClassName("notPrint");
        while (notToPrints.length > 0) {
            notToPrints[0].parentNode.removeChild(notToPrints[0]);
        }
        document.body.innerHTML = printableArea.innerHTML;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
@endsection