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
                                <a href="{{route('nqadmin::users.index.get')}}" class="btn btn-primary pull-right">
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
                                            <input type="text" name="email" class="form-control" aria-label="" placeholder="Nhập email">
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
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th width="150">Là đại diện doanh nghiệp ?</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tham gia </th>
                                    <th width="120">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td>
                                            @if ($d->thumbnail != null)
                                                <img src="{{ asset($d->thumbnail) }}" alt="{{ $d->email }}" class="gridpic">
                                            @else
                                                <img src="{{ asset('adminux/img/user-header.png') }}" alt="{{ $d->email }}" class="gridpic">
                                            @endif
                                        </td>
                                        <td>{{ $d->email }}</td>
                                        <td class="center">{{ $d->roles->isNotEmpty() ? $d->roles->first()->display_name : 'Người dùng' }}</td>
                                        <td class="center text-center">
                                            @if ($d->is_enterprise == 1)
                                                <i class="fa fa-check " style="color: green"></i>
                                            @else
                                                <i class="fa fa-times " style="color: red"></i>
                                            @endif
                                        </td>
                                        <td class="center">
                                            {!! conver_status($d->status) !!}
                                        </td>
                                        <td>
                                            {{$d->created_at}}
                                        </td>
                                        <td class="center">
                                            <a href="{{route('nqadmin::users.edit.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>

                                            <a href="" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::users.delete.get', $d->id)}}">
                                                <i class="fa fa-trash-o "></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="row">
                                <div class="container ">
                                    <nav aria-label="..." class="align-self-center">
                                        @include('nqadmin-dashboard::backend.components.pagination',['paginator'=>$data])
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