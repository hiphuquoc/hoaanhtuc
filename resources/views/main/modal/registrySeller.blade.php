@php
    $provinces      = \App\Models\Province::all();
@endphp

<div id="modalRegistrySeller" class="modalBox">
    <div class="modalBox_bg js_toggleModalRegistrySeller"></div>
    <div class="modalBox_box">
        <form id="formModalSubmit" method="get" style="width:100%;">
            <!-- hidden -->
            <div class="formModalBox_box_head">Đăng ký phân phối</div>
            <div class="formModalBox_box_body">
                <!-- ===== -->
                <div class="formBox">
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="name">Họ tên</label>
                        <input type="text" id="name" name="name" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="phone">Số điện thoại</label>
                        <input type="text" id="phone" name="phone" value="" onkeyup="validateWhenType(this, 'phone')" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="indentify">Số CMND/CCCD</label>
                        <input type="text" id="indentify" name="indentify" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="address">Địa chỉ</label>
                        <input type="text" id="address" name="address" value="" onkeyup="validateWhenType(this)" required>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="province_info_id">Tỉnh thành</label>
                        <select id="province_info_id" name="province_info_id" class="select2" onChange="validateWhenType(this);loadDistrictByIdProvince(this, 'district_info_id');" required>
                            <option value="0" selected>- Vui lòng chọn -</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="formBox_item inputWithLabelInside">
                        <label class="inputRequired" for="district_info_id">Quận huyện</label>
                        <select id="district_info_id" name="district_info_id" class="select2" onChange="validateWhenType(this)" required>
                            <option value="0" selected>- Vui lòng chọn -</option>
                        </select>
                    </div>
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
        function submitForm(idForm){
            event.preventDefault();
            const error     = validateForm(idForm);
            if(error==''){
                const data  = $('#'+idForm).serialize();
                $.ajax({
                    url         : '{{ route("ajax.registrySeller") }}',
                    type        : 'get',
                    dataType    : 'json',
                    data        : data,
                    success     : function(response){
                        /* tắt modal form đăng ký */
                        openCloseModal('modalRegistrySeller');
                        /* bật thông báo */
                        setMessageModal(response.title, response.content);
                    }
                });
            }else {
                /* thêm class thông báo lỗi cho label của input */
                for(let i = 0;i<error.length;++i){
                    const idInput = $('#'+idForm).find('[name='+error[i]+']').attr('id');
                    if(idInput!=''){
                        const elementLabel = $('#'+idForm).find('[for='+idInput+']');
                        elementLabel.addClass('error');
                    }
                }
            }
        }
        
    </script>
@endpush