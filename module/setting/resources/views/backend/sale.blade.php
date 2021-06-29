@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
@endsection

@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Cấu hình chung</h3>
                    <p>Cấu hình giảm giá Khóa đào tạo</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-16">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh sách chương trình giảm giá
                                <a href="{{route('nqadmin::setting.createsale.get')}}" class="btn btn-primary pull-right">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Lỗi!</strong> {{$e}}
                                    </div>
                                @endforeach
                            @endif
                            {!! \Base\Supports\FlashMessage::renderMessage('create') !!}
                            {!! \Base\Supports\FlashMessage::renderMessage('delete') !!}
                            <table class="table" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Tên chương trình</th>
                                        <th>Áp dụng với khoảng giá</th>
                                        <th>Giá áp dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $currentUser = Auth::user();
                                @endphp
                                @foreach($data as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td>
                                            {{$d->name}}
                                        </td>
                                        <td>
                                            {{ number_format($d->min_price) }} đến {{ number_format($d->max_price) }}
                                        </td>
                                        <td>
                                            {{$d->price}}
                                        </td>
                                        <td>
                                            {{$d->start_time}}
                                        </td>
                                        <td>
                                            {{$d->end_time}}
                                        </td>
                                        <td>
                                            @if($d->status=='active')
                                                <a class="btn btn-success" href="{{ route('nqadmin::sale.enable.post',['id'=>$d->id]) }}">Đã duyệt</a>
                                            @elseif($d->status=='disable')
                                                <a class="btn btn-danger" href="{{ route('nqadmin::sale.enable.post',['id'=>$d->id]) }}">Chưa duyệt</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection