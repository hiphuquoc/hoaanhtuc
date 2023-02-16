<div class="filterBox">
    <!-- danh mục con -->
    @if(!empty($categories)&&$categories->isNotEmpty())
        <div class="filterBox_item">
            <div class="filterBox_item_title">
                Dòng sản phẩm
            </div>
            <div class="filterBox_item_box">
                <div class="filterBox_item_box_item">
                    @if($categories->count()>1)
                        <span class="badge badgeSecondary selected" onClick="filterProduct(this, 'all')">Tất cả</span>
                    @endif
                    @foreach($categories as $category)
                        @php
                            $selected = $categories->count()>1 ? null : 'selected';
                        @endphp
                        <span class="badge badgeSecondary {{ $selected }}" onClick="filterProduct(this, '{{ $category->seo->slug }}')">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- Nhãn hàng -->
    @if(!empty($brands)&&$brands->isNotEmpty())
        <div class="filterBox_item">
            <div class="filterBox_item_title">
                Nhãn hàng
            </div>
            <div class="filterBox_item_box">
                <div class="filterBox_item_box_item">
                    @if($brands->count()>1)
                        <span class="badge badgeSecondary selected" onClick="filterProduct(this, 'all')">Tất cả</span>
                    @endif
                    @foreach($brands as $brand)
                        @php
                            $selected = $brands->count()>1 ? null : 'selected';
                        @endphp
                        <span class="badge badgeSecondary {{ $selected }}"  onClick="filterProduct(this, '{{ $brand->seo->slug }}')">{{ $brand->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="filterBox_item">
        <div class="filterBox_item_title">
            Khoảng giá (VNĐ)
        </div>
        <div class="filterBox_item_box">
            <div class="filterBox_item_box_item">
                <div class="listPrice">
                    <div class="listPrice_item checked">Tất cả</div>
                    <div class="listPrice_item">Nhỏ hơn 100,000đ</div>
                    <div class="listPrice_item">Từ 100,000đ - 200,000đ</div>
                    <div class="listPrice_item">Từ 200,000đ - 350,000đ</div>
                    <div class="listPrice_item">Từ 350,000đ - 500,000đ</div>
                    <div class="listPrice_item">Từ 500,000đ - 700,000đ</div>
                    <div class="listPrice_item">Lớn hơn 700,000đ</div>
                </div>
            </div>
        </div>
    </div>
</div>