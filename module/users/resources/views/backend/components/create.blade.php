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
									<label class="form-control-label">Địa chỉ Email</label>
									<input type="email"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="email"
									       value="{{old('email')}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Mật khẩu</label>
									<input type="password"
									       required
									       class="form-control"
									       autocomplete="off"
									       data-parsley-minlength="6"
									       name="password"
									       id="password"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Nhập lại mật khẩu</label>
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
								
								<div class="form-group">
									<label class="form-control-label">Họ</label>
									<input type="text"
									       class="form-control"
									       required
									       data-parsley-pattern="[a-zA-Z0-9\s]+"
									       name="first_name"
									       value="{{old('first_name')}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Tên và tên đệm</label>
									<input type="text"
									       class="form-control"
									       required
									       data-parsley-pattern="[a-zA-Z0-9\s]+"
									       name="last_name"
									       value="{{old('last_name')}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Số điện thoại</label>
									<input type="text"
									       class="form-control"
									       value="{{old('phone')}}"
									       name="phone"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Giới tính</label>
									<select class="custom-select form-control" name="sex">
										<option value="male" {{ (old('sex') == 'male') ? 'selected' : '' }}>Nam</option>
										<option value="female" {{ (old('sex') == 'female') ? 'selected' : '' }}>Nữ</option>
										<option value="other" {{ (old('sex') == 'other') ? 'selected' : '' }}>Khác</option>
									</select>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Vai trò</label>
									<select class="custom-select form-control" name="role">
										@foreach($role as $r)
											<option value="{{$r->id}}" {{ (old('role') == $r->id) ? 'selected' : '' }}>{{$r->display_name}}</option>
										@endforeach
									</select>
								</div>
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
