<div class="searchViewBefore">
    <div class="searchViewBefore_input">
        <input id="searchProductAjax_input" type="text" name="search" placeholder="Tìm kiếm" onkeyup="searchProductAjax(this)" autocomplete="off" />
        <button type="submit" class="button"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div id="js_searchProductAjax_idWrite" class="searchViewBefore_selectbox">
        <div class="searchViewBefore_selectbox_item">
            <div>
                <img src="/storage/images/svg/icon-search-100.png" alt="" title="" style="width:120px;margin:0 auto;" />
                <div>Kết quả tìm kiếm!</div>
            </div>
        </div>
    </div>
</div>
@push('scriptCustom')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     const input         = $('#searchProductAjax_input');
        //     const resultBox     = $('.searchViewBefore_selectbox');
        //     input.on('focus', function() {
        //         resultBox.show();
        //     });
        //     input.on('blur', function() {
        //         resultBox.hide();
        //     });
        // });
        /* tìm kiếm sản phẩm ajax */
        function searchProductAjax(elementButton){
            const valueElement = $(elementButton).val();
            $.ajax({
                url         : '{{ route("ajax.searchProductAjax") }}',
                type        : 'get',
                dataType    : 'html',
                data        : {
                    key     : valueElement
                },
                success     : function(response){
                    $('#js_searchProductAjax_idWrite').html(response);
                }
            });
        }

    </script>
@endpush