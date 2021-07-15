<div class="box-info-user">
    <div class="img">

        @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>Auth::user()])

    </div>
    <div class="info">
        <h4 class="name">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h4>
    </div>
</div>
<!--box-info-user-->
<div class="list-menu-user">
    <ul>
        <li><a href="{{ route('front.users.info.get') }}" class="{{ strpos(url()->full(), route('front.users.info.get')) !== false?'active':'' }}">Thông tin cá nhân </a></li>
        @if (auth('nqadmin')->user()->hard_role < 2)
            <li><a href="{{ route('front.users.my_course.get') }}" class="{{ strpos(url()->full(), route('front.users.my_course.get')) !== false?'active':'' }}">Khóa đào tạo</a></li>
        @endif

        <li><a href="{{ route('fronts.user.stat.get') }}" class="{{ strpos(url()->full(), route('fronts.user.stat.get')) !== false?'active':'' }}">Thống kê</a></li>
{{--        <li><a href="{{ route('front.users.notification.get') }}" class="{{ strpos(url()->full(), route('front.users.notification.get')) !== false?'active':'' }}">Thông báo</a></li>--}}
        @if (auth('nqadmin')->user()->hard_role < 3)
            <li><a href="{{ route('front.users.certificate.get') }}" class="{{ strpos(url()->full(), route('front.users.certificate.get')) !== false?'active':'' }}">Chứng chỉ</a></li>
        @endif

        @if (auth('nqadmin')->user()->hard_role == 2 || auth('nqadmin')->user()->hard_role == 3)
            <li><a href="{{ route('front.users.employers.get') }}" class="{{ strpos(url()->full(), route('front.users.employers.get')) !== false?'active':'' }}">Người lao động</a></li>
        @endif
{{--        <li><a href="{{ route('front.users.history.get') }}" class="{{ strpos(url()->full(), route('front.users.history.get')) !== false?'active':'' }}">Lịch sử mua hàng</a></li>--}}
        <li><a href="{{ route('front.users.change_password.get') }}" class="{{ strpos(url()->full(), route('front.users.change_password.get')) !== false?'active':'' }}">Thay đổi mật khẩu</a></li>
    </ul>
</div>