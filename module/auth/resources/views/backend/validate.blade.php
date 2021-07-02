<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Tripnchill is a dashboard build for only this project">
	<meta name="author" content="lelong310590">
	<link rel="icon" href="{{ asset('adminux/favicon.ico') }}">
	<title>Tripnchill Dashboard by lelong310590</title>
	<!-- Fontawesome icon CSS -->
	<link rel="stylesheet" href="{{ asset('adminux/vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('adminux/vendor/bootstrap4beta/css/bootstrap.css') }}" type="text/css">
	
	<!-- Adminux CSS -->
	<link rel="stylesheet" href="{{ asset('adminux/css/dark_blue_adminux.css') }}" type="text/css">
</head>
<body class="menuclose menuclose-right">
<figure class="background"> <img src="{{ asset('adminux/img/login_bg.jpg') }}" alt="Adminux- sign in "> </figure>
<!-- Page Loader -->
<div class="loader_wrapper inner align-items-center text-center">
	<div class="load7 load-wrapper">
		<div class="loading_img"></div>
		<div class="loader"> Loading... </div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Page Loader Ends -->


<header class="navbar-fixed">
	<nav class="navbar navbar-toggleable-md sign-in-header">
		<div class="sidebar-left">  <a class="navbar-brand imglogo" href="index.html"></a> </div>
		<div class="col"></div>
		<div class="sidebar-right pull-right" >
			<ul class="navbar-nav  justify-content-end">
				<li><a href="#" class="btn btn-link text-white" >Trợ giúp ?</a></li>
			</ul>
		</div>
	</nav>
</header>
<div class="wrapper-content-sign-in p-0">
	<div class="col-md-8 offset-md-8 text-center side_signing_full">
		<form class="form-signin1 full_side text-white" method="post" action="{{route('nqadmin::2fa.validate.post')}}">
			{{ csrf_field() }}
			<figure class="user-login circle">
				@inject('userRepository', 'Users\Repositories\UsersRepository')
				@php
					$id = session('2fa:user:id');
					$user = $userRepository->find($id);
				@endphp
				<img src="{{asset($user->avatar)}}" alt="unlock">
			</figure>
			<label class="sr-only">Mã xác thực</label>
			@if ($errors->has('totp'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					<strong>Lỗi!</strong> Mã xác thực không đúng
				</div>
			@endif
			<div class="input-group"> <span class="input-group-addon" ><i class="fa fa-key"></i></span>
				<input type="text" class="form-control" placeholder="Nhập mã xác thực" name="totp">
			</div>
			<button type="submit" class="btn btn-lg btn-primary btn-round">Xác thực</button><br>
			<br>
		</form>
		<br>
	</div>
	<footer class="footer-content row  justify-content-between align-items-center">
		<div class="col-sm-8">Phát triển bởi <a href="#" target="_blank" class="">ONEBIT VIETNAM</a></div>
		<div class="col-sm-8 text-right"><a href="#" target="_blank" class="text-white">Chính sách</a> | <a href="#" target="_blank" class="text-white">Điều khoản sử dụng</a> </div>
	</footer>
</div>


<!-- jQuery first, then Tether, then Bootstrap JS. -->

<script src="{{ asset('adminux/js/jquery-2.1.1.min.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

<script src="{{ asset('adminux/vendor/bootstrap4beta/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!--Cookie js for theme chooser and applying it -->
<script src="{{ asset('adminux/vendor/cookie/jquery.cookie.js') }}"  type="text/javascript"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> <script src="{{ asset('adminux/js/ie10-viewport-bug-workaround.js') }}"></script> <script>
	"use strict";
	$('input[type="checkbox"]').on('change', function(){
		$(this).parent().toggleClass("active")
		$(this).closest(".media").toggleClass("active");
	});
	$(window).on("load", function(){
		/* loading screen */
		$(".loader_wrapper").fadeOut("slow");
	});
</script>
</body>
</html>