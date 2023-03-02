<div id="modalRegistrySeller" class="modalBox">
    <div class="modalBox_bg js_toggleModalRegistrySeller"></div>
    <div class="modalBox_box">
        <form id="formModalSubmit" method="get" style="width:100%;">
            <!-- hidden -->
            <input type="hidden" name="service_info_id" value="1">
            <div class="formModalBox_box_head">Đăng ký phân phối</div>
            <div class="formModalBox_box_body">
                <!-- ===== -->

                <div class="formBox">
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="name">Người nhận</label>
                        <input type="text" id="name" name="name" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                            <label class="inputRequired" for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" value="" onkeyup="validateWhenType(this, 'phone')" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                            <label class="inputRequired" for="address">Địa chỉ</label>
                            <input type="text" id="address" name="address" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="indentify">Số CMND/CCCD</label>
                        <input type="text" id="indentify" name="indentify" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    {{-- <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="province_info_id">Tỉnh thành</label>
                        <select id="province_info_id" name="province_info_id" class="select2" onChange="validateWhenType(this);loadDistrictByIdProvince(this, 'district_info_id');">
                            <option value="0" selected>- Vui lòng chọn -</option>
                        </select>
                    </div> --}}
                </div>

                <!-- ===== -->
            </div>
            <div class="formModalBox_box_footer">
                <div class="formModalBox_box_footer_item button" tabindex="6" onclick="submitForm('formModalSubmit')">
                    Gửi yêu cầu
                </div>
            </div>
        </form>
    </div>
</div>
@push('scriptCustom')
    <script src="{{ asset('sources/admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('sources/admin/app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
    <script type="text/javascript">
        $('.js_toggleModalRegistrySeller').on('click', function(){
            openCloseModal('modalRegistrySeller');
        })
    </script>
@endpush