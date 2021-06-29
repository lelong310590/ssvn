@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="top-course-management">
                <div class="top-course-management">
                    @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.top',['id'=>$id,'course' => $course])
                </div>
            </div>
            <!--top-course-management-->

            <div class="container">
                <div class="content-course-management row">
                    <div class="left-course-management col-xs-3">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.leftmenu',['id'=>$id])
                    </div>
                    <div class="right-course-management col-xs-9">
                        <h2 class="txt-title">Học sinh</h2>
                        <div class="box-student">
                            <div class="search-my-course">
                                <span class="pull-left txt">Tìm kiếm</span>
                                <div class="box-search overflow">
                                    <form method="get">
                                    <div class="form-group">
                                        <input value="{{ isset($_REQUEST['fn'])?$_REQUEST['fn']:'' }}" name="fn" type="search" class="txt-form" placeholder="Tìm kiếm bài học">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Đã đăng ký</th>
                                        <th scope="col">Lần cuối xem</th>
                                        <th scope="col">Phát triển</th>
                                        <th scope="col" class="text-center">Câu được hỏi</th>
                                        <th scope="col" class="text-center">Câu trả lời</th>
                                        <th scope="col">Tin nhắn cuối</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($student as $st)
                                        @php
                                        //lay thoi gian mua khoa hoc
                                        $orderDetail = $st->bought()->where('course_id',$id)->first();
                                        //lay % hoan thanh
                                        $process = $course->getProcessStudent($st->id);
                                        //lay tong so cau duoc hoi

                                        //lay tong so cau tra loi
                                        
                                        @endphp
                                    <tr>
                                        <td>{{ $st->first_name }}</td>
                                        <td>{{ isset($orderDetail->created_at)?$orderDetail->created_at:'' }}</td>
                                        <td>03/12/2018</td>
                                        <td>{{ $process }}%</td>
                                        <td class="text-center">92</td>
                                        <td class="text-center">92</td>
                                        <td>03/12/2018</td>
                                        <td><a href="#" class="btn btn-default-white btn-small">Soạn tin</a> </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="box-paging">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        {{ $student->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--box-student-->
                    </div>
                </div>
            </div>
            <!--content-course-management-->

        </div>
    </div>
    <!--main-page-->
@endsection