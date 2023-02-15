<div id="navMobile">
    <div class="navMobile">
        <div class="navMobile_bg" onClick="toggleMenuMobile('navMobile')"></div>
        <div class="navMobile_main customScrollBar-y">
            <div class="navMobile_main__exit" onClick="toggleMenuMobile('navMobile')">
                <i class="fas fa-times"></i>
            </div>
            <a href="/" title="Trang chủ Hitour" style="display:flex;justify-content:center;margin-bottom:1rem;">
                <div class="logoSquare"></div>
            </a>
            <ul>
                <li>
                    <a href="/" title="Trang chủ Hitour">
                        <div><i class="fas fa-home"></i>Trang chủ</div>
                        <div class="right-icon"></div>
                    </a>
                </li>
                <li>
                    <a href="/" title="Thiết kế Website {{ env('LOCAL_VN') }}" aria-label="Thiết kế Website {{ env('LOCAL_VN') }}">
                        <i class="fa-solid fa-code"></i>
                        <div>Thiết kế Website</div>
                    </a>
                </li>
                <li>
                    <a href="/cham-soc-website-{{ env('LOCAL_URL') }}" title="Chăm sóc Website {{ env('LOCAL_VN') }}" aria-label="Chăm sóc Website {{ env('LOCAL_VN') }}">
                        <i class="fa-brands fa-pagelines"></i>
                        <div>Chăm sóc Website</div>
                    </a>
                </li>
                <li>
                    <div class="js_toggleModalLogin" onClick="toggleMenuMobile('navMobile')">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <div>Đăng nhập hệ thống Cộng tác viên</div>
                    </div>
                </li>
                {{-- <li>
                    <a href="/lien-he-hitour" title="Liên hệ Hitour">
                        <i class="fa-solid fa-phone"></i>
                        <div>Liên hệ</div>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>