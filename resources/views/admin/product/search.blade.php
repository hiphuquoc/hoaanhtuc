<form id="formSearch" method="get" action="{{ route('admin.product.list') }}">
    <div class="searchBox">
        <div class="searchBox_item">
            <div class="input-group">
                <input type="text" class="form-control" name="search_name" placeholder="Tìm theo tên" value="{{ $params['search_name'] ?? null }}">
                <button class="btn btn-primary waves-effect" id="button-addon2" type="submit" aria-label="Tìm">Tìm</button>
            </div>
        </div>
        @if(!empty($brands))
            <div class="searchBox_item">
                <div class="position-relative">
                    <select class="form-select select2 select2-hidden-accessible" name="search_brand" onchange="submitForm('formSearch');" aria-hidden="true">
                        <option value="0">- Tìm theo Nhãn hàng -</option>
                        @foreach($brands as $brand)
                            @php
                                $selected = null;
                                if(!empty($params['search_brand'])&&$params['search_brand']==$brand->id) $selected = ' selected';
                            @endphp
                            <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        @if(!empty($categories))
            <div class="searchBox_item">
                <div class="position-relative">
                    <select class="form-select select2 select2-hidden-accessible" name="search_category" onchange="submitForm('formSearch');" aria-hidden="true">
                        <option value="0">- Tìm theo Danh mục -</option>
                        @foreach($categories as $category)
                            @php
                                $selected = null;
                                if(!empty($params['search_category'])&&$params['search_category']==$category->id) $selected = ' selected';
                            @endphp
                            <option value="{{ $category->id }}" {{ $selected }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="searchBox_item" style="margin-left:auto;text-align:right;">
            @php
                $xhtmlSettingView   = \App\Helpers\Setting::settingView('viewProductInfo', [20, 50, 100, 200, 500], $viewPerPage, $list->total());
                echo $xhtmlSettingView;
            @endphp
        </div>
    </div>
</form>