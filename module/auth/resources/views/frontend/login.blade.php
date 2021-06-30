<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="NQAdmin is a dashboard build for individual project">
	<meta name="author" content="lelong310590">
	<link rel="icon" href="{{ asset('adminux/favicon.ico') }}">
	<title>anticovid Dashboard by anticovid Team</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
<form action="" method="post" role="form">
	<legend>Login</legend>
	
	<div class="form-group">
		<label for=""></label>
		<input type="text" class="form-control" name="" id="" placeholder="Input...">
	</div>
	
	<div class="form-group">
		<label for=""></label>
		<input type="text" class="form-control" name="" id="" placeholder="Input...">
	</div>
	
	<a href="{{route('front.sociallogin.redirect', 'facebook')}}">FB</a>
	
	<button type="submit" class="btn btn-primary">Login</button>
</form>
<div id="example"></div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>