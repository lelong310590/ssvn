<h2 class="txt-title">Phương thức thanh toán</h2>
<div class="nav-tab-header">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link active" id="transfer-tab" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="true">
                <span class="icon-check pull-left"><i class="far fa-circle"></i></span>
                <span class="icon pull-left"><i class="fas fa-exchange-alt"></i></span>
                Chuyển khoản ngân hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="atm-tab" data-toggle="tab" href="#atm" role="tab" aria-controls="atm" aria-selected="false">
                <span class="icon-check pull-left"><i class="far fa-circle"></i></span>
                <span class="icon pull-left"><i class="fas fa-credit-card"></i></span>
                Thẻ ATM có internetbanking
            </a>
        </li>
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" id="phone-tab" data-toggle="tab" href="#phone" role="tab" aria-controls="phone" aria-selected="false">--}}
        {{--<span class="icon-check pull-left"><i class="far fa-circle"></i></span>--}}
        {{--<span class="icon pull-left"><i class="fas fa-barcode"></i></span>--}}
        {{--Thẻ cào điện thoại--}}
        {{--</a>--}}
        {{--</li>--}}
        <li class="nav-item">
            <a class="nav-link" id="direct-tab" data-toggle="tab" href="#direct" role="tab" aria-controls="direct" aria-selected="false">
                <span class="icon-check pull-left"><i class="far fa-circle"></i></span>
                <span class="icon pull-left"><i class="fas fa-dollar-sign"></i></span>
                Thanh toán trực tiếp
            </a>
        </li>
    </ul>
