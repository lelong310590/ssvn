@extends('nqadmin-dashboard::backend.master')

@section('content')

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
                    <p>Sửa tài khoản {{$data->email}}</p>
                </div>
            </div>

            <form method="post" autocomplete="off">

                @if (count($errors) > 0)
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <strong>Lỗi!</strong> {{$e}}
                        </div>
                    @endforeach
                @endif

                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}
                {!! \Base\Supports\FlashMessage::renderMessage('create') !!}

                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    Sửa tài khoản
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success">
                                    <p>CCCD/CMND: <b><i>{{$data->citizen_identification}}</i></b></p>
                                    <p>Họ và tên: <b><i>{{$data->first_name}} {{$data->last_name}}</i></b></p>
                                    <p>Địa chỉ Email: <b><i>{{$data->email}}</i></b></p>
                                    <p>Số điện thoại: <b><i>{{$data->phone}}</i></b></p>
                                    <p>Ngày/Tháng/Năm sinh: <b><i>{{$data->dob != null ? $data->dob->format('Y-m-d') : ''}}</i></b></p>
                                    <p>Giới tính: <b><i>{{$data->sex}}</i></b></p>
                                    <p>Đơn vị đang công tác:
                                        @if ($data->getClassLevel == null)
                                            <b><i>Đang thất nghiệp / Chưa xác nhận</i></b>
                                        @else
                                            <b><i>{{$data->getClassLevel->name}}</i></b>
                                        @endif
                                    </p>
                                    <p>Chức vụ: <b><i>{{ $data->hard_role == 2 ? 'Quản lý' : 'Lao động thường' }}</i></b></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thao tác</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Thuyên chuyển sang đơn vị</label>
                                    <select class="custom-select form-control" name="classlevel">
                                        <option value="" {{$data->classlevel == null ? 'selected' : ''}}>-- NGHỈ VIỆC ---</option>
                                        @foreach($classLevel as $c)
                                            <option value="{{$c->id}}" {{ ($data->classlevel == $c->id) ? 'selected' : '' }}>{{$c->name}} - MST: {{$c->mst}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($data->hard_role == 2)
                                <div class="form-group">
                                    <div class="notes notes-danger">
                                        <strong>Lưu ý!</strong>
                                        Chuyển tất cả người lao động dưới quyền quản lý của {{$data->first_name}} {{$data->last_name}} sang cho quản lý mới là:
                                    </div>
                                    <select class="custom-select form-control" name="newmanager">
                                        <option value="">-- Giữ nguyên --</option>
                                        @foreach($managerInCompany as $m)
                                            <option value="{{$m->id}}">{{$data->first_name}} {{$data->last_name}} - CMND/CCCD: {{$c->citizen_identification}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
