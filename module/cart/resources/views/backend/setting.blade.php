@extends('nqadmin-dashboard::backend.master')
@section('content')

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Cài đặt thanh toán</h3>
                    <p>Theo dõi thanh toán và tạo thanh toán thủ công</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-lg-8 col-xl-4">
                    <a class="activity-block success" href="{{route('nqadmin::checkout.index.get')}}">
                        <div class="media">
                            <div class="media-body">
                                <h5>Danh sách Thanh toán</h5>
                            </div>
                        </div>
                        <br>
                        <div class="media">
                            <div class="media-body"><span class="progress-heading">Danh sách các Thanh toán trong hệ thống</span></div>
                        </div>
                        <i class="bg-icon text-center fa fa-users"></i>
                    </a>
                </div>
                <div class="col-md-8 col-lg-8 col-xl-4">
                    <a class="activity-block success" href="{{route('nqadmin::checkout.create.get')}}">
                        <div class="media">
                            <div class="media-body">
                                <h5>Tạo hóa đơn mới</h5>
                            </div>
                        </div>
                        <br>
                        <div class="media">
                            <div class="media-body"><span class="progress-heading">Tạo hóa đơn mới</span></div>
                        </div>
                        <i class="bg-icon text-center fa fa-users"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection