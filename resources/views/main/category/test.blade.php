<div class="sectionBox">
    <div class="container">
        <h1>Sản phẩm {{ $item->name ?? $item->seo->title ?? null }}</h1>
        <!-- Product Box -->
        <div class="categoryWithFilterBox">
            <div class="categoryWithFilterBox_box">
                <!-- banner -->
                {{-- @include('main.categoryProduct.banner') --}}
                <!-- Sort Box -->
                <div class="sortBox">
                    <div class="sortBox_left">
                        <div><span id="js_filterProduct_count" class="highLight">{{ $products->count() }}</span> sản phẩm</div>
                    </div>
                    <div class="sortBox_right">
                        <div class="sortBox_right_item">
                            <div style="min-width:100px;">Sắp xếp theo:</div>
                            <select style="max-width:100px;">
                                <option>Mặc định</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="productGridFlexBox">
                    @include('main.template.productGrid', compact('products'))
                    @include('main.template.productGridLoading')
                    <div id="js_filterProduct_hidden"></div>
                </div>

            </div>
            <div class="categoryWithFilterBox_filter">

                @include('main.template.filter', [
                    'categories'        => $categories,
                    'brands'            => $brands ?? $item
                ])

            </div>
        </div>

    </div>
</div>
@push('scriptCustom')
    <script type="text/javascript">
        function filterProduct(elementButton, valueFilter){
            /* active button vừa click */
            $(elementButton).parent().children().each(function(){
                $(this).removeClass('selected');
            })
            $(elementButton).addClass('selected');
            /* hiện loading - ẩn child box chính */
            $('.loadingGridBox').css('display', 'flex');
            // $('.loadingGridBox_note').css('display', 'none');
            const parent    = $('#js_filterProduct_show');
            const hidden    = $('#js_filterProduct_hidden');
            parent.children().each(function(){
                $(this).css('display', 'none');
            })
            /* lọc phần tử */
            let data                = [];
            let dataHidden          = [];
            if(valueFilter!="all"){
                $(document).find("[data-filter]").each(function(){
                    const value     = $(this).data('filter');
                    if(value.match(valueFilter)){
                        data.push($(this));
                    }else {
                        dataHidden.push($(this));
                    }
                })
            }else {
                $(document).find("[data-filter]").each(function(){
                    data.push($(this));
                })
            }
            /* ẩn loading - hiện lại kết quả */
            setTimeout(() => {
                /* ẩn loading */
                $('.loadingGridBox').css('display', 'none');
                if(data.length==0){ 
                    /* trường hợp không có phần tử => thông báo */
                    $('.loadingGridBox_note').css('display', 'block');
                }else {
                    /* hiện lại kết quả */
                    parent.html('');
                    for(let i=0;i<data.length;++i){
                        parent.append(data[i].attr('style', '').clone());
                    }
                    hidden.html('');
                    for(let i=0;i<dataHidden.length;++i){
                        hidden.append(dataHidden[i].clone());
                    }
                    /* cập nhật lại count */
                    $('#js_filterProduct_count').html(data.length);
                }
            }, 500);
        }

    </script>
@endpush