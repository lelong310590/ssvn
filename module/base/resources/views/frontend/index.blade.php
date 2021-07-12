@extends('nqadmin-dashboard::frontend.master')

@section('content')

<div class="main-page">
	@include('nqadmin-dashboard::frontend.components.banner')

	@include('nqadmin-dashboard::frontend.components.courselist')

	<div class="vj-downloadapp">
		<div class="container">
			<img src="{{asset('frontend/images/download-app.jpg')}}" alt="" class="img-responsive">
		</div>
	</div>
</div>

@endsection