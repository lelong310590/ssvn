@extends('nqadmin-dashboard::backend.master')

@section('js')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/bootstrap-maxlength.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/ckeditor/ckeditor.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment-with-locales.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js-init')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/init.js')}}"></script>
	
	<script type="text/javascript">
		"use strict";
        $('.editor').ckeditor
	</script>
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
	<div class="wrapper-content">
		<form method="post" action="{{route('nqadmin::course.landingpage.post', $course->id)}}" enctype="multipart/form-data">
			{{csrf_field()}}
			<input type="hidden" value="{{$course->id}}" name="course_id">
			<div class="row course-title align-items-center justify-content-between">
				<div class="col-16 page-title">
					<h3>
						<i class="fa fa-sitemap "></i> {{$course->name}}
						<button type="submit" class="btn btn-primary float-right course-button">Lưu lại</button>
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
								<h5 class="card-title">Trang đích Khóa đào tạo</h5>
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
								
								@include('nqadmin-course::backend.components.courseldp.index')
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection