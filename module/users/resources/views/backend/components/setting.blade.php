@extends('nqadmin-dashboard::backend.master')
@section('content')

<div class="wrapper-content">
	<div class="container">
		<div class="row  align-items-center justify-content-between">
			<div class="col-11 col-sm-12 page-title">
				<h3><i class="fa fa-sitemap "></i> Cấu hình tài khoản</h3>
				<p>Cấu hình tài khoản và phân quyền</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-lg-8 col-xl-4">
				<a class="activity-block success" href="{{route('nqadmin::users.index.get')}}">
					<div class="media">
						<div class="media-body">
							<h5>Danh sách tài khoản</h5>
						</div>
					</div>
					<br>
					<div class="media">
						<div class="media-body"><span class="progress-heading">Danh sách các tài khoản trong hệ thống</span></div>
					</div>
					<i class="bg-icon text-center fa fa-users"></i>
				</a>
			</div>
			<div class="col-md-8 col-lg-8 col-xl-4">
				<a class="activity-block success" href="{{route('nqadmin::users.create.get')}}">
					<div class="media">
						<div class="media-body">
							<h5>Thêm tài khoản mới</h5>
						</div>
					</div>
					<br>
					<div class="media">
						<div class="media-body"><span class="progress-heading">Thêm tài khoản mới vào hệ thống</span></div>
					</div>
					<i class="bg-icon text-center fa fa-users"></i>
				</a>
			</div>
{{--			<div class="col-md-8 col-lg-8 col-xl-4">--}}
{{--				<a class="activity-block warning" href="{{route('nqadmin::role.index.get')}}">--}}
{{--					<div class="media">--}}
{{--						<div class="media-body">--}}
{{--							<h5>Danh sách các vai trò</h5>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<br>--}}
{{--					<div class="media">--}}
{{--						<div class="media-body"><span class="progress-heading">Danh sách các vai trò trong hệ thống</span></div>--}}
{{--					</div>--}}
{{--					<i class="bg-icon text-center fa fa-empire"></i>--}}
{{--				</a>--}}
{{--			</div>--}}
{{--			--}}
{{--			<div class="col-md-8 col-lg-8 col-xl-4">--}}
{{--				<a class="activity-block warning" href="{{route('nqadmin::role.create.get')}}">--}}
{{--					<div class="media">--}}
{{--						<div class="media-body">--}}
{{--							<h5>Thêm vai trò mới</h5>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<br>--}}
{{--					<div class="media">--}}
{{--						<div class="media-body"><span class="progress-heading">Thêm mới vai trò người dùng</span></div>--}}
{{--					</div>--}}
{{--					<i class="bg-icon text-center fa fa-empire"></i>--}}
{{--				</a>--}}
{{--			</div>--}}
{{--			--}}
{{--			<div class="col-md-8 col-lg-8 col-xl-4">--}}
{{--				<a class="activity-block primary" href="{{route('nqadmin::permission.index.get')}}">--}}
{{--					<div class="media">--}}
{{--						<div class="media-body">--}}
{{--							<h5>Danh sách quyền</h5>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<br>--}}
{{--					<div class="media">--}}
{{--						<div class="media-body"><span class="progress-heading">Danh sách các quyền trong hệ thống</span></div>--}}
{{--					</div>--}}
{{--					<i class="bg-icon text-center fa fa-key"></i>--}}
{{--				</a>--}}
{{--			</div>--}}
		</div>
	</div>
</div>

@endsection