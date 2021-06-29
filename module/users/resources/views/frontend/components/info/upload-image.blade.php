<div class="box-upload-images">
    <p>Xem trước hình ảnh</p>
    <div class="box-show-images text-center">
        <div class="img">
            <div class="main-img">
                <img src="{{ asset($data->$name) }}" alt="" width="" height="" class="{{ $name }}_image">
            </div>
        </div>
        <p class="note">Hình ảnh của bạn phải ở tối thiểu 200x200 pixel và tối đa 6000x6000 pixel.</p>
    </div>
    <div class="box-btn-upload">
        <p class="pull-left">Thêm / Thay đổi hình ảnh</p>
        <div class="overflow">
            <div class="btn-upload">
                <input type="file" class="{{ $name }}_value" value="{{ $data->$name }}">
                <span>Không có tập tin nào được chọn</span>
            </div>
            <a href="javascript:void(0)" class="btn btn-default-yellow" onclick="return $('.box-upload-images .box-btn-upload .overflow .btn-upload input').click();">Upload</a>
        </div>
    </div>
</div>