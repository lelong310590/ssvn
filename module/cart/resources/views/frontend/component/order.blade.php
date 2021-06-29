{{ csrf_field() }}
<div class="top-left-pay">
    <h3 class="name"><i class="fas fa-cart-plus"></i> Khóa đào tạo({{ Cart::content()->count() }})</h3>
    @foreach(Cart::content() as $data)
        <div class="money-course">
            <div class="left">
                <p>{{ $data->name }}</p>
            </div>
            <div class="right">
                <p>{{ number_format($data->price) }} đ</p>
            </div>
        </div>
    @endforeach
    <div class="form-sale">
        <p>Mã khuyến mãi (Nhập mã và click áp dụng)</p>
        <div class="form-group">
            <input type="text" class="txt-form" placeholder="Nhập mã khuyến mãi" id="coupon_code" value="{{ request('code') }}" name="code">
            <a class="btn btn-default-yellow btn-small" onclick="return checkcode()">Áp dụng</a>
        </div>
        @if(!empty(request('code')))
            <p>{{ $discount['message'] }}</p>
        @endif
    </div>
    <div class="money-total" id="money-total">
        <div class="row old">
            <div class="col-xs-6 left-old">
                <p>Học phí gốc</p>
            </div>
            <div class="col-xs-6 right-old">
                <p>{{ number_format(Cart::content()->sum('price')) }} đ</p>
            </div>
        </div>
        <div class="row sale">
            <div class="col-xs-6 left-sale">
                <p>Giảm giá</p>
            </div>
            <div class="col-xs-6 right-sale">
                <p>{{ number_format($discount['price']) }}</p>
            </div>
        </div>
        <div class="row total">
            <div class="col-xs-6 left-total">
                <p>Thành tiền</p>
            </div>
            <div class="col-xs-6 right-total">
                <p>{{ number_format(Cart::content()->sum('price')-$discount['price']) }} đ</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" placeholder="Nhập mã khuyến mãi" value="transfer" name="payment_method">
<button type="submit" class="btn btn-default-yellow btn-pay">Hoàn tất thanh toán</button>