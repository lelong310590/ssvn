@extends('nqadmin-dashboard::backend.master')
@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Cấu hình khoá học</h3>
					<p>Tạo Khóa đào tạo, Chứng chỉ, Công ty, trình độ, ...</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block success" href="{{route('nqadmin::course.index.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Danh sách Khóa đào tạo</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Danh sách các Khóa đào tạo trong hệ thống</span></div>
						</div>
						<i class="bg-icon text-center fa fa-graduation-cap"></i>
					</a>
				</div>
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block success" href="{{route('nqadmin::course.create.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Thêm Khóa đào tạo mới</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Thêm Khóa đào tạo mới vào hệ thống</span></div>
						</div>
						<i class="bg-icon text-center fa fa-graduation-cap"></i>
					</a>
				</div>
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block warning" href="{{route('nqadmin::classlevel.index.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Quản trị Công ty</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Xem danh sách, thêm, sửa, xóa Công ty</span></div>
						</div>
						<i class="bg-icon text-center fa fa-sitemap"></i>
					</a>
				</div>
				
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block danger" href="{{route('nqadmin::subject.index.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Quản trị Chứng chỉ</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Xem danh sách, thêm, sửa, xóa Chứng chỉ</span></div>
						</div>
						<i class="bg-icon text-center fa fa-book"></i>
					</a>
				</div>
				
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block primary" href="{{route('nqadmin::level.index.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Quản trị trình độ</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Xem danh sách, thêm, sửa, xóa trình độ</span></div>
						</div>
						<i class="bg-icon text-center fa fa-level-up"></i>
					</a>
				</div>
				
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block danger" href="{{route('nqadmin::pricetier.index.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Quản trị tầng giá</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Xem danh sách, thêm, sửa, xóa tầng giá</span></div>
						</div>
						<i class="bg-icon text-center fa fa-dollar"></i>
					</a>
				</div>

				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block primary" href="{{route('nqadmin::course.enable.list')}}">
						<div class="media">
							<div class="media-body">
								<h5>Duyệt Khóa đào tạo</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Xem danh sách, duyệt Khóa đào tạo</span></div>
						</div>
						<i class="bg-icon text-center fa fa-level-up"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection