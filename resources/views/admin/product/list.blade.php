@extends('layouts.admin')
@section('content')

<div class="titlePage">Danh sách yêu cầu</div>

@include('admin.product.search', compact('list', 'brands', 'categories'))

<div class="card">
    <!-- ===== Table ===== -->
    <div class="table-responsive">
        <table class="table table-bordered" style="min-width:900px;">
            <thead>
                <tr>
                    <th style="width:60px;"></th>
                    <th class="text-center">Thông tin</th>
                    <th class="text-center" style="width:320px;">Giá</th>
                    <th class="text-center" width="60px">-</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($list)&&$list->isNotEmpty())
                    @foreach($list as $item)
                        <tr id="item_{{ $item->id }}">
                            <td class="text-center">{{ ($loop->index + 1) }}</td>
                            <td>
                                <div class="oneLine">
                                    <strong>Tiêu đề:</strong> {{ $item->name ?? $item->seo->title ?? null }}
                                </div>
                                <div class="oneLine">
                                    <strong>Dường dẫn tĩnh:</strong> {{ $item->seo->slug_full }}
                                </div>
                                @if(!empty($item->categories))
                                    <div class="onLine" style="margin-top:0.25rem;">
                                        @php
                                            $xhtmlCategory          = null;
                                            foreach($item->categories as $category){
                                                if(!empty($category->infoCategory->name)) $xhtmlCategory  .= '<div class="badge bg-primary" style="margin-left:0.25rem;">'.$category->infoCategory->name.'</div>';
                                            }
                                        @endphp 
                                        <strong>Danh mục:</strong> {!! $xhtmlCategory !!}
                                    </div>
                                @endif
                                <div class="onLine" style="margin-top:0.25rem;">
                                    <strong>Nhãn hàng:</strong> <div class="badge bg-success">{{ $item->brand->name }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="priceProductBox">
                                    @foreach($item->prices as $price)
                                        <div class="priceProductBox_item">
                                            <div class="priceProductBox_item_image">
                                                @if(!empty($price->files[0]->file_path)&&file_exists(Storage::path($price->files[0]->file_path)))
                                                    <img src="{{  Storage::url($price->files[0]->file_path) }}" />
                                                    @if($price->files->count()>1)
                                                        <div class="priceProductBox_item_image_count">{{ $price->files->count() }}</div>
                                                    @endif
                                                @else 
                                                    <img src="{{  config('image.default_square') }}" />
                                                @endif
                                            </div>
                                            <div class="priceProductBox_item_content">
                                                <div><span class="highLight">{{ number_format($price->price) }}</span> /{{ $price->name }}</div>
                                                <div>Lợi nhuận: <b>{{ number_format($price->price - $price->price_origin) }}</b></div>
                                                @if(!empty($price->sale_off))
                                                    <div>Khuyến mãi <span class="saleOff">-{{ $price->sale_off }}%</span></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td style="vertical-align:top;display:flex;font-size:0.95rem;">
                                <div class="icon-wrapper iconAction">
                                    <a href="/{{ $item->seo->slug_full }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <div>Xem</div>
                                    </a>
                                </div>
                                <div class="icon-wrapper iconAction">
                                    <a href="{{ route('admin.product.view', ['id' => $item->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        <div>Sửa</div>
                                    </a>
                                </div>
                                <div class="icon-wrapper iconAction">
                                    <a href="{{ route('admin.product.view', ['id' => $item->id, 'type' => 'copy']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        <div>Chép</div>
                                    </a>
                                </div>
                                <div class="icon-wrapper iconAction">
                                    <div class="actionDelete" onclick="deleteItem({{ $item->id }});">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                        </svg>
                                        <div>Xóa</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5">Không có dữ liệu phù hợp!</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    {{ !empty($list&&$list->isNotEmpty()) ? $list->appends(request()->query())->links('admin.template.paginate') : '' }}
</div>

<!-- Nút thêm -->
<a href="{{ route('admin.product.view') }}" class="addItemBox">
    <i class="fa-regular fa-plus"></i>
    <span>Thêm</span>
</a>
    
@endsection
@push('scriptCustom')
    <script type="text/javascript">
        function deleteItem(id){
            if(confirm('{{ config("admin.alert.confirmRemove") }}')) {
                $.ajax({
                    url         : "{{ route('admin.product.delete') }}",
                    type        : "GET",
                    dataType    : "html",
                    data        : { id : id }
                }).done(function(data){
                    if(data==true) $('#item_'+id).remove();
                });
            }
        }

        function submitForm(idForm){
            $('#'+idForm).submit();
        }
    </script>
@endpush