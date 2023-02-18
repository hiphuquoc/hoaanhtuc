<div id="modalRegistryEmailSuccess" class="modalSuccess">
    <div class="modalSuccess_bg js_toggleModalWebsite"></div>
    <div class="modalSuccess_box">
        <div class="modalSuccess_box_head">
            Thông báo thành công!
        </div>
        <div class="modalSuccess_box_body">
            <div>Cảm ơn bạn đã đăng ký nhận tin!</div>
            <div>Trong thời gian tới nếu có bất kỳ chương trình khuyến mãi nào chúng tôi sẽ gửi cho bạn đầu tiên.</div>
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