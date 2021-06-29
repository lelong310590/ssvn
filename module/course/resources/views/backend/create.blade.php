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
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Khóa đào tạo</h3>
					<p>Tạo và chỉnh sửa Khóa đào tạo</p>
				</div>
			</div>
			
			<div class="row justify-content-center">
				<div class="col-sm-8 order-first">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-center">Tạo Khóa đào tạo</h5>
						</div>
						<div class="card-body">
							
							<form method="post">
								
								@if (count($errors) > 0)
									@foreach($errors->all() as $e)
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											<strong>Lỗi!</strong> {{$e}}
										</div>
									@endforeach
								@endif
								
								{{csrf_field()}}
								<input type="hidden" value="{{Auth::id()}}" name="author">
								
								<div class="form-group">
									<label class="form-control-label">Tất cả bạn cần làm là nhập một tiêu đề làm việc:</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control input-max-length"
									       autocomplete="off"
									       name="name"
									       value="{{old('name')}}"
									       id="input_name"
									       onkeyup="ChangeToSlug();"
									       maxlength="80"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Slug</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="slug"
									       value="{{old('slug')}}"
									       id="input_slug"
									>
								</div>

								<input type="hidden" name="type" value="normal" id="course-type">

								<div class="form-group">
									<label class="form-control-label">Loại Khóa đào tạo</label>
									<div class="row">
										<div class="course-type-wrapper">
											<div class="course-type-item active" data-value="normal">
												<i class="ti-video-camera"></i>
												<h4 class="course-type-title">Khóa đào tạo</h4>
												<div class="course-type-description">
													Tạo trải nghiệm học tập phong phú với sự trợ giúp của các bài giảng video, câu đố, bài tập mã hóa, v.v.
												</div>
											</div>

											<div class="course-type-item" data-value="test">
												<i class="ti-check-box"></i>
												<h4 class="course-type-title">Bài trắc nghiệm</h4>
												<div class="course-type-description">
													Giúp học viên chuẩn bị cho kỳ thi chứng nhận bằng cách cung cấp câu hỏi thực hành
												</div>
											</div>

{{--											<div class="course-type-item" data-value="exam">--}}
{{--												<i class="ti-agenda"></i>--}}
{{--												<h4 class="course-type-title">Bài thi thử</h4>--}}
{{--												<div class="course-type-description">--}}
{{--													Giúp sinh viên chuẩn bị cho kỳ thi chứng nhận bằng cách cung cấp câu hỏi thực hành--}}
{{--												</div>--}}
{{--											</div>--}}
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary float-right">Lưu và tiếp tục</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.course-type-item').on('click', function (e) {
            var _this = $(e.currentTarget);
            var type = _this.attr('data-value');
            $('.course-type-item').removeClass('active');
            _this.addClass('active');
            $('#course-type').val(type);
        })
    })
</script>
@endpush