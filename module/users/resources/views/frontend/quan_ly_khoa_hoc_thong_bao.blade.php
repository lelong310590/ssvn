@extends('nqadmin-dashboard::frontend.master')

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
                                        <p class="text-666">Chia sẻ nội dung giáo dục bổ sung tài liệu Khóa đào tạocủa bạn để kích thích sự tham gia của sinh viên. Gửi qua email và hiển thị trên trang
                                            tổng quan của Khóa đào tạo. Tìm hiểu cách tạo thông báo tuyệt vời.</p>
                                        <div class="clearfix box-btn">
                                            <a href="{{ route('front.users.quan_ly_khoa_hoc_tao_thong_bao.get',['id'=>$id]) }}" class="btn btn-default-white btn-small pull-left btn-popup">Tạo mới</a>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Thông báo</th>
                                                    <th scope="col">Ngày tạo</th>
                                                    <th scope="col">Tỉ lệ mở</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($course->getAdvertise as $advertise)
                                                    <tr>
                                                        <td>
                                                            <a href="#" class="txt">{{ $advertise->title }}</a>
                                                            <p>{{ $advertise->content }}</p>
                                                        </td>
                                                        <td>{{ date('d/m/Y',strtotime($advertise->created_at)) }}</td>
                                                        <td>54.55%</td>
                                                        <td>
                                                            <div class="pop-noti">
                                                                <span class="icon-noti-table"><i class="fas fa-ellipsis-v"></i></span>
                                                                <div class="box-dropdown box-dropdown-small">
                                                                    <div class="form-dropdown form-dropdown-top-center">
                                                                        <ul>
                                                                            <li><a href="#">Xem thông báo</a></li>
                                                                            <li><a href="#">Hủy thông báo</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="box-paging">
                                            <div class="clearfix">
                                                <div class="pull-right">
                                                    <span class="txt pull-left">Trang</span>
                                                    <ul class="overflow">
                                                        <li class="pull-left"><a href="#" class="active">1</a></li>
                                                        <li class="pull-left"><a href="#">2</a></li>
                                                        <li class="pull-left"><a href="#">3</a></li>
                                                        <li class="pull-left"><a href="#">4</a></li>
                                                        <li class="pull-left"><a href="#">5</a></li>
                                                        <li class="pull-left"><a href="#">6</a></li>
                                                        <li class="pull-left"><a href="#">7</a></li>
                                                        <li class="pull-left"><a href="#">8</a></li>
                                                        <li class="pull-left"><a href="#">9</a></li>
                                                        <li class="pull-left"><a href="#">10</a></li>
                                                        <li class="pull-left"><a href="#"><i class="fas fa-chevron-right"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
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