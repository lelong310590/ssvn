@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
    <script>
        $('#dataTables-order').DataTable({
            order: [[4, 'desc'], [0, 'asc']]
        });
        $('input[name=payment_method]').change(function () {
            $('#filter_form').submit();
        });
    </script>
@endsection

@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Đơn hàng</h3>
                    <p>Danh sách đơn hàng</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-16">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh sách đơn hàng
                                <a href="{{route('nqadmin::checkout.create.get')}}" class="btn btn-primary pull-right">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm Đơn hàng
                                </a>
                            </h5>
                        </div>
                        <div class="card-header">
                            <form method="get">
                                <h6 class="card-title pull-left">Tìm kiếm</h6>
                                <ul class="nav nav-pills card-header-pills pull-left ml-2">

                                    <li class="nav-item ml-2">
                                        <div class="input-group">
                                            <input type="text" name="email" value="{{old('email')}}" class="form-control" aria-label="" placeholder="Nhập email">
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <button class="btn btn-sm btn-primary "><i class="fa fa-search"></i> <span class="text">Tìm kiếm</span></button>
                                    </li>
                                    <li class="ml-3"><span class="btn btn-info"> <a style="color:#fff" href="{{route('nqadmin::users.index.get')}}">Làm lại</a> </span></li>
                                </ul>

                            </form>
                        </div>
                        <div class="card-body">
                            <form method="get" id="filter_form">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary {{ request('payment_method')==''||request('payment_method')=='all'?'active':'' }}">
                                        <input type="radio" name="payment_method" value="all" {{ request('payment_method')==''||request('payment_method')=='all'?'checked':'' }}>Toàn bộ
                                    </label>
                                    <label class="btn btn-primary {{ request('payment_method')=='transfer'?'active':'' }}">
                                        <input type="radio" name="payment_method" value="transfer" {{ request('payment_method')=='transfer'?'checked':'' }}>Chuyển khoản
                                    </label>
                                    <label class="btn btn-primary {{ request('payment_method')=='atm'?'active':'' }}">
                                        <input type="radio" name="payment_method" value="atm" {{ request('payment_method')=='atm'?'checked':'' }}>Internet Banking
                                    </label>
                                    <label class="btn btn-primary {{ request('payment_method')=='direct'?'active':'' }}">
                                        <input type="radio" name="payment_method" value="direct" {{ request('payment_method')=='direct'?'checked':'' }}>Trực tiếp
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="#">
                                <thead>
                                <tr>
                                    <th>Mã Hóa đơn</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Thời gian</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td><a href="{{ route('nqadmin::checkout.detail.get',['id'=>$data->id]) }}">{{ $data->getOrderCode() }}</a></td>
                                        <td>{{ $data->getCustomer->first_name }}</td>
                                        <td>{{ $data->getCustomer->email }}</td>
                                        <td>{{ $data->getCustomer->getDataByKey('phone') }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td class="center">
                                            @if($data->status!='create')
                                                <span class="status {{ $data->text_status['class'] }}">{{ $data->text_status['text'] }}</span>
                                            @else
                                                <span class="status {{ $data->text_status['class'] }}">{{ $data->text_status['text'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="row">
                                <div class="container ">
                                    <nav aria-label="..." class="align-self-center">
                                        @include('nqadmin-dashboard::backend.components.pagination',['paginator'=>$datas])
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection