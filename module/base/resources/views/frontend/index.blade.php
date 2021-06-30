@extends('nqadmin-dashboard::frontend.master')

@section('content')

<div class="main-page">
	@include('nqadmin-dashboard::frontend.components.banner')

	@include('nqadmin-dashboard::frontend.components.courselist')

	<div class="vj-downloadapp">
		<div class="container">
			<h3>Học từ mọi nơi</h3>
			<p>Tham gia các khóa đào tạo khi đang di chyuển bằng ứng dụng anticovid — truyền trực tuyến trên máy bay, tàu điện ngầm hoặc bất cứ nơi nào bạn học tốt nhất</p>
			<a href="#" target="_blank"><img alt="Tải nội dung trên Google Play" src="https://vietjack.com/git/images/android.svg"></a>
			<a href="#" target="_blank"><img alt="Tải nội dung trên IOS Store" src="https://vietjack.com/git/images/ios.svg"></a>
		</div>
	</div>
	<!--app-->

	@include('nqadmin-dashboard::frontend.components.topteacher')

	<div class="vj-statistic">
		<div class="container">
			<ul>
				<li>
					<img src="{{asset('frontend/images/icons/learners.svg')}}" />
					<p>12</p>
					<span>Triệu người đăng ký</span>
				</li>
				<li>
					<img src="{{asset('frontend/images/icons/graduates.svg')}}" />
					<p>12</p>
					<span>Triệu người học</span>
				</li>
				<li>
					<img src="{{asset('frontend/images/icons/courses.svg')}}" />
					<p>12</p>
					<span>Triệu bài học</span>
				</li>
				<li>
					<img src="{{asset('frontend/images/icons/countries.svg')}}" />
					<p>12</p>
					<span>Triệu Khóa đào tạo</span>
				</li>
			</ul>
		</div>
	</div>
	<!--statistic-->

	@include('nqadmin-dashboard::frontend.components.level')
</div>

@endsection