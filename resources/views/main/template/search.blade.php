<form method="get" action="{{ route('main.searchProduct') }}">
    <div class="searchViewBefore">
        <div class="searchViewBefore_input">
            <input id="searchProductAjax_input" type="text" name="key_search" placeholder="Tìm kiếm" value="{{ request('key_search') ?? null }}" onkeyup="searchProductAjax(this)" autocomplete="off" />
            <button type="submit" class="button"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div id="js_searchProductAjax_idWrite" class="searchViewBefore_selectbox">
            <div class="searchViewBefore_selectbox_item">
                <div>
                    <img src="/storage/images/svg/icon-search-100.png" alt="" title="" style="width:120px;margin:0 auto;" />
                    <div>Nhập tìm kiếm của bạn!</div>
                </div>
            </div>
        </div>
    </div>
</form>
@push('scriptCustom')
    <script type="text/javascript">
        $(window).ready(function(){
            searchProductAjax($('#searchProductAjax_input'));
        })
        /* tìm kiếm sản phẩm ajax */
        function searchProductAjax(elementButton){
            const valueElement = $(elementButton).val();
            $.ajax({
                url         : '{{ route("ajax.searchProductAjax") }}',
                type        : 'get',
                dataType    : 'html',
                data        : {
                    key_search  : valueElement
                },
                success     : function(response){
                    if(response!='') $('#js_searchProductAjax_idWrite').html(response);
                }
            });
        }

    </script>
@endpush