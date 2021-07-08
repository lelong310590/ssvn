@extends('nqadmin-dashboard::backend.master')
@section('content')

@php
	$user = Auth::user();
	$roles = $user->load('roles.perms');
	$currentRole = $roles->roles->first()->name;
@endphp

<div class="wrapper-content">
	<div class="container">
		<div class="row  align-items-center justify-content-between">
			<div class="col-11 col-sm-12 page-title">
				<h3>Bảng điều khiển</h3>
			</div>
		</div>

{{--		@if ($currentRole == 'administrator')--}}
			<div class="row">
				<div class="col-md-8 col-lg-8 col-xl-4">
					<div class="activity-block success">
						<div class="media">
							<div class="media-body">
								<h5><span>{{$classLevel->count()}}</span></h5>
								<p>Đơn vị đăng ký</p>
							</div>
							<i class="fa fa-cubes"></i> </div>
						<br>

						<div class="row">
							<div class="progress ">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 70%;"><span class="trackerball"></span></div>
							</div>
						</div>
						<i class="bg-icon text-center fa fa-cubes"></i> </div>
				</div>

				<div class="col-md-8 col-lg-8 col-xl-4">
					<div class="activity-block danger">
						<div class="media">
							<div class="media-body">
								<h5><span class="spincreament">{{$activeUser}}</span></h5>
								<p>Tài khoản hoạt động</p>
							</div>
							<i class="fa fa-users"></i> </div>
						<br>

						<div class="row">
							<div class="progress ">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="trackerball"></span></div>
							</div>
						</div>
						<i class="bg-icon text-center fa fa-users"></i> </div>
				</div>

				<div class="col-md-8 col-lg-8 col-xl-4">
					<div class="activity-block primary">
						<div class="media">
							<div class="media-body">
								<h5><span class="spincreament">{{$courseInMonth}}</span></h5>
								<p>Khóa đào tạo mới trong tháng</p>
							</div>
							<i class="fa fa-graduation-cap"></i>
						</div>
						<br>

						<div class="row">
							<div class="progress ">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="trackerball"></span></div>
							</div>
						</div>
						<i class="bg-icon text-center fa fa-envelope"></i>
					</div>
				</div>

				<div class="col-md-8 col-lg-8 col-xl-4">
					<div class="activity-block warning">
						<div class="media">
							<div class="media-body">
								<h5><span class="spincreament">{{$courseInMonth}}</span></h5>
								<p>Bài trắc nghiệm</p>
							</div>
							<i class="fa fa-graduation-cap"></i>
						</div>
						<br>

						<div class="row">
							<div class="progress ">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="trackerball"></span></div>
							</div>
						</div>
						<i class="bg-icon text-center fa fa-envelope"></i>
					</div>
				</div>
			</div>
{{--		@endif--}}

{{--		<div class="row mt-lg-4">--}}
{{--			<div class="col-md-16">--}}
{{--				<div class="row">--}}
{{--					<div class="col-md-4">--}}
{{--						<div class="filter-form">--}}
{{--							<div class="card">--}}
{{--								<div class="card-header">--}}
{{--									<h6 class="card-title">Tra cứu thống kê từng doanh nghiệp</h6>--}}
{{--								</div>--}}
{{--								<div class="card-body">--}}
{{--									<form action="">--}}
{{--										<div class="form-group">--}}
{{--											<label for="company_id" class="col-4 col-form-label">Đơn vị</label>--}}
{{--											<select name="company_id" class="form-control" id="company_id" data-ajax="{{route('ajax.get-course-in-company')}}">--}}
{{--												<option value="">-- Chọn đơn vị --</option>--}}
{{--												@foreach($classLevel as $level)--}}
{{--													<option value="{{$level->id}}" {{request()->get('company_id') == $level->id ? 'selected' : ''}}>--}}
{{--														{{$level->name}} - MST: {{$level->mst}}--}}
{{--													</option>--}}
{{--												@endforeach--}}
{{--											</select>--}}
{{--										</div>--}}

