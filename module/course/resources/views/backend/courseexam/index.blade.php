@extends('nqadmin-dashboard::backend.master')

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
    <div class="wrapper-content">
        <form method="post" action="">
            {{csrf_field()}}
            <input type="hidden" value="{{$course->id}}" name="course_id">
            <div class="row course-title align-items-center justify-content-between">
                <div class="col-16 page-title">
                    <h3>
                        <i class="fa fa-sitemap "></i> {{$course->name}}
                        <button type="submit" class="btn btn-primary float-right course-button">Lưu lại</button>
                        <a href="" class="btn btn-primary float-right course-button">Xem trước</a>
                    </h3>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thêm Khóa đào tạo</h5>
                            </div>
                            <div class="card-body">
                                <div class="sidebar-course-nav">
                                    @include('nqadmin-course::backend.sidebar')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-13">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Cấu hình thi thử</h5>
                            </div>
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    @foreach($errors->all() as $e)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            <strong>Lỗi!</strong> {{$e}}
                                        </div>
                                    @endforeach
                                @endif

                                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}

                                @include('nqadmin-course::backend.components.courseexam.index')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection