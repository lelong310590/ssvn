<h2 class="txt-title">Thông tin mua hàng</h2>
<form class="box-form-default">
    <div class="form-info-user">
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group">
                    <label>Email <span class="red">*</span></label>
                    <input type="email" class="txt-form" value="{{ $user->email }}" disabled>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group {{ $user->first_name?'checked':'' }}">
                    <label>Họ và Tên <span class="red">*</span></label>
                    <input type="text" class="txt-form" value="{{ $user->first_name }}" name="first_name">
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group {{ $user->getDataByKey('phone')?'checked':'' }}">
                    <label>Số điện thoại <span class="red">*</span></label>
                    <input type="text" class="txt-form" value="{{ $user->getDataByKey('phone') }}" name="phone">
                </div>
            </div>
        </div>
    </div>
</form>