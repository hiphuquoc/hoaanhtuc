@php
    $flagHaveBlog = false;
@endphp
@foreach($infoCategoryChilds as $infoCategory)
    @if(!empty($infoCategory->childs)&&$infoCategory->childs->isNotEmpty())
        @php
            $flagHaveBlog   = true;
            $title          = $infoCategory->childs[0]->name ?? $infoCategory->childs[0]->seo->title ?? $infoCategory->childs[0]->seo->seo_title ?? null;
            $image          = !empty($infoCategory->childs[0]->seo->image_small)&&file_exists(Storage::path($infoCategory->childs[0]->seo->image_small)) ? Storage::url($infoCategory->childs[0]->seo->image_small) : config('image.default');
        @endphp
        <div class="blogListLeftRight">
            <div class="blogListLeftRight_title">
                <a href="/{{ $infoCategory->seo->slug_full ?? null }}" title="{{ $infoCategory->name ?? $infoCategory->seo->title ?? null }}"><h2>{{ $infoCategory->name ?? $infoCategory->seo->title ?? null }}</h2></a>
            </div>
            <div class="blogListLeftRight_box">
                <div class="blogListLeftRight_box_left">
                    <a href="/{{ $infoCategory->childs[0]->seo->slug_full ?? null }}" title="{{ $title }}" class="blogListLeftRight_box_left_image">
                        <img src="{{ Storage::url(config('image.loading_main_gif')) }}" data-src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
                    </a>
                    <div class="blogListLeftRight_box_left_content">
                        <a href="/{{ $infoCategory->childs[0]->seo->slug_full ?? null }}" title="{{ $title }}" class="blogListLeftRight_box_left_content_title">
                            <h3 class="maxLine_2">{{ $title }}</h3>
                        </a>
                        @if(!empty($infoCategory->childs[0]->seo->updated_at))
                            <div class="blogListLeftRight_box_left_content_time">
                                <i class="fa-regular fa-calendar-days"></i>{{ date('H:i\, d/m/Y', strtotime($infoCategory->childs[0]->seo->updated_at)) }}
                            </div>
                        @endif
                        <div class="blogListLeftRight_box_left_content_desc maxLine_5">
                            {{ $infoCategory->childs[0]->description ?? $infoCategory->childs[0]->seo->description ?? $infoCategory->childs[0]->seo->seo_description ?? null }}
                        </div>
                    </div>
                </div>
                <div class="blogListLeftRight_box_right">
                    @for($i=1;$i<$infoCategory->childs->count();++$i)
                        @php
                            $image  = !empty($infoCategory->childs[$i]->seo->image_small)&&file_exists(Storage::path($infoCategory->childs[$i]->seo->image_small)) ? Storage::url($infoCategory->childs[$i]->seo->image_small) : config('image.default');
                            $title  = $infoCategory->childs[$i]->name ?? $infoCategory->childs[$i]->seo->title ?? $infoCategory->childs[$i]->seo->seo_title ?? null;
                        @endphp
                        <div class="blogListLeftRight_box_right_item">
                            <a href="/{{ $infoCategory->childs[$i]->seo->slug_full ?? null }}" title="{{ $title }}" class="blogListLeftRight_box_right_item_image">
                                <img src="{{ Storage::url(config('image.loading_main_gif')) }}" data-src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
                            </a>
                            <div class="blogListLeftRight_box_right_item_content">
                                <a href="/{{ $infoCategory->childs[$i]->seo->slug_full ?? null }}" title="{{ $title }}">
                                    <h3 class="maxLine_2">{{ $title }}</h3>
                                </a>
                                @if(!empty($infoCategory->childs[$i]->seo->updated_at))
                                    <div class="blogListLeftRight_box_right_item_content_time">
                                        <i class="fa-regular fa-calendar-days"></i>{{ date('H:i\, d/m/Y', strtotime($infoCategory->childs[$i]->seo->updated_at)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @php
                            if($i==5) break;
                        @endphp
                    @endfor
                </div>
            </div>
            {{-- @if($infoCategory->childs->count()>=6) --}}
                <div class="blogListLeftRight_footer">
                    <div class="blogListLeftRight_footer_text">
                        Chuyên mục {{ $infoCategory->name ?? $infoCategory->seo->title ?? null }} có <span class="highLight">{{ $infoCategory->childs->count() }}</span> bài
                    </div>
                    <a href="/{{ $infoCategory->seo->slug_full ?? null }}" title="{{ $infoCategory->name ?? $infoCategory->seo->title ?? null }}" class="blogListLeftRight_footer_button"><i class="fa-solid fa-arrow-down-long"></i>Xem tất cả</a>
                </div>
            {{-- @endif --}}
        </div>
    @endif
@endforeach
@if($flagHaveBlog==false)
    <div style="color:rgb(0,123,255);">Hiện chưa có bài viết nào trong chuyên mục này!</div>
@endif