@extends('nqadmin-dashboard::backend.master')

@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
    @include('nqadmin-dashboard::backend.components.datatables.init')

    <script>
        function addToCart(course_id) {
            var code = $('#coupon_code').val();
            var user_id = $('#user_id').val();
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{!! route('nqadmin::checkout.cart.addtocart.post') !!}', // the url where we want to POST
                data: {
                    _token: "{!! csrf_token() !!}",
                    course_id: course_id,
                    user_id: user_id,
                    code: code
                },
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                    if (data.code == 0) {
                        alert(data.message);
                    }
                    if (data.code == 1) {
                        $('.box-buy').html(data.html);
                    }
                }
            })
        }

        function removeToCart(course_id) {
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{!! route('nqadmin::checkout.cart.removetocart.post') !!}', // the url where we want to POST
                data: {
                    _token: "{!! csrf_token() !!}",
                    course_id: course_id
                },
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                    if (data.code == 0) {
                        alert(data.message);
                    }
                    if (data.code == 1) {
                        $('.box-buy').html(data.html);
                    }
                }
            })
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endsection

@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3>Tạo đơn hàng</h3>
                    <p>Tạo đơn hàng cho khách</p>
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
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td><img src="{{ asset($d->avatar) }}" alt="{{ $d->email }}" class="gridpic"></td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->getDataByKey('phone') }}</td>
                                        <td class="center">
                                            {!! conver_status($d->status) !!}
                                        </td>
                                        <td class="center">
                                            <a href="{{route('nqadmin::users.edit.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>

                                            <a href="{{route('nqadmin::checkout.create.get', ['user_id' => $d->id])}}" class=" btn btn-link btn-sm ">
                                                Chọn khách hàng
                                            </a>
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
            @if(request('user_id'))
                <div class="row">
                    <div class="col-md-8 col-lg-10">
                        <div class="card">
                            <div class="card-header align-items-start justify-content-between flex">
                                <h5 class="card-title  pull-left">Danh sách hóa học
                                    <small> ({{ $course->count() }} Khóa đào tạo)</small>
                                </h5>
                                <form method="get">
                                    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                    <input type="hidden" name="author" value="{{ request('author') }}">
                                    <ul class="nav nav-pills card-header-pills pull-right">
                                        <li class="nav-item">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <select class="select2 form-control" name="classlevel">
                                                    <option value="">Chọn Công ty</option>
                                                    @foreach($classlevels as $classlevel)
                                                        <option value="{{ $classlevel->id }}" {{ request('classlevel')==$classlevel->id?'selected':'' }}>{{ $classlevel->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <div class="input-group">
                                                <select class="select2 form-control" name="subject">
                                                    <option value="">Chọn Chứng chỉ</option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}" {{ request('subject')==$subject->id?'selected':'' }}>{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Từ khóa" value="{{ request('keyword') }}" name="keyword">
                                                <button class="input-group-addon ">Tìm kiếm</button>
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered m-0 table-hover">
                                    <thead>
                                    <th width="180">Ảnh Khóa đào tạo</th>
                                    <th width="50%">Thông tin Khóa đào tạo</th>
                                    <th>Thao tác</th>
                                    </thead>
                                    <tbody>
                                    @foreach($course as $d)
                                        <tr>
                                            <td>
                                                <img src="{{ isset($d->getLdp->thumbnail)?asset($d->getLdp->thumbnail):asset('adminux/img/placeholder.png') }}" alt="{{ $d->email }}" width="100"
                                                     height="100">
                                            </td>
                                            <td>
                                                <h4 class="card-title ">{{ $d->name }} </h4>
                                                <h4>{{ number_format($d->price) }} VNĐ</h4>
                                                <h5 class="text-warning">
                                                    @for($i=1; $i <= $d->getRating->max('rating_number');$i++)
                                                        @if($i<=$d->getRating->avg('rating_number'))
                                                            @if($d->getRating->avg('rating_number')-$i==0.5)
                                                                <i class="fa fa-star-half"></i>
                                                            @else
                                                                <i class="fa fa-star"></i>
                                                            @endif
                                                        @endif
                                                        @if($i>$d->getRating->avg('rating_number'))
                                                            <i class="fa fa-star-o"></i>
                                                        @endif
                                                    @endfor
                                                    <small><a href="javascript:void(0)">({{ $d->getRating->count() }}) Đánh giá</a></small>
                                                </h5>
                                                <a href="{{route('nqadmin::checkout.create.get', ['user_id' => request('user_id'),'author'=>$d->owner->id])}}" class="card-text">
                                                    Tác giả: {{ $d->owner->first_name }}
                                                </a>
                                                <p>{{ $d->description }}</p>
                                                @if($d->type=='normal')
                                                    <p>
                                                        <i class="fa fa-play-circle"></i> {{ $d->getCurriculumVideo() }} bài giảng
                                                    </p>
                                                    <p>
                                                        <i class="fa fa-clock-o"></i> {{ secToHR($d->getDuration()) }}
                                                    </p>
                                                @endif
                                                @isset($d->getClassLevel->first()->name)
                                                    <p>
                                                        <i class="fa fa-sliders"></i> {{ $d->getClassLevel->first()->name }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$d->checkBoughtWithId(request('user_id')))
                                                    <a href="javascript:void(0)" class="btn btn-outline-primary addtocart" onclick="addToCart('{{ $d->id }}')">
                                                        <i class="fa fa-heart"></i> Thêm vào hóa đơn
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="card box-buy">
                            @include('nqadmin-cart::backend.components.checkout')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection