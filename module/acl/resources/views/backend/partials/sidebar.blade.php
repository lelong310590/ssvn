@php
	$currentUser = Auth::user();
	$currentRole = $currentUser->roles()->first();
	$perms = $currentRole->perms()->select('name')->get();
	$permsArray = [];
	foreach ($perms as $p) {
		$permsArray[] = $p['name'];
	}
@endphp

@if (in_array('role_index', $permsArray) && in_array('role_create', $permsArray) && in_array('permission_index', $permsArray))
@inject('permRepository', 'Acl\Repositories\PermissionRepository')
@inject('roleRepository', 'Acl\Repositories\RoleRepository')

	@if (in_array('role_index', $permsArray) && in_array('role_create', $permsArray))
	<li class="nav-item">
		<a href="javascript:void(0)" class="menudropdown nav-link">Vai trò <span class="badge badge-primary ml-2">{{count($roleRepository->all())}}</span>
			<i class="fa fa-angle-down "></i>
		</a>
		<ul class="nav flex-column nav-second-level">
			<li class=" nav-item"><a  href="{{ route('nqadmin::role.index.get') }}" class="nav-link "><i class="fa fa-th-list"></i> Danh sách</a></li>
			<li class=" nav-item"><a  href="{{ route('nqadmin::role.create.get') }}" class="nav-link "><i class="fa fa-plus-circle"></i> Thêm mới</a></li>
		</ul>
	</li>
	@endif

	@if (in_array('permission_index', $permsArray))
	<li class="nav-item">
		<a class="nav-link" href="{{route('nqadmin::permission.index.get')}}">
			Danh sách quyền <span class="badge badge-danger ml-2">{{count($permRepository->all())}}</span>
		</a>
	</li>
	@endif
@endif
