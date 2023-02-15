@php
    $titlePage      = 'Thêm Sản phẩm mới';
    $submit         = 'admin.product.create';
    $checkImage     = 'required';
    if(!empty($type)&&$type=='edit'){
        $titlePage  = 'Chỉnh sửa Sản phẩm';
        $submit     = 'admin.product.update';
        $checkImage = null;
    }
@endphp

<form id="formAction" class="needs-validation invalid" action="{{ route($submit) }}" method="POST" novalidate enctype="multipart/form-data">
    @csrf
        <div class="pageAdminWithRightSidebar withRightSidebar">
            <div class="pageAdminWithRightSidebar_header">
                {{ $titlePage }}
            </div>
            <!-- Error -->
            @if ($errors->any())
                <ul class="errorList">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <!-- MESSAGE -->
            @include('admin.template.messageAction')
            
            <div class="pageAdminWithRightSidebar_main">
                <!-- START:: Main content -->
                <div class="pageAdminWithRightSidebar_main_content">
                    <div class="pageAdminWithRightSidebar_main_content_item">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Thông tin trang</h4>
                            </div>
                            <div class="card-body">

                                @include('admin.product.formPage')

                            </div>
                        </div>
                    </div>
                    <div class="pageAdminWithRightSidebar_main_content_item">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Thông tin SEO</h4>
                            </div>
                            <div class="card-body">

                                @include('admin.form.formSeo')
                                
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    @if(!empty(old('contents'))||!empty($item->contents))
                        <div class="pageAdminWithRightSidebar_main_content_item repeater">
                            <div data-repeater-list="contents">
                                @php
                                    $contents = old('contents') ?? $item->contents;
                                @endphp
                                @foreach($contents as $content)
                                    <div class="card" data-repeater-item>
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">
                                                Nội dung sản phẩm
                                                <i class="fa-solid fa-circle-xmark" data-repeater-delete></i>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                
                                            @include('admin.product.formContent', compact('content'))
                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card">
                                <button class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" aria-label="Thêm" data-repeater-create>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Thêm</span>
                                </button>
                            </div>
                        </div>
                    @else 
                        <div class="pageAdminWithRightSidebar_main_content_item repeater">
                            <div data-repeater-list="contents">
                                <div class="card" data-repeater-item>
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">
                                            Nội dung sản phẩm
                                            <i class="fa-solid fa-circle-xmark" data-repeater-delete></i>
                                        </h4>
                                    </div>
                                    <div class="card-body">
            
                                        @include('admin.product.formContent')
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <button class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" aria-label="Thêm" data-repeater-create>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Thêm</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <!-- Price -->
                    @php
                        $dataPrices = old('prices') ?? null;
                        if(!empty($item->prices)&&$item->prices->isNotEmpty()) $dataPrices = $item->prices;
                    @endphp
                    @if(!empty($dataPrices)&&$type!='copy')
                        <div class="pageAdminWithRightSidebar_main_content_item repeater">
                            <div data-repeater-list="prices">
                                @php
                                    $prices = old('prices') ?? $item->prices;
                                @endphp
                                <!-- đây là bản trống để copy ra -->
                                <div style="display:none;">
                                    <div class="card" data-repeater-item>
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">
                                                Phiên bản của sản phẩm
                                                <i class="fa-solid fa-circle-xmark" data-repeater-delete></i>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                
                                            @include('admin.product.formPrice', ['price' => null])
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- end:: đây là bản trống để copy ra -->
                                @foreach($prices as $price)
                                    <div class="card" data-repeater-item>
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">
                                                Phiên bản của sản phẩm
                                                <i class="fa-solid fa-circle-xmark" data-repeater-delete></i>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                
                                            @include('admin.product.formPrice', compact('item', 'price'))
                                            
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                            <div class="card">
                                <button class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" aria-label="Thêm" data-repeater-create>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Thêm</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="pageAdminWithRightSidebar_main_content_item repeater">
                            <div data-repeater-list="prices">
                                <div class="card" data-repeater-item>
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">
                                            Phiên bản của sản phẩm
                                            <i class="fa-solid fa-circle-xmark" data-repeater-delete></i>
                                        </h4>
                                    </div>
                                    <div class="card-body">
            
                                        @include('admin.product.formPrice')
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <button class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" aria-label="Thêm" data-repeater-create>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Thêm</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- END:: Main content -->

                <!-- START:: Sidebar content -->
                <div class="pageAdminWithRightSidebar_main_rightSidebar">
                    <!-- Button Save -->
                    <div class="pageAdminWithRightSidebar_main_rightSidebar_item buttonAction" style="padding-bottom:1rem;">
                        <a href="{{ route('admin.product.list') }}" type="button" class="btn btn-secondary waves-effect waves-float waves-light">Quay lại</a>
                        <button type="submit" class="btn btn-success waves-effect waves-float waves-light" onClick="javascript:submitForm('formAction');" style="width:100px;" aria-label="Lưu">Lưu</button>
                    </div>
                    <div class="customScrollBar-y" style="height: calc(100% - 70px);border-top: 1px dashed #adb5bd;">
                        <!-- Form Upload -->
                        <div class="pageAdminWithRightSidebar_main_rightSidebar_item">
                            @include('admin.form.formImage')
                        </div>
                        <!-- Form Slider -->
                        <div class="pageAdminWithRightSidebar_main_rightSidebar_item">
                            @include('admin.form.formSlider')
                        </div>
                        {{-- <!-- Form Gallery -->
                        <div class="pageAdminWithRightSidebar_main_rightSidebar_item">
                            @include('admin.form.formGallery')
                        </div> --}}
                    </div>
                </div>
                <!-- END:: Sidebar content -->
            </div>
        </div>

</form>

@push('scriptCustom')
    <script type="text/javascript">
        $('.repeater').repeater();

    </script>
@endpush