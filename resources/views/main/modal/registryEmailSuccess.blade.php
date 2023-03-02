<div id="modalRegistryEmailSuccess" class="modalBox">
    <div class="modalBox_bg js_toggleModalWebsite"></div>
    <div class="modalBox_box">
        <div class="modalBox_box_head">
            Thông báo thành công!
        </div>
        <div class="modalBox_box_body">
            <div>Cảm ơn bạn đã đăng ký nhận tin!</div>
            <div>Trong thời gian tới nếu có bất kỳ chương trình khuyến mãi nào {{ config('main.company_name') }} sẽ gửi cho bạn đầu tiên.</div>
        </div>
    </div>
</div>
@push('scriptCustom')
    <script type="text/javascript">
        $('.js_toggleModalWebsite').on('click', function(){
            openCloseModal('modalRegistryEmailSuccess');
        })
    </script>
@endpush