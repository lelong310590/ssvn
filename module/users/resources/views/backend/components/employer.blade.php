@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
@endsection

@section('content')

    @php
        $user = Auth::user();
    @endphp

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
                    <p>Danh sách tài khoản</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-16">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh sách tài khoản
                                <a href="{{route('nqadmin::users.create.get')}}" class="btn btn-primary pull-right">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm tài khoản
                                </a>
                            </h5>
                        </div>
                        <div class="card-header">
                            <form method="get">
                                <h6 class="card-title pull-left">Tìm kiếm</h6>
                                <ul class="nav nav-pills card-header-pills pull-left ml-2">
                                    <li class="nav-item ml-2">
                                        <div class="input-group">
                                            <input type="text" name="keyword" class="form-control" aria-label="" placeholder="Nhập SĐT, hoặc tên, CMND/CCCD" value="{{request()->get('keyword')}}">
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
                            <table class="table table-bordered" id="#">
                                <thead>
                                <tr>
                                    <th width="50">STT</th>
                                    <th width="200">Đơn vị</th>
                                    <th width="200">Họ và tên</th>
                                    <th width="200">CMND/CCCD</th>
                                    <th width="150">Số điện thoại</th>
                                    <th width="100">Giới tính</th>
                                    <th width="150">Tuổi</th>
                                    <th width="100">Ngày khởi tạo </th>
                                    <th width="120">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>

                                @php
                                    $i = $employers->perPage() * ($employers->currentPage() - 1) + 1
                                @endphp

                                @foreach($employers as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td class="text-center">{{$i++}}</td>
                                        <td>{{ $d->getClassLevel == null ? '' : $d->getClassLevel->name }}</td>
                                        <td>
                                            <p>{{ $d->first_name }} {{$d->last_name}}</p>
                                            @if ($d->hard_role == 2)
                                                <span class="status warning">Quản lý</span>
                                            @else
                                                <span class="status success">Người lao động</span>
                                            @endif
                                        </td>
                                        <td>{{ $d->citizen_identification }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ $d->sex }}</td>
                                        <td>
                                            <p>Ngày sinh {{$d->dob != null ? $d->dob->format('d/m/Y') : 'Chưa khai báo'}}</p>
                                            <p>Tuổi: {{ $d->old }}</p>
                                        </td>
                                        <td>
                                            {{$d->created_at}}
                                        </td>
                                        <td class="center">
                                            <a href="{{route('nqadmin::employer.transfer.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-exchange"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="row">
                                <div class="container ">
                                    <nav aria-label="..." class="align-self-center">
                                        @include('nqadmin-dashboard::backend.components.pagination',['paginator'=>$employers])
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