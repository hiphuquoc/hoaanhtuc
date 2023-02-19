@extends('layouts.main')
@push('headCustom')
<!-- ===== START:: SCHEMA ===== -->
    <!-- STRAT:: Title - Description - Social -->
    @include('main.schema.social', compact('item'))
    <!-- END:: Title - Description - Social -->

    <!-- STRAT:: Organization Schema -->
    @include('main.schema.organization')
    <!-- END:: Organization Schema -->


    <!-- STRAT:: Article Schema -->
    @include('main.schema.article', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: Article Schema -->
    @include('main.schema.creativeworkseries', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: Product Schema -->
    @php
        $lowPrice   = 0;
        $highPrice  = 0;
        foreach($item->prices as $price){
            if($price->price>$highPrice) $highPrice = $price->price;
            if($price->price<$lowPrice||$lowPrice==0) $lowPrice = $price->price;
        }
    @endphp
    @include('main.schema.product', ['item' => $item, 'lowPrice' => $lowPrice, 'highPrice' => $highPrice])
    <!-- END:: Product Schema -->

    <!-- STRAT:: FAQ Schema -->
    @include('main.schema.faq', ['data' => $item->faqs])
    <!-- END:: FAQ Schema -->
<!-- ===== END:: SCHEMA ===== -->
@endpush
@section('content')
    {{-- <div style="overflow:hidden;"> --}}
        <!-- === START:: Header Top === -->
        @include('main.snippets.headerTop')
        <!-- === END:: Header Top === -->

        <!-- === START:: Header Main === -->
        @include('main.cacheHTML.create', [
            'content'   => 'main.snippets.headerMain'
        ])
        <!-- === END:: Header Main === -->
        
        @include('main.template.breadcrumb', compact('breadcrumb'))

        <div class="contentBox">
            <!-- Gallery và Product detail -->
            @include('main.product.gallery')
        </div>
    {{-- </div> --}}
@endsection
@push('modal')

@endpush
@push('bottom')
    <!-- === START:: Zalo Ring === -->
    {{-- @include('main.snippets.zaloRing') --}}
    <!-- === END:: Zalo Ring === -->
@endpush
@push('scriptCustom')
    <script type="text/javascript">
        $(window).ready(function(){
            setOptionProduct();
        })
        /* thay đổi option sản phẩm */
        function setOptionProduct(){
            var data    =  window.location.search;
            $.ajax({
                url         : '{{ route("ajax.setOptionProduct") }}',
                type        : 'get',
                dataType    : 'html',
                data        : data,
                success     : function(response){
                    if(response!=0){
                        /* ========= xử lý của button && phần hiển thị giá */
                        $(document).find('[data-product_price_id='+response+']').each(function(){
                            /* xóa hết selected của button */
                            $(this).parent().children().each(function(){
                                $(this).removeClass('selected');
                            })
                            /* bật lại element được chọn cho button */
                            $(this).addClass('selected');
                        });
                    }
                    console.log(response);
                }
            });
        }
    </script>
@endpush