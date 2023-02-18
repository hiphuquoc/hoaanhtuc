<div class="sectionBox">
    <div class="container">
        @if(!empty($titlePage))
            <h1 style="display:flex;">
                <div>{{ $titlePage }}</div>
                <!-- từ khóa vừa search -->
                @if(!empty(request('key_search')))
                    <div class="keySearchBadge">
                        <div class="keySearchBadge_item">
                            <a href="{{ route('main.searchProduct') }}" class="keySearchBadge_item_badge">
                                <div>{{ request('key_search') }}</div>
                                <div class="keySearchBadge_item_badge_action"><i class="fa-solid fa-xmark"></i></div>
                            </a>
                        </div>
                    </div>
                @endif
            </h1>
        @else 
            <h1>Sản phẩm {{ $item->name ?? $item->seo->title ?? null }}</h1>
        @endif

        
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