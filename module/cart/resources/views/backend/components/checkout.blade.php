<?php
$discount = isset($discount) ? $discount : 0;
?>
<div class="card-header align-items-start justify-content-between flex">
    <h5 class="card-title  pull-left">Thanh toán</h5>
</div>
<div class="card-body">
    <form method="post" action="{{ route('nqadmin::checkout.store.post') }}">
        {{ csrf_field() }}
        <table class="table table-hover">
            <thead>
            <tr>
                <td style="width: 10%"></td>
                <th>Khóa đào tạo</th>
                <th class="text-right">Giá</th>
                <td>Quà tặng</td>
            </tr>
            </thead>
            <tbody>
            @foreach(Cart::content() as $data)
                <tr>
                    <td><a href="javascript:void(0)" onclick="return removeToCart('{{ $data->rowId }}')"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                    <td>{{ $data->name }}</td>
                    <td class="text-right">{{ number_format($data->price) }}đ</td>
                    <td><input type="checkbox" name="khuyenmai[]" value="{{ $data->id }}"></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><b>Tổng cộng:</b></td>
                <td class="text-right">{{ number_format(Cart::content()->sum('price')) }} đ</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><b>Giảm giá:</b></td>
                <td class="text-right">{{ number_format($discount['price']) }} đ</td>
            </tr>
            </tfoot>
        </table>
        <hr>
        <div class="page_subtitles">Mã khuyến mãi:</div>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Nhập mã!" value="{{ request('code') }}" name="code" id="coupon_code">
            <a href="javascript:void(0)" class="input-group-addon " onclick="return check_code()">Áp dụng</a>
        </div>
        <br>
        <hr>
        <div class="page_subtitles">Tổng số</div>
        <h2 class="text-info">{{ number_format(Cart::content()->sum('price')-$discount['price']) }} đ</h2>
        <input type="hidden" name="user_id" value="{{ request('user_id') }}" id="user_id">
        <button type="submit" class="btn btn-default-yellow btn-pay">Hoàn tất thanh toán</button>
    </form>
</div>

@push('js')
    <script>
        function check_code() {
            var code = $('#coupon_code').val();
            if (code != '')
                window.location.href = "{!! route('nqadmin::checkout.create.get',['user_id'=>request('user_id')]) !!}" + "&code=" + code;
        }
    </script>
@endpush