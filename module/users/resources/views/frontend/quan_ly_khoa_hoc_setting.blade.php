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
                        <div class="top-title row">
                            <div class="col-xs-12">
                                <h2 class="txt-title pull-left">Cài đặt Khóa đào tạo</h2>
                                <div class="box-dropdown-single pull-right box-sort-by">
                                    <div class="dropdown-single">
                                        <span class="show-txt">Quản lý thông báo qua Email <i class="fas fa-chevron-down pull-right"></i></span>
                                        <ul class="form-dropdown">
                                            <li><a href="#">Tham gia gần đây</a> </li>
                                            <li><a href="#">Tiêu đề Khóa đào tạo(A-Z)</a> </li>
                                            <li><a href="#">Tiến độ Khóa đào tạo(Z-A)</a> </li>
                                            <li><a href="#">Hoàn thành (0%-100%)</a> </li>
                                            <li><a href="#">Hoàn thành (100%-0%)</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--top-title-->

                        <div class="table-management">
                            <p class="txt-form">Cấp phép</p>
                            <form class="box-form-default">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Giảng viên</th>
                                            <th scope="col" class="text-center">Có thể xem</th>
                                            <th scope="col" class="text-center">Quản lý</th>
                                            <th scope="col" class="text-center">Phụ đề</th>
                                            <th scope="col" class="text-center">Hỏi & Đáp</th>
                                            <th scope="col" class="text-center">Nhiệm vụ</th>
                                            <th scope="col" class="text-center">Đánh giá</th>
                                            <th scope="col" class="text-center">Báo cáo DT</th>
                                            <th scope="col" class="text-center">Chia sẻ lợi nhuận</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>safecovid</td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                50%
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nguyễn Văn Tuyền - <span class="level">Owner</span></td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group form-check">
                                                    <label>
                                                        <input type="checkbox" value="" checked disabled>
                                                        <span class="icon"><i class="far fa-square"></i></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                50%
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="box-search-management">
                                    <div class="box-search">
                                        <div class="form-group">
                                            <input type="search" class="txt-form" placeholder="Nhập Email liên kết với một tài khoản safecovid">
                                            <button type="submit" class="btn btn-search"> Thêm </button>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-default-yellow btn-small btn-save">Lưu</a>
                                </div>
                                <!--box-search-management-->
                            </form>
                        </div>
                        <!--table-management-->

                        <div class="box-status-course">
                            <p class="txt-form">Trạng thái Khóa đào tạo</p>
                            <div class="list-status-course">
                                <div class="list clearfix">
                                    <a href="#" class="btn btn-small btn-default-yellow pull-left">Hủy xuất bản</a>
                                    <p class="overflow">Sinh viên mới không thể tìm thấy Khóa đào tạocủa bạn qua tìm kiếm, nhưng sinh viên hiện tại vẫn có thể truy cập nội dung.</p>
                                </div>
                                <div class="list clearfix">
                                    <a href="#" class="btn btn-small btn-default-white pull-left">Xóa bỏ</a>
                                    <p class="overflow">Chúng tôi hứa hẹn sinh viên truy cập suốt đời, vì vậy các Khóa đào tạokhông thể bị xóa sau khi sinh viên ghi danh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--content-course-management-->

        </div>
    </div>
    <!--main-page-->

@endsection