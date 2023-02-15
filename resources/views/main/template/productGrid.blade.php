@if(!empty($products)&&$products->isNotEmpty())
    <div class="productGridBox">
        @foreach($products as $product)
            @php
                $allImage           = new \Illuminate\Database\Eloquent\Collection;
                $i                  = 0;
                foreach($product->prices as $price){
                    foreach($price->files as $file){
                        $allImage[$i]       = $file;
                        ++$i;
                    }
                }
                $productName        = $product->name ?? $product->seo->title ?? null;
            @endphp 
            <div class="productGridBox_item">
                @php
                    $i = 0;
                @endphp
                @foreach($product->prices as $price)
                    @foreach($price->files as $file)
                        <!-- one price && file -->
                        @php
                            $keyIdPrice = 'js_changeOption_'.$price->id.$file->id;
                        @endphp
                        <div id="{{ $keyIdPrice }}" class="{{ $i==0 ? 'show' : 'hide' }}">
                            <a href="/{{ $product->seo->slug_full }}?product_price_id={{ $price->id }}" class="productGridBox_item_image">
                                <!-- ảnh -->
                                <img src="{{ Storage::url($file->file_path) }}" alt="{{ $productName }}" title="{{ $productName }}" />
                                <!-- rating và số lượng đã bán -->
                                <div class="productGridBox_item_image_rating">
                                    @if(!empty($product->seo->rating_aggregate_star))
                                        <div><img src="{{ Storage::url('images/svg/icon_star.svg') }}" alt="đánh giá sản phẩm {{ $productName }}" title="đánh giá sản phẩm {{ $productName }}" />{{ $product->seo->rating_aggregate_star }}</div>
                                    @endif
                                    @if(!empty($product->sold))
                                        <div>Đã bán {{ $product->sold }}</div>
                                    @endif
                                </div>
                                <!-- icon giảm giá -->
                                @if(!empty($price->sale_off))
                                    <div class="productGridBox_item_image_percent">- {{ $price->sale_off }}%</div>
                                @endif
                            </a>
                            <!-- danh sách ảnh -->
                            <div class="productGridBox_item_imageList">
                                @foreach($allImage as $image)
                                    @php
                                        $keyIdFile  = 'js_changeOption_'.$image->attachment_id.$image->id;
                                        $selected   = null;
                                        if($keyIdPrice==$keyIdFile) $selected = 'selected';
                                        if($loop->index==5) break;
                                    @endphp
                                    <div class="productGridBox_item_imageList_item {{ $selected }}" onClick="changeOption('{{ $keyIdFile }}');">
                                        <img src="{{ Storage::url($image->file_path) }}" alt="{{ $productName }}" title="{{ $productName }}" />
                                    </div>
                                @endforeach
                            </div>
                            <!-- content -->
                            <div class="productGridBox_item_content">
                                <a href="/{{ $product->seo->slug_full }}?product_price_id={{ $price->id }}" class="productGridBox_item_content_title maxLine_2">
                                    <h3>{{ $productName }}</h3>
                                </a>
                                <div class="productGridBox_item_content_price">
                                    <!-- giá -->
                                    <div>{!! number_format($price->price).config('main.currency_unit') !!}</div>
                                    <!-- giá trước khuyến mãi -->
                                    @if(!empty($price->price!=$price->price_before_promotion))
                                        <span class="maxLine_1">{{ number_format($price->price_before_promotion) }}{!! config('main.currency_unit') !!}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            ++$i;
                        @endphp
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
@else 
    <div>Không có sản phẩm phù hợp!</div>
@endif