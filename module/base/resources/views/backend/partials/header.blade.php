<header class="navbar-fixed">
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-faded">
		<div class="sidebar-left"> <a class="navbar-brand imglogo" href="{{route('nqadmin::dashboard.index.get')}}"></a>
			<button class="btn btn-link icon-header mr-sm-2 pull-right menu-collapse" ><span class="fa fa-bars"></span></button>
		</div>
		<div class="d-flex mr-auto"> &nbsp;</div>

		
		@php
			$user = auth('nqadmin')->user();
			$userId = $user->id;
			$avatar = $user->thumbnail;
			$email = $user->email;
		@endphp
		<div class="sidebar-right pull-right " >
			<ul class="navbar-nav  justify-content-end">
				<li class="nav-item">
					<button class="btn-link btn userprofile"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="userpic">
						@if (!empty($user->thumbnail))
							<img src="{{ asset($avatar) }}" alt="user pic">
						@else
							<img src="{{asset('adminux/img/user-header.png')}}" alt="">
						@endif
					</span> <span class="text">{{ $email }}</span></button>
				</li>
				<li><a href="{{ route('nqadmin::auth.logout.get') }}" class="btn btn-link icon-header" ><span class="fa fa-sign-out"></span></a></li>
			</ul>
		</div>
	</nav>
</header>