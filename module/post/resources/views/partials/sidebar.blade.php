@php
    $listRoute = [
        'nqadmin::post.list.get', 'nqadmin::post.index.get', 'nqadmin::post.create.get', 'nqadmin::post.edit.get'
    ];

@endphp
<li class="nav-item {{in_array(Route::currentRouteName(), $listRoute) ? 'active' : '' }}">
    <a href="{{route('nqadmin::post.list.get')}}" class="nav-link {{in_array(Route::currentRouteName(), $listRoute) ? 'active' : '' }}">
        <i class="fa fa-edit" aria-hidden="true"></i> Bài viết
    </a>
</li>
