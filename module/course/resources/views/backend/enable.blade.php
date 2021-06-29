@extends('nqadmin-dashboard::backend.master')
@section('content')

@section('js')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
@endsection

@section('js-init')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>

	<script type="text/javascript">
        "use strict";
        $('.editor').ckeditor
	</script>
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endsection

<div class="wrapper-content">
	<div class="row course-title align-items-center justify-content-between">
		<div class="col-16 page-title">
			<h3>
				<i class="fa fa-sitemap "></i> {{$course->name}}
				{{--<button type="submit" class="btn btn-primary float-right course-button">Lưu lại</button>--}}
				{{--<a href="" class="btn btn-primary float-right course-button">Xem trước</a>--}}
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
						<h5 class="card-title">Duyệt Khóa đào tạo</h5>
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

						<form action="{{route('nqadmin::course.changeauthor.post', ['id' => $course->id])}}" method="post">
							<div class="form-group">
								{{csrf_field()}}
								<label class="form-control-label"><b>Nhượng quyền Khóa đào tạo</b></label>
								<select class="select2 form-control" name="author">
									@foreach($users as $u)
										<option value="{{$u->id}}" {{ ($course->author == $u->id) ? 'selected' : '' }}>{{$u->first_name.' '.$u->last_name}}</option>
									@endforeach
								</select>
							</div>
							<button class="btn btn-primary" type="submit">Nhượng quyền</button>
						</form>

						<form action="{{route('nqadmin::course.changeassistant.post', ['id' => $course->id])}}" method="post" style="margin-top: 30px">
							<div class="form-group">
								{{csrf_field()}}
								<label class="form-control-label"><b>Phụ trách Khóa đào tạo</b></label>
								<select class="select2 form-control" name="assistant">
									<option value="">Không chọn</option>
									@foreach($users as $u)
										<option value="{{$u->id}}" {{ ($course->assistant == $u->id) ? 'selected' : '' }}>{{$u->first_name.' '.$u->last_name}}</option>
									@endforeach
								</select>
							</div>
							<button class="btn btn-primary" type="submit">Lưu</button>
						</form>


						<div class="form-group" style="margin-top: 35px">
							<label class="form-control-label"><b>Thay đổi trạng thái xét duyệt Khóa đào tạo</b></label><br>
							@if($course->status=='active')
								<a class="btn btn-success" href="{{ route('nqadmin::course.enable.post',['id'=>$course->id]) }}">Đã duyệt</a>
							@else
								<a class="btn btn-danger" href="{{ route('nqadmin::course.enable.post',['id'=>$course->id]) }}">Chưa duyệt</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection