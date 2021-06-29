@extends('nqadmin-dashboard::backend.master')

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Vai trò</h3>
					<p>Thêm vai trò</p>
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
								<h5 class="card-title">Thêm vai trò mới
									<a href="{{route('nqadmin::role.index.get')}}" class="btn btn-primary pull-right">
										<i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách vai trò
									</a>
								</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<div class="form-group">
										<label class="form-control-label">Tên vai trò</label>
										<input type="text"
										       required
										       parsley-trigger="change"
										       class="form-control"
										       autocomplete="off"
										       name="display_name"
										       value="{{old('display_name')}}"
										       id="input_name"
										       onkeyup="ChangeToSlug();"
										>
									</div>
								</div>
								
								<div class="form-group">
									<div class="form-group">
										<label class="form-control-label">Slug vai trò</label>
										<input type="text"
										       required
										       parsley-trigger="change"
										       class="form-control"
										       autocomplete="off"
										       name="name"
										       value="{{old('name')}}"
										       id="input_slug"
										>
										<small class="form-text text-muted">Slug vai trò không sử dụng tiếng Việt có dấu, không sử dụng dấu cách và chữ viết hoa. Slug sẽ không thể thay đổi được</small>
									</div>
								</div>
								
								<div class="form-group">
									<div class="form-group">
										<label class="form-control-label">Miêu tả</label>
										<input type="text"
										       class="form-control"
										       autocomplete="off"
										       name="description"
										       value="{{old('description')}}"
										>
									</div>
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