@extends('nqadmin-dashboard::backend.master')

@push('js')
	<script type="text/javascript" src="{{asset('adminux/vendor/ckeditor/ckeditor.js')}}"></script>
@endpush

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Cấu hình chung</h3>
					<p>Cấu hình thông báo top</p>
				</div>
			</div>

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
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Nội dung thông báo</label>
									<textarea class="form-control ckeditor" name="mess">{{ isset($data->content)?$data->content:'' }}</textarea>
								</div>
								{{--<div class="form-group">--}}
									{{--<label class="form-control-label">URL</label>--}}
									{{--<input type="text" name="url" value="" class="form-control">--}}
								{{--</div>--}}
							</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Thao tác</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Trạng thái </label>
									<select class="custom-select form-control" name="status">
										<option value="1" {{ isset($data->status )&&($data->status == 1) ? 'selected' : '' }}>Kích hoạt</option>
										<option value="2" {{ isset($data->status )&&($data->status == 2) ? 'selected' : '' }}>Lưu nháp</option>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
									<button class="btn btn-secondary"
											type="submit"
											name="continue_edit" value="1"
											style="margin-top: 20px"
									>
										Lưu và chỉnh sửa
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection