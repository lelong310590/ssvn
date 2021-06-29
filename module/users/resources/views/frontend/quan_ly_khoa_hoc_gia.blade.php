@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="top-course-management">
                <div class="top-course-management">
                    @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.top',['id'=>$id])
                </div>
            </div>
            <!--top-course-management-->

            <div class="container">
                <div class="content-course-management row">
                    <div class="left-course-management col-xs-3">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.leftmenu',['id'=>$id])
                    </div>
                    <div class="right-course-management col-xs-9">
                        <h2 class="txt-title">Giá và phiếu giảm giá</h2>
                        <div class="box-coupons">
                            <div class="top-coupons">
                                <h4 class="title">Mức giá Công ty</h4>
                                <p class="text">Vui lòng chọn mức giá cho Khóa đào tạocủa bạn bên dưới và nhấp vào 'Lưu'. Giá niêm yết mà sinh viên sẽ thấy bằng đơn vị tiền tệ khác được tính bằng cách sử dụng ma trận giá , dựa trên mức mà nó tương ứng.</p>
                                <div class="box-list">
                                    <div class="clearfix list">
                                        <span class="title pull-left">Loại tiền</span>
                                        <span class="title pull-left price">USD</span>
                                    </div>
                                    <div class="clearfix list">
                                        <span class="title pull-left">Mức giá</span>
                                        <span class="title pull-left price">290,000 đ (Loại 2)</span>
                                    </div>
                                </div>
                            </div>
                            <!--top-coupons-->

                            <div class="table-coupons">
                                <h4 class="title">Phiếu giảm giá Khóa đào tạo</h4>
                                <form id="filter_form" class="box-form-default" method="get" action="">
                                <div class="box-search-left box-search">
                                    <div class="form-group">
                                        <input type="search" class="txt-form" name="q" placeholder="Tìm kiếm giá">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Mã</th>
                                            <th scope="col">Liên kết</th>
                                            <th scope="col">Giá bán</th>
                                            <th scope="col">Còn lại</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Hết hạn</th>
                                            <th scope="col">Trạng thái</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->code }}</td>
                                            <td>Nhận được liên kết</td>
                                            <td>{{ number_format($coupon->price,0,',','.') }}</td>
                                            <td>{{ $coupon->remain }}</td>
                                            <td>{{ $coupon->created_at }}</td>
                                            <td>{{ $coupon->deadline }}</td>
                                            <td>{{ $coupon->status }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="box-paging">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            {{ $coupons->appends($_GET)->render() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--table-coupons-->
                        </div>
                        <!--box-coupons-->
                    </div>
                </div>
            </div>
            <!--content-course-management-->

        </div>
    </div>
    <!--main-page-->
@endsection