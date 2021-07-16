@extends('nqadmin-dashboard::backend.master')

@section('content')
	
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
					<p>Thêm tài khoản mới</p>
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
							<div class="card-header">
								<h5 class="card-title">Thêm tài khoản mới
									<a href="{{route('nqadmin::users.index.get')}}" class="btn btn-primary pull-right">
										<i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách tài khoản
									</a>
								</h5>
							</div>
							<div class="card-body">

								<div class="form-group">
									<label class="form-control-label">CCCD/CMND <span class="text-danger">*</span></label>
									<input type="text"
										   class="form-control"
										   value="{{old('citizen_identification')}}"
										   name="citizen_identification"
										   required
									>
								</div>

								<div class="row">
									<div class="col-8">
										<div class="form-group">
											<label class="form-control-label">Mật khẩu <span class="text-danger">*</span></label>
											<input type="password"
												   required
												   class="form-control"
												   autocomplete="off"
												   data-parsley-minlength="6"
												   name="password"
												   id="password"
											>
										</div>
									</div>
									<div class="col-8">
										<div class="form-group">
											<label class="form-control-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
											<input data-parsley-equalto="#password"
												   type="password"
												   required
												   class="form-control"
												   id="re_password"
												   autocomplete="off"
												   data-parsley-minlength="6"
												   name="re_password"
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
												   value="{{old('first_name')}}"
											>
										</div>
									</div>

									<div class="col-8">
										<div class="form-group">
											<label class="form-control-label">Tên và tên đệm <span class="text-danger">*</span></label>
											<input type="text"
												   class="form-control"
												   required
												   data-parsley-pattern="[a-zA-Z0-9\s]+"
												   name="last_name"
												   value="{{old('last_name')}}"
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
												   value="{{old('email')}}"
											>
										</div>
									</div>
									<div class="col-8">
										<div class="form-group">
											<label class="form-control-label">Số điện thoại <span class="text-danger">*</span></label>
											<input type="text"
												   class="form-control"
												   value="{{old('phone')}}"
												   name="phone"
											>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-8">
										<div class="form-group">
											<label for="example-date-input" class="form-control-label">Ngày/Tháng/Năm sinh <span class="text-danger">*</span></label>
											<input class="form-control" type="date" value="{{old('dob')}}" name="dob" id="example-date-input" max="{{date('Y-m-d')}}">
										</div>
									</div>
									<div class="col-8">
										<label class="form-control-label">Giới tính</label>
										<select class="custom-select form-control" name="sex">
											<option value="male" {{ (old('sex') == 'male') ? 'selected' : '' }}>Nam</option>
											<option value="female" {{ (old('sex') == 'female') ? 'selected' : '' }}>Nữ</option>
											<option value="other" {{ (old('sex') == 'other') ? 'selected' : '' }}>Khác</option>
										</select>
									</div>
								</div>

								
{{--							<div class="form-group">--}}
{{--									<label class="form-control-label">Vai trò</label>--}}
{{--									<select class="custom-select form-control" name="role">--}}
{{--										@foreach($role as $r)--}}
{{--											<option value="{{$r->id}}" {{ (old('role') == $r->id) ? 'selected' : '' }}>{{$r->display_name}}</option>--}}
{{--										@endforeach--}}
{{--									</select>--}}
{{--								</div>--}}
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
									<label class="form-control-label">Thành viên của đơn vị</label>
									<select class="custom-select form-control" name="classlevel">
										<option value="">-- Chọn đơn vị ---</option>
										@foreach($classLevel as $c)
											<option value="{{$c->id}}" {{ (old('classLevel') == $c->id) ? 'selected' : '' }}>{{$c->name}} - MST: {{$c->mst}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label class="form-control-label">Phân quyền cứng ?</label>
									<select class="custom-select form-control" name="hard_role">
										<option value="1" {{old('hard_role') == '1' ? 'selected' : ''}}>Học viên</option>
										<option value="2" {{old('hard_role') == '2' ? 'selected' : ''}}>Quản lý đơn vị</option>
										<option value="3" {{old('hard_role') == '3' ? 'selected' : ''}}>Chủ đơn vị</option>
										<option value="4" {{old('hard_role') == '4' ? 'selected' : ''}}>Quản lý cấp Sở</option>
										<option value="5" {{old('hard_role') == '5' ? 'selected' : ''}}>Quản lý cấp Bộ</option>
										<option value="5" {{old('hard_role') == '99' ? 'selected' : ''}}>Vận hành viên</option>
									</select>
								</div>

{{--								<div class="form-group">--}}
{{--									<label class="form-control-label">Là tài khoản doanh nghiệp ?</label>--}}
{{--									<select class="custom-select form-control" name="is_enterprise">--}}
{{--										<option value="0" {{old('is_enterprise') == '0' ? 'selected' : ''}}>Không</option>--}}
{{--										<option value="1" {{old('is_enterprise') == '1' ? 'selected' : ''}}>Có</option>--}}
{{--									</select>--}}
{{--								</div>--}}

								<div class="form-group">
									<label class="form-control-label">Trạng thái </label>
									<select class="custom-select form-control" name="status">
										<option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Kích hoạt</option>
										<option value="disable" {{ (old('status') == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
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
						
						@include('nqadmin-dashboard::backend.components.thumbnail')
					</div>
				</div>
			</form>
		</div>
	</div>
	
@endsection
