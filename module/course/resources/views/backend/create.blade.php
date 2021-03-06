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
					<h3><i class="fa fa-sitemap "></i> Kh??a ????o t???o</h3>
					<p>T???o v?? ch???nh s???a Kh??a ????o t???o</p>
				</div>
			</div>
			
			<div class="row justify-content-center">
				<div class="col-sm-8 order-first">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-center">T???o Kh??a ????o t???o</h5>
						</div>
						<div class="card-body">
							
							<form method="post">
								
								@if (count($errors) > 0)
									@foreach($errors->all() as $e)
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
											<strong>L???i!</strong> {{$e}}
										</div>
									@endforeach
								@endif
								
								{{csrf_field()}}
								<input type="hidden" value="{{Auth::id()}}" name="author">
								
								<div class="form-group">
									<label class="form-control-label">T???t c??? b???n c???n l??m l?? nh???p m???t ti??u ????? l??m vi???c:</label>
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
									<label class="form-control-label">Lo???i Kh??a ????o t???o</label>
									<div class="row">
										<div class="course-type-wrapper">
											<div class="course-type-item active" data-value="normal">
												<i class="ti-video-camera"></i>
												<h4 class="course-type-title">Kh??a ????o t???o</h4>
												<div class="course-type-description">
													T???o tr???i nghi???m h???c t???p phong ph?? v???i s??? tr??? gi??p c???a c??c b??i gi???ng video, c??u ?????, b??i t???p m?? h??a, v.v.
												</div>
											</div>

											<div class="course-type-item" data-value="test">
												<i class="ti-check-box"></i>
												<h4 class="course-type-title">B??i tr???c nghi???m</h4>
												<div class="course-type-description">
													Gi??p h???c vi??n chu???n b??? cho k??? thi ch???ng nh???n b???ng c??ch cung c???p c??u h???i th???c h??nh
												</div>
											</div>

{{--											<div class="course-type-item" data-value="exam">--}}
{{--												<i class="ti-agenda"></i>--}}
{{--												<h4 class="course-type-title">B??i thi th???</h4>--}}
{{--												<div class="course-type-description">--}}
{{--													Gi??p sinh vi??n chu???n b??? cho k??? thi ch???ng nh???n b???ng c??ch cung c???p c??u h???i th???c h??nh--}}
{{--												</div>--}}
{{--											</div>--}}
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary float-right">L??u v?? ti???p t???c</button>
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