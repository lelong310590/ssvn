<div class="mobile">
    <div class="notification clearfix">
        <a href="{{ route('front.users.my_course.get') }}">
            <i class="fas fa-shopping-cart pull-left"></i>
            <p class="overflow">Khóa đào tạo của tôi</p>
        </a>
    </div>
</div>

{{--<div class="messenger clearfix">--}}
{{--    <a href="{{ route('front.message.index.get') }}">--}}
{{--        <i class="far fa-comments pull-left"></i>--}}
{{--        <p class="overflow">Tin nhắn của tôi</p>--}}
{{--    </a>--}}
{{--</div>--}}

{{--<div class="history clearfix">--}}
{{--    <a href="{{ route('front.users.history.get') }}">--}}
{{--        <i class="fas fa-history pull-left"></i>--}}
{{--        <p class="overflow">Lịch sử mua hàng</p>--}}
{{--    </a>--}}
{{--</div>--}}

{{--<div class="notification clearfix">--}}
{{--    <a href="{{ route('front.users.notification.get') }}">--}}
{{--        <i class="far fa-bell pull-left"></i>--}}
{{--        <p class="overflow">Thông báo</p>--}}
{{--    </a>--}}
{{--</div>--}}

@if (Auth::check())
    @php
        $hardRole = Auth::user()->hard_role
    @endphp
    @if (intval($hardRole) == 99)
        <div class="sign-out clearfix">
            <a href="{{ route('nqadmin::dashboard.index.get') }}">
                <i class="fas fa-tachometer-alt pull-left"></i>
                <p class="overflow">Bảng điều khiển</p>
            </a>
        </div>
    @endif

    @if (intval($hardRole) > 1)
        <div class="sign-out clearfix">
            <a href="{{ route('fronts.user.stat.get') }}">
                <i class="fas fa-chart-bar pull-left"></i>
                <p class="overflow">Thống kê</p>
            </a>
        </div>
    @endif
@endif

<div class="sign-out clearfix">
    <a href="{{ route('front.logout.get') }}">
        <i class="far fa-share-square pull-left"></i>
        <p class="overflow">Đăng xuất</p>
    </a>
</div>