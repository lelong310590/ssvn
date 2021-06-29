@php
	$actionRoute = \Route::current()->action['prefix'];
	$check = explode('/', $actionRoute);
	$check = end($check);
@endphp

<li class="nav-item">
	<a href="{{route('nqadmin::setting.index.get')}}" class="nav-link"><i class="fa fa-cog" aria-hidden="true"></i> Cấu hình Chung</a>
</li>