{{--										<div class="form-group">--}}
{{--											<label for="course_id" class="col-form-label">Chương trình đào tạo trong đơn vị</label>--}}
{{--											<select name="course_id" class="form-control" id="course_id">--}}
{{--												<option value="">-- Chọn khóa học --</option>--}}
{{--											</select>--}}
{{--										</div>--}}
{{--										<button type="submit" class="btn btn-primary">Tra cứu</button>--}}
{{--									</form>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					@if (request()->get('company_id') != null)--}}
{{--						@php--}}
{{--							$employers = $detail['employers'];--}}
{{--                            $courseInCompany = $detail['courseInCompany'];--}}
{{--                            $currentCompany = $detail['currentCompany'];--}}
{{--                            $selectedCourse = isset($detail['selectedCourse']) ? $detail['selectedCourse'] : false;--}}
{{--                            $totalUserInCompany = isset($detail['totalUserInCompany']) ? $detail['totalUserInCompany'] : 0;--}}
{{--                            $registerdUser = isset($detail['registerdUser']) ? $detail['registerdUser'] : 0;--}}
{{--						@endphp--}}
{{--						<div class="col-md-12">--}}
{{--							<div class="row">--}}
{{--								<div class="col-16">--}}
{{--									<h5>Thông tin về đơn vị: {{$currentCompany->name}} - MST: {{$currentCompany->mst}}</h5>--}}
{{--								</div>--}}
{{--								<div class="col-8 text-center">--}}
{{--									<div class="activity-block">--}}
{{--										<div class="media">--}}
{{--											<div class="media-body">--}}
{{--												<h5><span class="spincreament" style="opacity: 1;">{{number_format($employers->count())}}</span></h5>--}}
{{--												<p>Tổng số nhân sự</p>--}}
{{--											</div>--}}
{{--											<i class="fa fa-users text-success"></i> </div>--}}
{{--										<br>--}}
{{--										<div class="media">--}}
{{--											<div class="media-body"><span class="progress-heading">Nhân sự đang hoạt động trong đơn vị</span></div>--}}
{{--											<span><span class="dynamicsparkline"><canvas style="display: inline-block; width: 90px; height: 20px; vertical-align: top;" width="90" height="20"></canvas></span> </span> </div>--}}
{{--										<i class="bg-icon text-right fa fa-users  text-success"></i>--}}
{{--									</div>--}}
{{--								</div>--}}

{{--								<div class="col-8 text-center">--}}
{{--									<div class="activity-block">--}}
{{--										<div class="media">--}}
{{--											<div class="media-body">--}}
{{--												<h5><span class="spincreament" style="opacity: 1;">{{number_format($courseInCompany->count())}}</span></h5>--}}
{{--												<p>Khóa đào tạo</p>--}}
{{--											</div>--}}
{{--											<i class="fa fa-bookmark  text-primary"></i> </div>--}}
{{--										<br>--}}
{{--										<div class="media">--}}
{{--											<div class="media-body"><span class="progress-heading">Các chương trình đào tạo trong đơn vị</span></div>--}}
{{--											<span><span class="dynamicsparkline"><canvas style="display: inline-block; width: 90px; height: 20px; vertical-align: top;" width="90" height="20"></canvas></span> </span> </div>--}}
{{--										<i class="bg-icon text-right fa fa-bookmark   text-primary"></i>--}}
{{--									</div>--}}
{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="row">--}}
{{--								@if (request()->get('course_id') != null && $selectedCourse != false)--}}
{{--									<div class="col-8">--}}
{{--										<div class="card">--}}
{{--											<div class="card-header align-items-start justify-content-between flex">--}}
{{--												<h5 class="card-title  pull-left">Thống kê về khóa học <small>{{$selectedCourse->name}}</small></h5>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--										<div class="card-body">--}}
{{--											<div class="row">--}}
{{--												<div class="col-8 text-center">--}}
{{--													<div class="progress-circle progress-danger"--}}
{{--														 data-value="{{$totalUserInCompany == 0 ? 0 : $registerdUser/$totalUserInCompany}}"--}}
{{--														 data-size="140"--}}
{{--														 data-thickness="4"--}}
{{--														 data-animation-start-value="0"--}}
{{--														 data-reverse="false" ><strong></strong></div>--}}
{{--													<br>--}}
{{--													<p class="text-uppercase">Tỷ lệ lao động tham gia</p>--}}
{{--													<span>{{$registerdUser}} / {{$totalUserInCompany}}</span>--}}
{{--												</div>--}}

{{--												--}}{{--												<div class="col-8 text-center">--}}
{{--												--}}{{--													<div class="progress-circle progress-primary" data-value="0.85"  data-size="140"  data-thickness="4"  data-animation-start-value="0" data-reverse="false" ><strong></strong></div>--}}
{{--												--}}{{--													<br>--}}
{{--												--}}{{--													<p class="text-uppercase">Tỷ lệ lao động hoàn thành khóa đào tạo</p>--}}
{{--												--}}{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								@endif--}}

{{--								<div class="col-8">--}}
{{--									<div class="card full-screen-container">--}}
{{--										<div class="card-header align-items-start justify-content-between flex">--}}
{{--											<h5 class="card-title  pull-left">Các chương trình đạo tạo <small>trong đơn vị</small></h5>--}}
{{--										</div>--}}
{{--										<div class="card-body">--}}
{{--											<div class="list-unstyled comment-list" style="height:450px;">--}}
{{--												@forelse($courseInCompany->take(5)->get() as $course)--}}
{{--													<div class="media">--}}
{{--															<span class="message_userpic">--}}
{{--																@if ($course->getLdp->thumbnail == null)--}}
{{--																	<img class="d-flex" src="../img/user-header.png" alt="Generic user image">--}}
{{--																@else--}}
{{--																	<img class="d-flex" src="{{asset($course->getLdp->thumbnail)}}" alt="Generic user image">--}}
{{--																@endif--}}
{{--																<span class="user-status bg-success "></span>--}}
{{--															</span>--}}
{{--														<div class="media-body">--}}
{{--															<h6 class="mt-0 mb-1">{{$course->name}} <small class="pull-right">{{$course->created_at}}</small></h6>--}}
{{--															<p class="description">--}}
{{--																@if ($course->type == 'test')--}}
{{--																	Bài trắc nghiệm--}}
{{--																@else--}}
{{--																	Bài học--}}
{{--																@endif--}}
{{--															</p>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												@empty--}}
{{--													<div class="media">--}}
{{--															<span class="message_userpic">--}}
{{--																<span class="user-status bg-success "></span>--}}
{{--															</span>--}}
{{--														<div class="media-body">--}}
{{--															<h6 class="mt-0 mb-1">Chưa có chương trình nào</h6>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												@endforelse--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					@endif--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
	</div>
	<footer class="footer-content ">
		<div class="container ">
			<div class="row align-items-center justify-content-between">
				<div class="col-md-16 col-lg-8 col-xl-8">This template is designed by OneBit</div>
			</div>
		</div>
	</footer>
</div>

@endsection

@section('js')
<!-- Morris Charts JavaScript -->
<script src="{{asset('adminux/vendor/Chart.js/Chart.min.js')}}"></script>
<script type="text/javascript">

	/**
	 Template Name: Ubold Dashboard
	 Author: CoderThemes
	 Email: coderthemes@gmail.com
	 File: Chartjs
	 */

	!function($) {
		"use strict";

		var ChartJs = function() {};

		ChartJs.prototype.respChart = function respChart(selector,type,data, options) {
			// get selector by context
			var ctx = selector.get(0).getContext("2d");
			// pointing parent container to make chart js inherit its width
			var container = $(selector).parent();

			// enable resizing matter
			$(window).resize( generateChart );

			// this function produce the responsive Chart JS
			function generateChart(){
				// make chart width fit with its container
				var ww = selector.attr('width', $(container).width() );
				new Chart(ctx).Bar(data, options);
			};
			// run function - render chart at first load
			generateChart();
		},
			//init
			ChartJs.prototype.init = function() {
				//creating lineChart

				//barchart-Single
				var BarChartSingle = {
					labels : [
						"January","February",
						"March","April","May","June","July","August","September","October","November","December"
					],
					datasets : [
						{
							fillColor: '#ebeff2',
							strokeColor: '#ebeff2',
							highlightFill: '#5fbeaa',
							highlightStroke: '#ebeff2',
							data : [
								{{$chartData[0]}}, {{$chartData[1]}}, {{$chartData[2]}},
								{{$chartData[3]}}, {{$chartData[4]}}, {{$chartData[5]}},
								{{$chartData[6]}}, {{$chartData[7]}}, {{$chartData[8]}},
								{{$chartData[9]}}, {{$chartData[10]}}, {{$chartData[11]}},
							]
						}
					]
				}
				this.respChart($("#bar-single"),'Bar',BarChartSingle);

			},
			$.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs
	}(window.jQuery),

		jQuery(document).ready(function($) {
			//initializing
			setTimeout(function () {
				$.ChartJs.init()
			}, 1500)

		})
</script>

<script type="text/javascript" src="{{ asset('adminux/js/dashboard.js') }}"></script>
@endsection