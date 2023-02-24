<input type="hidden" id="brand_info_id" name="brand_info_id" value="{{ !empty($item->id)&&$type!='copy' ? $item->id : null }}" />
<div class="formBox">
    <div class="formBox_full">
        <!-- One Row -->
        <div class="formBox_column2_item_row">
            <div class="inputWithNumberChacractor">
                <span data-toggle="tooltip" data-placement="top" title="
                    Đây là Tiêu đề được hiển thị trên website
                ">
                    <i class="explainInput" data-feather='alert-circle'></i>
                    <label class="form-label inputRequired" for="name">Tiêu đề Trang</label>
                </span>
                <div class="inputWithNumberChacractor_count" data-charactor="name">
                    {{ !empty($item->name) ? mb_strlen($item->name) : 0 }}
                </div>
            </div>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $item->name ?? null }}" required>
            <div class="invalid-feedback">{{ config('admin.massage_validate.not_empty') }}</div>
        </div>
        <!-- One Row -->
        <div class="formBox_column2_item_row">
            <div class="inputWithNumberChacractor">
                <span data-toggle="tooltip" data-placement="top" title="
                    Đây là Mô tả được hiển thị trên website
                ">
                    <i class="explainInput" data-feather='alert-circle'></i>
                    <label class="form-label inputRequired" for="description">Mô tả Trang</label>
                </span>
                <div class="inputWithNumberChacractor_count" data-charactor="description">
                    {{ !empty($item->description) ? mb_strlen($item->description) : 0 }}
                </div>
            </div>
            <textarea class="form-control" id="description"  name="description" rows="5" required>{{ old('description') ?? $item->description ?? null }}</textarea>
            <div class="invalid-feedback">{{ config('admin.massage_validate.not_empty') }}</div>
        </div>
        <!-- One Row -->
        <div class="formBox_full_item">
            <span data-toggle="tooltip" data-placement="top" title="
                Nhập vào một số để thể hiện độ ưu tiên khi hiển thị cùng các Category khác (Số càng nhỏ càng ưu tiên cao - Để trống tức là không ưu tiên)
            ">
                <i class="explainInput" data-feather='alert-circle'></i>
                <label class="form-label" for="ordering">Thứ tự</label>
            </span>
            <input type="number" min="0" id="ordering" class="form-control" name="ordering" value="{{ old('ordering') ?? $item->seo->ordering ?? '' }}">
        </div>
        {{-- <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label inputRequired" for="location">Điểm đến Tour</label>
            <select class="select2 form-select select2-hidden-accessible" id="location" name="location[]" multiple="true">
                @if(!empty($tourLocations))
                    @foreach($tourLocations as $location)
                        @php
                            $selected   = null;
                            if(!empty($item->locations)){
                                foreach($item->locations as $l) {
                                    if(!empty($l['tour_location_id'])&&$l['tour_location_id']==$location['id']) {
                                        $selected = ' selected';
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <option value="{{ $location['id'] }}"{{ $selected }}>{{ $location['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label inputRequired" for="tour_departure_id">Điểm khởi hành</label>
            <select class="select2 form-select select2-hidden-accessible" id="tour_departure_id" name="tour_departure_id">
                <option value="0">- Lựa chọn -</option>
                @if(!empty($tourDepartures))
                    @foreach($tourDepartures as $departure)
                        @php
                            $selected   = null;
                            if(!empty($item->tour_departure_id)&&$item->tour_departure_id==$departure->id) $selected = 'selected';
                        @endphp
                        <option value="{{ $departure['id'] }}"{{ $selected }}>{{ $departure['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label inputRequired" for="staff">Nhân viên tư vấn</label>
            <select class="select2 form-select select2-hidden-accessible" id="staff" name="staff[]" multiple="true">
                <option value="0">- Lựa chọn -</option>
                @if(!empty($staffs))
                    @foreach($staffs as $staff)
                        @php
                            $selected   = null;
                            if(!empty($item->staffs)){
                                foreach($item->staffs as $s) {
                                    if(!empty($s['staff_info_id'])&&$s['staff_info_id']==$staff['id']) {
                                        $selected = ' selected';
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <option value="{{ $staff['id'] }}"{{ $selected }}>{{ $staff['firstname'] }} {{ $staff['lastname'] }} ({{ $staff['prefix_name'] }}. {{ $staff['lastname'] }})</option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- One Row -->
        <div class="formBox_full_item">
            <label class="form-label inputRequired" for="partner">Đối tác cung cấp</label>
            <select class="select2 form-select select2-hidden-accessible" id="partner" name="partner[]" multiple="true">
                @if(!empty($partners))
                    @foreach($partners as $partner)
                        @php
                            $selected   = null;
                            if(!empty($item->partners)){
                                foreach($item->partners as $p) {
                                    if(!empty($p['partner_info_id'])&&$p['partner_info_id']==$partner['id']) {
                                        $selected = ' selected';
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <option value="{{ $partner['id'] }}"{{ $selected }}>{{ $partner['company_name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div> --}}
    </div>
</div>

@push('scripts-custom')
    <script type="text/javascript">
        

    </script>

@endpush