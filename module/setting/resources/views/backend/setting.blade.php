@extends('nqadmin-dashboard::backend.master')
@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Cấu hình chung</h3>
					<p>Tạo thông báo, cấu hình chung cho hệ thống</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block success" href="{{route('nqadmin::setting.top.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Thông báo Top</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Chỉnh sửa thông báo top</span></div>
						</div>
						<i class="bg-icon text-center fa fa-graduation-cap"></i>
					</a>
				</div>
				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block success" href="{{route('nqadmin::setting.sale.get')}}">
						<div class="media">
							<div class="media-body">
								<h5>Giảm giá Khóa đào tạo</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Cấu hình giảm giá các Khóa đào tạo</span></div>
						</div>
						<i class="bg-icon text-center fa fa-graduation-cap"></i>
					</a>
				</div>

				<div class="col-md-8 col-lg-8 col-xl-4">
					<a class="activity-block danger" href="{{route('nqadmin::seo.index')}}">
						<div class="media">
							<div class="media-body">
								<h5>Cấu hình SEO</h5>
							</div>
						</div>
						<br>
						<div class="media">
							<div class="media-body"><span class="progress-heading">Cấu hình SEO</span></div>
						</div>
						<i class="bg-icon text-center fa fa-graduation-cap"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection