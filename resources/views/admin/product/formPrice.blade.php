<input type="hidden" name="id" value="{{ $price['id'] ?? null }}" />
<div class="formBox">
    <div class="formBox_full">
        <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label inputRequired" for="name">Tiêu đề</label>
            <input class="form-control" name="name" type="text" value="{{ $price['name'] ?? null }}" required />
        </div>
        <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label" for="description">Mô tả</label>
            <input class="form-control" name="description" type="text" value="{{ $price['description'] ?? null }}" />
        </div>
        <!-- One Row -->
        <div class="flexBox">
            <div class="flexBox_item">
                <div class="formBox_full_item">
                    <label class="form-label inputRequired" for="price_origin">Giá gốc (đại lý)</label>
                    <input class="form-control" name="price_origin" type="number" value="{{ $price['price_origin'] ?? null }}" required />
                </div>
            </div>
            <div class="flexBox_item">
                <div class="formBox_full_item">
                    <label class="form-label" for="price_before_promotion">Giá trước KM</label>
                    <input class="form-control" name="price_before_promotion" type="number" value="{{ $price['price_before_promotion'] ?? null }}" />
                </div>
            </div>
        </div>
        <!-- One Row -->
        <div class="flexBox">
            <div class="flexBox_item">
                <div class="formBox_full_item">
                    <label class="form-label inputRequired" for="price">Giá bán</label>
                    <input class="form-control" name="price" type="number" value="{{ $price['price'] ?? null }}" required />
                </div>
            </div>
            <div class="flexBox_item">
                <div class="formBox_full_item">
                    <span data-toggle="tooltip" data-placement="top" title="Để trống tức là không giới hạn">
                        <i class="explainInput" data-feather='alert-circle'></i>
                        <label class="form-label" for="instock">Số lượng trong kho</label>
                    </span>
                    <input class="form-control" name="instock" type="text" value="{{ $price['instock'] ?? null }}" />
                </div>
            </div>
        </div>
        <!-- One Row -->
        @if(!empty($price['id']))
            <div class="formBox_full_item">
                <label class="form-label" style="margin-right:0.5rem;">Ảnh phiên bản</label>
                <input type="file" name="image" onChange="uploadFileAjax(this, {{ $price['id'] ?? 0 }}, '{{ $item->seo->slug ?? null }}');" multiple />
                <div class="uploadImageBox" style="margin-top:0.5rem;">
                    <div class="uploadImageBox_box js_readURLsCustom_idWrite" style="position:relative;">
                        @if(!empty($price->files)&&$price->files->isNotEmpty())
                            @foreach($price->files as $file)
                                <div id="js_removeGalleryProductPrice_{{ $file->id }}" class="uploadImageBox_box_item">
                                    <img src="{{ Storage::url($file->file_path) }}" />
                                    <div class="uploadImageBox_box_item_icon" onClick="removeGalleryProductPrice({{ $file->id }});"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@pushonce('scriptCustom')
    <script type="text/javascript">

        function uploadFileAjax(input, idProductPrice, slug){
            if(idProductPrice!=0){
                addLoading('js_readURLsCustom_idWrite');
                /* lấy thông tin file */
                const files = $(input)[0].files;
                /* tạo đối tượng FormData */
                const formData = new FormData();
                /* thêm token vào */
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('product_price_id', idProductPrice);
                formData.append('slug', slug);
                for(let i=0;i<files.length;++i){
                    /* thêm từng file vào */
                    formData.append('files[]', files[i]);
                }
                $.ajax({
                    url: '{{ route("admin.product.uploadImageProductPriceAjax") }}',
                    type: 'post',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        setTimeout(() => {
                            /* clear input file */ 
                            $(input).val('');
                            /* tắt loading trước để không nhảy hàng */
                            removeLoading();
                            /* tải bản xem trước */
                            const parent            = $(input).parent();
                            const elementWrite      = parent.find('.js_readURLsCustom_idWrite');
                            for(let i=0;i<data.length;++i){
                                const divDom        = document.createElement("div");
                                divDom.className    = 'uploadImageBox_box_item';
                                divDom.setAttribute('id', 'js_removeGalleryProductPrice_'+data[i].file_id);
                                divDom.innerHTML    = '<img src="'+data[i].file_url+'" /><div class="uploadImageBox_box_item_icon" onClick="removeGalleryProductPrice('+data[i].file_id+');"></div>';
                                elementWrite.append(divDom);
                            };
                        }, 500);
                    }
                });
            }else {
                $(input).val('');
                alert('Vui lòng lưu Phiên bản sản phẩm trước khi upload ảnh!');
            }
            
        }

        function removeGalleryProductPrice(id){
            $.ajax({
                url         : "{{ route('admin.gallery.remove') }}",
                type        : "post",
                dataType    : "html",
                data        : { 
                    '_token'    : '{{ csrf_token() }}',
                    id : id 
                }
            }).done(function(data){
                if(data==true) $('#js_removeGalleryProductPrice_'+id).remove();
            });
        }

    </script>
@endpushonce