<input type="hidden" name="blog_info_id" value="{{ !empty($item->id)&&$type=='edit' ? $item->id : null }}" />

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
        <div class="formBox_column2_item_row">
            <span data-toggle="tooltip" data-placement="top" title="
                Nhập vào một số để thể hiện độ ưu tiên khi hiển thị cùng các Category khác (Số càng nhỏ càng ưu tiên cao - Để trống tức là không ưu tiên)
            ">
                <i class="explainInput" data-feather='alert-circle'></i>
                <label class="form-label" for="ordering">Thứ tự</label>
            </span>
            <input type="number" min="0" id="ordering" class="form-control" name="ordering" value="{{ old('ordering') ?? $item->seo['ordering'] ?? '' }}">
        </div>
        <!-- One Row -->
        <div class="formBox_column2_item_row">
            <span data-toggle="tooltip" data-placement="top" title="
                Bài viết này thuộc về các Category nào?
            ">
                <i class="explainInput" data-feather='alert-circle'></i>
                <label class="form-label" for="category_blog_info_id">Category</label>
            </span>
            <select class="select2 form-select select2-hidden-accessible" id="category_blog_info_id" name="category_blog_info_id[]" aria-hidden="true" multiple="true">
                @if(!empty($parents))
                    @foreach($parents as $c)
                        @php
                            $selected       = null;
                            if(!empty($item->categories)&&$item->categories->isNotEmpty()){
                                foreach($item->categories as $cActive){
                                    if($c->id==$cActive->infoCategory->id) {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <option value="{{ $c->id }}" {{ $selected }}>{{ $c->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- One Row -->
        <div class="formBox_column2_item_row">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" id="outstanding" name="outstanding" {{ !empty($item->outstanding) ? 'checked' : null }}>
                <label class="form-check-label" for="outstanding">Đánh dấu đây là bài viết nổi bật</label>
            </div>
        </div>
    </div>
</div>