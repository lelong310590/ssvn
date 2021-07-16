@extends('nqadmin-dashboard::backend.master')

@section('content')
	
<div class="wrapper-content">
	<div class="container">
		<div class="row  align-items-center justify-content-between">
			<div class="col-11 col-sm-12 page-title">
				<h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
				<p>Sửa tài khoản {{$data->email}}</p>
			</div>
		</div>
		
		<form method="post" autocomplete="off">
			
			@if (count($errors) > 0)
				@foreach($errors->all() as $e)
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					<strong>Lỗi!</strong> {{$e}}
				</div>
				@endforeach
			@endif
			
			{!! \Base\Supports\FlashMessage::renderMessage('edit') !!}
			{!! \Base\Supports\FlashMessage::renderMessage('create') !!}
			
			{{csrf_field()}}
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								Sửa tài khoản
								@if (Auth::id() == $data->id)
									@if (empty(Auth::user()->google2fa_secret))
										<a href="{{route('nqadmin::2fa.enable')}}" class="btn btn-warning pull-right">
											<i class="fa fa-lock" aria-hidden="true"></i> Bật xác minh 2 lớp
										</a>
										<a href="{{route('nqadmin::users.index.get')}}" class="btn btn-primary pull-right">
											<i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách tài khoản
										</a>
										<a href="{{route('nqadmin::users.create.get')}}" class="btn btn-primary pull-right">
											<i class="fa fa-plus" aria-hidden="true"></i> Thêm tài khoản
										</a>
									@else
										<a href="{{route('nqadmin::2fa.disable', ['id' => $data->id])}}" class="btn btn-secondary pull-right">
											<i class="fa fa-unlock" aria-hidden="true"></i> Tắt xác minh 2 lớp
										</a>
									@endif
								@endif
							</h5>
						</div>
						<div class="card-body">

							<div class="form-group">
								<label class="form-control-label">CCCD/CMND <span class="text-danger">*</span></label>
								<input type="text"
									   class="form-control"
									   value="{{$data->citizen_identification}}"
									   name="citizen_identification"
									   required
								>
							</div>

							<div class="row">
								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Đổi mật khẩu</label>
										<input type="password"
											   class="form-control"
											   autocomplete="off"
											   data-parsley-minlength="6"
											   name="password"
											   id="password"
											   placeholder="******"
										>
									</div>
								</div>
								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Nhập lại mật khẩu</label>
										<input data-parsley-equalto="#password"
											   type="password"
											   class="form-control"
											   id="re_password"
											   autocomplete="off"
											   data-parsley-minlength="6"
											   name="re_password"
											   placeholder="******"
										>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Họ <span class="text-danger">*</span></label>
										<input type="text"
											   class="form-control"
											   required
											   data-parsley-pattern="[a-zA-Z0-9\s]+"
											   name="first_name"
											   value="{{$data->first_name}}"
										>
									</div>
								</div>

								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Tên và tên đệm <span class="text-danger">*</span></label>
										<input type="text"
											   class="form-control"
											   data-parsley-pattern="[a-zA-Z0-9\s]+"
											   name="last_name"
											   value="{{$data->last_name}}"
										>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Địa chỉ Email</label>
										<input type="email"
											   parsley-trigger="change"
											   class="form-control"
											   autocomplete="off"
											   name="email"
											   value="{{$data->email}}"
										>
									</div>
								</div>

								<div class="col-8">
									<div class="form-group">
										<label class="form-control-label">Số điện thoại <span class="text-danger">*</span></label>
										<input type="text"
											   class="form-control"
											   value="{{$data->phone}}"
											   name="phone"
										>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-8">
									<div class="form-group">
										<label for="example-date-input" class="form-control-label">Ngày/Tháng/Năm sinh <span class="text-danger">*</span></label>
										<input class="form-control" type="date" value="{{$data->dob != null ? $data->dob->format('Y-m-d') : ''}}" name="dob">
									</div>
								</div>
								<div class="col-8">
									<label class="form-control-label">Giới tính</label>
									<select class="custom-select form-control" name="sex">
										<option value="male" {{ ($data->sex == 'male') ? 'selected' : '' }}>Nam</option>
										<option value="female" {{ ($data->sex == 'female') ? 'selected' : '' }}>Nữ</option>
										<option value="other" {{ ($data->sex == 'other') ? 'selected' : '' }}>Khác</option>
									</select>
								</div>
							</div>

{{--							@if (Auth::id() != $data->id)--}}
{{--								@php--}}
{{--									$currentRole = !empty($data->roles()->first()) ? $data->roles()->first()->id : 0;--}}
{{--								@endphp--}}
{{--							<div class="form-group">--}}
{{--								<label class="form-control-label">Vai trò</label>--}}
{{--								<select class="custom-select form-control" name="role">--}}
{{--									@foreach($role as $r)--}}
{{--										<option value="{{$r->id}}" {{ ($currentRole == $r->id) ? 'selected' : '' }}>--}}
{{--											{{$r->display_name}}--}}
{{--										</option>--}}
{{--									@endforeach--}}
{{--								</select>--}}
{{--							</div>--}}
{{--							@else--}}
{{--								<input type="hidden" value="{{$data->roles()->first()->id}}" name="role">--}}
{{--							@endif--}}
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
								<select class="custom-select form-control" name="status">
									<option value="active" {{ ($data->status == 'active') ? 'selected' : '' }}>Kích hoạt</option>
									<option value="disable" {{ ($data->status == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
								</select>
							</div>

							<div class="form-group">
								<label class="form-control-label">Thành viên của đơn vị</label>
								<select class="custom-select form-control" name="classlevel">
									<option value="">-- Chọn đơn vị ---</option>
									@foreach($classLevel as $c)
										<option value="{{$c->id}}" {{ ($data->classlevel == $c->id) ? 'selected' : '' }}>{{$c->name}} - MST: {{$c->mst}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label class="form-control-label">Phân quyền cứng ?</label>
								<select class="custom-select form-control" name="hard_role">
									<option value="1" {{$data->hard_role == '1' ? 'selected' : ''}}>Học viên</option>
									<option value="2" {{$data->hard_role == '2' ? 'selected' : ''}}>Quản lý</option>
									<option value="3" {{$data->hard_role == '3' ? 'selected' : ''}}>Chủ doanh nghiệp</option>
									<option value="4" {{$data->hard_role == '4' ? 'selected' : ''}}>Quản lý cấp sở</option>
									<option value="4" {{$data->hard_role == '5' ? 'selected' : ''}}>Quản lý cấp bộ</option>
									<option value="4" {{$data->hard_role == '99' ? 'selected' : ''}}>Vận hành viên</option>
								</select>
							</div>

{{--							<div class="form-group">--}}
{{--								<label class="form-control-label">Là tài khoản doanh nghiệp ?</label>--}}
{{--								<select class="custom-select form-control" name="is_enterprise">--}}
{{--									<option value="0" {{$data->is_enterprise == 0 ? 'selected' : ''}}>Không</option>--}}
{{--									<option value="1" {{$data->is_enterprise == 1 ? 'selected' : ''}}>Có</option>--}}
{{--								</select>--}}
{{--							</div>--}}

							<div class="form-group">
								<button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
							</div>
						</div>
					</div>
					
					@include('nqadmin-dashboard::backend.components.thumbnail')
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
