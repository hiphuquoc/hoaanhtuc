@php
    $pagePolicies = \App\Models\Page::select('page_info.*')
                        ->whereHas('type', function($query){
                            $query->where('code', 'policy');
                        })
                        ->with('seo')
                        ->join('seo', 'seo.id', '=', 'page_info.seo_id')
                        ->orderBy('seo.ordering', 'DESC')
                        ->get();
@endphp

<div class="footerBox">
    <div class="container">
        <div class="footerBox_item">
            <div>“Đặt sự hài lòng của khách hàng là ưu tiên số 1 trong mọi suy nghĩ hành động của mình” là sứ mệnh, là triết lý, chiến lược.. luôn cùng {{ config('main.company_name') }} tiến bước</div>
            <div class="registryEmailBox">
                <div class="registryEmailBox_text">
                    Đăng ký nhận thông tin 
                </div>
                <div class="registryEmailBox_input">
                    <input type="text" name="search" placeholder="Email của bạn">
                    <button type="submit" class="button"><i class="fa-solid fa-paper-plane"></i>Gửi</button>
                </div>
            </div>
        </div>
        <div class="footerBox_item">
            <div class="footerBox_item_title">
                Hỗ trợ khách hàng
            </div>
            <div class="footerBox_item_list">
                @foreach($pagePolicies as $page)
                    <a href="{{ env('APP_URL').'/'.$page->seo->slug_full }}" class="footerBox_item_list_item">
                        {{ $page->name ?? $page->seo->title ?? null }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="footerBox_item">
            <div class="footerBox_item_title">
                Về {{ config('main.company_name') }}
            </div>
            <div class="footerBox_item_list">
                <a href="#" class="footerBox_item_list_item">
                    Giới thiệu
                </a>
                <a href="#" class="footerBox_item_list_item">
                    Liên hệ
                </a>
                <a href="#" class="footerBox_item_list_item">
                    Tin tức
                </a>
            </div>
        </div>
        <div class="footerBox_item">
            <div class="footerBox_item_title">
                Thông tin liên hệ
            </div>
            <div class="footerBox_item_list">
                <div class="footerBox_item_list_item">
                    <div>{{ config('main.address') }}</div>
                </div>
                <div class="footerBox_item_list_item hotline">
                    <div class="hotlineBox">
                        <i class="fa-solid fa-phone"></i>
                        <div class="hotlineBox_hotline">{{ config('main.hotline') }}</div>
                    </div>
                </div>
                <div class="footerBox_item_list_item">
                    {{ config('main.email') }}
                </div>
                <div class="footerBox_item_list_item">
                    <img src="{{ Storage::url('images/svg/logo-dang-ky-bo-cong-thuong.png') }}" alt="" title="" style="max-width:150px;margin-top:1rem;" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright">
    <div class="container">
        © 2023 - Bản quyền Website Kiên Giang - Thiết kế và phát triển bởi Phạm Văn Phú!
    </div>
</div>