</div>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade active in" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
        <div class="tab-transfer">
            <p class="note">Từ 11/4 2013, khi nộp học phí vào tài khoản anticovid, học sinh sẽ được tặng thêm 10% giá trị tiền nạp. Để nộp học phí vào tài khoản của
                anticovid, bạn vui lòng thực hiện các bước sau:</p>
            <div class="box-step">
                <p class="step">Bước 1: Nộp tiền/Chuyển khoản vào tài khoản ngân hàng của anticovid</p>
                <p>1. Tên người thụ hưởng: Công ty cổ phần đầu tư và dịch vụ giao dục</p>
                <p>2. Nội dung chuyển tiền: “Tên đăng nhập (hoặc email) của bạn + số điện thoại của bạn”</p>
                <p>3. Số tài khoản của anticovid.com như sau:</p>
                <ul>
                    <li>• Số tài khoản: 0531 0025 11245 tại <a href="#">Vietcombank</a> - Chi nhánh Thành Công, Hà Nội.</li>
                    <li>• Số tài khoản: 0531 0025 11245 tại <a href="#">VP Bank</a> - Chi nhánh Trung Hòa Nhân Chính, Hà Nội.</li>
                    <li>• Số tài khoản: 0531 0025 11245 tại <a href="#">Agribank</a> - Chi nhánh Trung Yên, Hà Nội.</li>
                </ul>
            </div>
            <div class="box-step">
                <p class="step">Bước 2: hoàn tất thông tin tại Hoàn tất thanh toán</p>
                <p>Nếu có thắc mắc hoặc cần sự trọ giúp, hãy liên hệ với chúng tôi qua đường dây nóng 1900 6933 để được giải đáp.</p>
            </div>
            <div class="box-step box-noti">
                <p class="step">Lưu ý:</p>
                <p>- “Tên đăng nhập của bạn” là tài khoản của bạn tại anticovid.com</p>
                <p>- Trong nội dung chuyển tiền bạn bắt buộc phải điền đầy đủ thông tin “Tên đăng nhập của bạn” để tiền được chuyển đến đúng tài khoản của bạn tại
                    anticovid.com</p>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="atm" role="tabpanel" aria-labelledby="atm-tab">
        <div class="tab-atm">
            <p class="note">Từ 11/4 2013, khi nộp học phí vào tài khoản anticovid, học sinh sẽ được tặng thêm 10% giá trị tiền nạp.</p>
            <div class="box-step">
                <p class="step">Điều kiện: Có thẻ ATM đã đăng ký dịch vụ internet banking.</p>
                <p>anticovid hiện đã hỗ trợ thực hiện thanh toán qua 25 ngân hàng tại Việt Nam</p>
            </div>
            <form class="box-form-default">
                <div class="form-group clearfix form-atm">
                    <span class="pull-left txt-1">Số tiền Cần nạp <span class="red">*</span>:</span>
                    <input type="text" class="txt-form pull-left" value="100.000.000">
                    <span class="pull-left txt-2">Đồng</span>
                    <span class="pull-left txt-3">Tiền sẽ được nạp cho tài khoản: <a href="#"> anticovidteam@gmail.com</a> </span>
                </div>
                <a href="#" class="btn btn-small btn-default-yellow">Nạp tiền</a>
            </form>
        </div>
    </div>
    {{--<div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">--}}
    {{--<div class="tab-phone">--}}
    {{--<form class="box-form-default">--}}
    {{--<div class="form-group row box-form-text">--}}
    {{--<div class="col-xs-6">--}}
    {{--<label class="txt-label text-right">Số serial <span class="red">*</span>:</label>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<input type="text" class="txt-form" placeholder="Nhập số serial vào đây">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row box-form-text">--}}
    {{--<div class="col-xs-6">--}}
    {{--<label class="txt-label text-right">Mã thẻ <span class="red">*</span>:</label>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<input type="text" class="txt-form" placeholder="Nhập mã thẻ vào đây">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row box-form-radio">--}}
    {{--<div class="col-xs-6">--}}
    {{--<label class="txt-label text-right">Loại thẻ <span class="red">*</span>:</label>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<div class="form-radio">--}}
    {{--<label>--}}
    {{--<input type="radio" name="pay" value="Thẻ Vinacard (Vinaphone)">--}}
    {{--<span class="icon"><i class="far fa-circle"></i></span>--}}
    {{--Thẻ Vinacard (Vinaphone)--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--<div class="form-radio">--}}
    {{--<label>--}}
    {{--<input type="radio" name="pay" value="Thẻ Viettel" checked>--}}
    {{--<span class="icon"><i class="far fa-circle"></i></span>--}}
    {{--Thẻ Viettel--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--<div class="form-radio">--}}
    {{--<label>--}}
    {{--<input type="radio" name="pay" value="Thẻ Megacard">--}}
    {{--<span class="icon"><i class="far fa-circle"></i></span>--}}
    {{--Thẻ Megacard--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row box-form-img">--}}
    {{--<div class="col-xs-6">--}}
    {{--<label class="txt-label text-right">Mã xác nhận <span class="red">*</span>:</label>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<div class="img-reload pull-left">--}}
    {{--<img src="../images/img-reload.png" alt="" width="" height="">--}}
    {{--</div>--}}
    {{--<span class="icon pull-left"><i class="fas fa-sync-alt"></i></span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row box-form-text">--}}
    {{--<div class="col-xs-6">--}}
    {{--<label class="txt-label text-right">Nhập lại mã xác nhận <span class="red">*</span>:</label>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<input type="text" class="txt-form" placeholder="Nhập mã xác nhận vào đây">--}}
    {{--<p>Tiền sẽ được nạp cho tìa khoản:</p>--}}
    {{--<a href="#"> anticovidteam@gmail.com</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="text-center">--}}
    {{--<a href="#" class="btn btn-default-yellow btn-small">Nạp tiền</a>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="tab-pane fade" id="direct" role="tabpanel" aria-labelledby="direct-tab">
        <div class="tab-direct">
            <p class="p-top">Thanh toán trực tiếp (ship COD) là hình thức khách hàng đăng ký và thanh toán học phí tại nhà sau khi cung cấp thông tin và địa chỉ cho
                anticovid. khi thanh toán qua hinh thức trực tiếp học sinh sẽ được tặng thêm 5% giá trị tiền nạp. cụ thể như sau:</p>
            <div class="box-step">
                <p>Bước 1: Khách hàng có nhu cầu COD gọi đường dây nóng: 1900 6933 nhấn tiếp nhánh số 2 sau đó chọn THPT hoặc THCS và TH để gặp tư vấn viên.</p>
                <p>Bước 2: Khách hàng xác nhận các Khóa đào tạo/chuyên đề muốn đắng ký và cung cấp địa chỉ giao hàng cho anticovid</p>
                <p>Bước 3: anticovid in và chuyển phát nhanh hóa đơn cho khách hàng.</p>
                <p>Bước 4: Khách hàng thanh toán học phí với nhân viên giao nhận.</p>
            </div>
            <div class="box-noti box-step">
                <p class="step">Lưu ý:</p>
                <p>- Phí giao hàng: miễn phí dối với tất cả các đơn COD</p>
                <p>- Mọi thắc mắc xin liên hệ tổng đài 1900 6933 nhấn tiếp nhánh 2</p>
            </div>
        </div>
    </div>
</div>