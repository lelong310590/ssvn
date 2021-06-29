@extends('nqadmin-dashboard::frontend.master')
@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js-init')
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/init.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection
@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="top-course-management">
                @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.top',['id'=>$id])
            </div>
            <!--top-course-management-->

            <div class="container">
                <div class="content-course-management row">
                    <div class="left-course-management col-xs-3">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.leftmenu',['id'=>$id])
                    </div>
                    <div class="right-course-management col-xs-9">
                        <h2 class="txt-title">Thông báo</h2>
                        <div class="box-tab-notifi">
                            @include('nqadmin-users::frontend.components.thongbao.top-thong bao')

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in active" id="notifi" role="tabpanel" aria-labelledby="notifi-tab">
                                    <div class="box-tab-notifi">
                                        <div class="box-creat-notifi">
                                            <h2 class="txt-title text-center">Tạo thông báo</h2>
                                            <div class="row top-my-course">
                                                <div class="col-xs-12">
                                                    <p class="text">
                                                        <span class="txt-bold">Người nhận:</span>
                                                        Bao gồm học sinh đăng ký 1 trong các khóa dưới đây (liệt kê các khóa cho người dùng chọn)
                                                    </p>

                                                    <form class="box-form-default" method="post" action="{{ route('front.users.quan_ly_khoa_hoc_tao_thong_bao.post',['id'=>$id]) }}">
                                                        {{ csrf_field() }}
                                                        <div class="form-select-course">
                                                            @include('nqadmin-users::frontend.components.thongbao.find-course')

                                                            <div class="box-choose-date row">
                                                                <div class="col-xs-6 left-choose-date">
                                                                    <p>Bao gồm những sinh viên ghi danh giữa</p>
                                                                    <div class="form-group form-date">
                                                                        <label class="txt-label pull-left">Ngày bắt đầu</label>
                                                                        <div class="form-group pull-left">
                                                                            <div class="input-group date datetimepicker">
                                                                                <input type='text' class="form-control input-form" name="from"/>
                                                                                <span class="input-group-addon">
                                                                                <i class="far fa-calendar-minus"></i>
                                                                            </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-date">
                                                                        <label class="txt-label pull-left">Ngày kết thúc</label>
                                                                        <div class="form-group pull-left">
                                                                            <div class="input-group date datetimepicker">
                                                                                <input type='text' class="form-control input-form" name="to"/>
                                                                                <span class="input-group-addon">
                                                                                <i class="far fa-calendar-minus"></i>
                                                                            </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{--<div class="col-xs-6 right-choose-date">--}}
                                                                {{--<p>Bao gồm những học sinh đã tiến bộ</p>--}}
                                                                {{--<ul>--}}
                                                                {{--<li><i class="fas fa-check-square"></i>0% (Chưa bắt đầu</li>--}}
                                                                {{--<li><i class="fas fa-check-square"></i>1 - 49%</li>--}}
                                                                {{--<li><i class="fas fa-check-square"></i>50 - 99%</li>--}}
                                                                {{--<li><i class="fas fa-check-square"></i>100% (Đã hoàn thành)</li>--}}
                                                                {{--</ul>--}}
                                                                {{--</div>--}}
                                                            </div>

                                                            <div class="form-comment-ck">
                                                                <div class="form-group">
                                                                    <label class="txt-label">Nội dung</label>
                                                                    <input type="text" class="input-form" required name="title">
                                                                </div>
                                                                <div class="box-ck">
                                                                    <textarea id="editor" required name="content"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-default-yellow btn-small">Gửi</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--box-creat-notifi-->
                                    </div>
                                    <!--box-tab-notifi-->
                                </div>

                                <div class="tab-pane fade" id="notifiDetail" role="tabpanel" aria-labelledby="notifiDetail-tab">
                                    <div class="box-form-notifi">
                                        @include('nqadmin-users::frontend.components.thongbao.thongbao-default')
                                    </div>
                                    <!--box-form-notifi-->
                                </div>

                            </div>
                        </div>
                        <!--box-tab-notifi-->
                    </div>
                </div>
            </div>
            <!--content-course-management-->

        </div>
    </div>
    <!--main-page-->
@endsection