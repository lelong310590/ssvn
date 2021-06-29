@php
    $route = Route::currentRouteName();
@endphp

<ul class="nav flex-column course-nav" id="side-menu">
    <li class="nav-item {{$route == 'nqadmin::course.landingpage.get' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('nqadmin::course.landingpage.get', $course->id)}}">Trang hiển thị</a>
    </li>
    <li class="nav-item {{$route == 'nqadmin::course.target.get' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('nqadmin::course.target.get', $course->id)}}">Mục tiêu Khóa đào tạo</a>
    </li>
    <li class="nav-item {{$route == 'nqadmin::course.curriculum.get' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('nqadmin::course.curriculum.get', $course->id)}}">Chương trình học</a>
    </li>
    <li class="nav-item {{$route == 'nqadmin::course.price.get' ? 'active' : ''}}">
        <a class="nav-link" href="{{route('nqadmin::course.price.get', $course->id)}}">Giá & Khuyến mại</a>
    </li>
</ul>