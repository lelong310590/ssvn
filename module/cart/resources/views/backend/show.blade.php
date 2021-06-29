@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
@endsection

@section('content')

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3>Chi tiết Đơn hàng</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-16">
                    <div class="card status-danger">
                        <div class="card-header">
                            <h2 class=" mb-0">Hóa đơn
                                <small class="pull-right"><span>Số hoá đơn: </span>{{ $data->getOrderCode() }}</small>
                            </h2>
                        </div>
                        <form id="update-checkout-{!! $data->id !!}" action="{{ route('nqadmin::checkout.update.post',['id'=>$data->id]) }}" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <address>
                                            <strong>Thông tin khách hàng:</strong><br>
                                            {{ $data->getCustomer->first_name }}<br>
                                            {{ $data->getCustomer->email }}<br>
                                            {{ $data->getCustomer->getDataByKey('phone') }}<br>
                                        </address>
                                        <br>
                                        <address>
                                            <strong>Hình thức thành toán:</strong><br>
                                            @if($data->status=='create')
                                                <select name="payment_method">
                                                    <option value="transfer" {{ $data->payment_method=='transfer'?'selected':'' }}>Chuyển khoản ngân hàng</option>
                                                    <option value="atm" {{ $data->payment_method=='atm'?'selected':'' }}>Thẻ ATM có Internet Baking</option>
                                                    <option value="direct" {{ $data->payment_method=='direct'?'selected':'' }}>Thanh toán trực tiếp</option>
                                                </select>
                                            @else
                                                {{ $data->text_payment_method }}<br>
                                                <strong>Trạng thái đơn hàng:</strong><br>
                                                {{ $data->text_status['text'] }}
                                            @endif
                                        </address>
                                    </div>
                                    <div class="col-sm-8 text-right">
                                        <address>
                                            <strong>Ngày lập đơn hàng:</strong><br>
                                            <p>{{ date('d/m/Y',strtotime($data->created_at)) }}</p>
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-16">
                                        <h2 class="text-center">Chi tiết</h2>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-16">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <td><strong>Tiêu đề</strong></td>
                                                    <td class="text-center"><strong>Giá</strong></td>
                                                    <td class="text-center"><strong>Mã giảm giá</strong></td>
                                                    <td class="text-right"><strong>Tổng tiền</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                @foreach($data->detail as $detail)
                                                    <tr>
                                                        <td>
                                                            <b>{{ $detail->course->name }}</b>
                                                        </td>
                                                        <td class="text-center">{{ number_format($detail->base_price) }}</td>
                                                        @if(empty($detail->coupon)&&$detail->base_price!=0&&$detail->price==0)
                                                            <td class="text-center">Quà tặng kèm</td>
                                                        @else
                                                            <td class="text-center">{{ $detail->coupon?$detail->coupon->code:'' }}</td>
                                                        @endif
                                                        <td class="text-right">{{ number_format($detail->price) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center"><strong>Toàn bộ</strong></td>
                                                    <td class="thick-line text-right">{{ number_format($data->detail->sum('base_price')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center"><strong>Giảm giá</strong></td>
                                                    <td class="thick-line text-right">{{ number_format($data->detail->sum('base_price')-$data->detail->sum('price')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center"><strong>Tổng số chi trả</strong></td>
                                                    <td class="no-line text-right"><strong>{{ number_format($data->detail->sum('price')) }}</strong></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="card-footer align-items-center justify-content-between d-flex">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-success pull-right">Quay lại danh sách</a>
                                @if($data->status=='create')
                                    <button type="submit" class="btn btn-primary"> Hoàn tất thanh toán</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection