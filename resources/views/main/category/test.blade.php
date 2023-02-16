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
                        <div><span class="highLight">{{ $products->count() }}</span> sản phẩm</div>
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
                </div>

            </div>
            <div class="categoryWithFilterBox_filter">

                @include('main.template.filter', [
                    'categoryChilds'    => $item->childs,
                    'brands'            => $brands
                ])

            </div>
        </div>

    </div>
</div>