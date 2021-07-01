@php
	$currentUser = Auth::user();
	$currentRole = $currentUser->roles()->first();
	$perms = ($currentRole != null) ? $currentRole->perms()->select('name')->get() : [];
	
	$permsArray = [];
	foreach ($perms as $p) {
		$permsArray[] = $p['name'];
	}
@endphp
<li class="nav-item">
	<a href="{{route('nqadmin::users.setting.get')}}" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> Cấu hình tài khoản</a>
</li>
@if (in_array('user_index', $permsArray) && in_array('user_create', $permsArray))

	{{--<li class="nav-item">--}}
		{{--<a href="javascript:void(0)" class="menudropdown nav-link">Tài khoản <span class="badge badge-primary ml-2">{{count($userRepository->all())}}</span>--}}
			{{--<i class="fa fa-angle-down "></i>--}}
		{{--</a>--}}
		{{--<ul class="nav flex-column nav-second-level">--}}
			{{--@if (in_array('user_index', $permsArray))--}}
			{{--<li class=" nav-item"><a  href="{{ route('nqadmin::users.index.get') }}" class="nav-link "><i class="fa fa-th-list"></i> Danh sách</a></li>--}}
			{{--@endif--}}
			{{----}}
			{{--@if (in_array('user_create', $permsArray))--}}
			{{--<li class=" nav-item"><a  href="{{ route('nqadmin::users.create.get') }}" class="nav-link "><i class="fa fa-plus-circle "></i> Thêm mới</a></li>--}}
			{{--@endif--}}
		{{--</ul>--}}
	{{--</li>--}}
	
	{{--@php do_action('nqadmin-register-acl-menu') @endphp--}}
@endif
