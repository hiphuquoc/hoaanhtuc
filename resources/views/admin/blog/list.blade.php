@extends('layouts.admin')
@section('content')

<div class="titlePage">Danh sách Bài viết</div>
<!-- ===== START: SEARCH FORM ===== -->
<form id="formSearch" method="get" action="{{ route('admin.blog.list') }}">
    <div class="searchBox">
        <div class="searchBox_item">
            <div class="input-group">
                <input type="text" class="form-control" name="search_name" placeholder="Tìm theo tên" value="{{ $params['search_name'] ?? null }}">
                <button class="btn btn-primary waves-effect" id="button-addon2" type="submit" aria-label="Tìm">Tìm</button>
            </div>
        </div>
        @if(!empty($categories))
            <div class="searchBox_item">
                <select class="form-select select2" name="search_category" onChange="submitForm('formSearch');">
                    <option value="0">- Tìm theo Chuyên mục -</option>
                    @foreach($categories as $category)
                        @php
                            $selected   = null;
                            if(!empty($params['search_category'])&&$params['search_category']==$category->id) $selected = 'selected';
                        @endphp
                        <option value="{{ $category->id }}" {{ $selected }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="searchBox_item" style="margin-left:auto;text-align:right;">
            @php
                $xhtmlSettingView   = \App\Helpers\Setting::settingView('viewBlogInfo', [20, 50, 100, 200, 500], $viewPerPage, $list->total());
                echo $xhtmlSettingView;
            @endphp
        </div>
    </div>
</form>
<!-- ===== END: SEARCH FORM ===== -->
<div class="card">
    <!-- ===== Table ===== -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:60px;"></th>
                    <th style="width:150px;">Ảnh</th>
                    <th class="text-center">Thông tin</th>
                    <th class="text-center" style="width:230px;">Khác</th>
                    <th class="text-center" width="60px">-</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($list)&&$list->isNotEmpty())
                    @foreach($list as $item)
                        @include('admin.blog.row', [
                            'item'  => $item, 
                            'idRow' => \App\Helpers\Charactor::randomString(10),
                            'no'    => $loop->index + 1
                        ])
                    @endforeach
                @else 
                    <tr><td colspan="5">Không có dữ liệu phù hợp!</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    {{ !empty($list&&$list->isNotEmpty()) ? $list->appends(request()->query())->links('admin.template.paginate') : '' }}
</div>
<!-- Nút thêm -->
<a href="{{ route('admin.blog.view') }}" class="addItemBox">
    <i class="fa-regular fa-plus"></i>
    <span>Thêm</span>
</a>
    
@endsection
@push('scriptCustom')
    <script type="text/javascript">
        function deleteItem(id, idRow){
            if(confirm('{{ config("admin.alert.confirmRemove") }}')) {
                $.ajax({
                    url         : '{{ route("admin.blog.delete") }}',
                    type        : 'GET',
                    dataType    : 'html',
                    data        : { id : id }
                }).done(function(data){
                    if(data==true) $('#'+idRow).remove();
                });
            }
        }
        function submitForm(idForm){
            $('#'+idForm).submit();
        }
    </script>
@endpush