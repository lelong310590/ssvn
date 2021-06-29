@php
    $actionRoute = \Route::current()->action['prefix'];
    $check = explode('/', $actionRoute);
    $check = end($check);
@endphp

<li class="nav-item">
    <a href="{{route('nqadmin::post.listitem')}}" class="nav-link"><i class="fa fa-edit" aria-hidden="true"></i> Bài viết</a>
</li>