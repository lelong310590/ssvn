@php
    use ClassLevel\Models\ClassLevel;

    $classes = Cache::remember('classes', 60 * 60 * 24, function () {
        return ClassLevel::with('subject')->get();
    });

@endphp

<header class="main">
    <div class="container">
        <div class="header-wrapper">
            <a href="{{route('front.home.index.get')}}" class="logo">
                <img src="{{asset('frontend/images/icons/logo.png')}}" alt="anticovid" title="Khóa đào tạo" />
            </a>

            @if (!Auth::check())
            <div class="mobile-action hidden-md hidden-lg">
                <a href="#login-box" class="btn-link btn-popup">Đăng nhập</a>
            </div>
            @endif
        </div>
        <nav class="main">
            {{--            <a href="javascript:void(0)" class="mb_menu_close"><i class="fal fa-times"></i></a>--}}
            {{--            <div class="menu">--}}
            {{--                <ul class="menu-main">--}}
            {{--                    <li>--}}
            {{--                        <a href="javascript:void(0)">Danh mục <i class="far fa-chevron-down"></i></a>--}}
            {{--                        @if (Agent::isDesktop())--}}
            {{--                        <ul class="menu-sub">--}}
            {{--                            @foreach($classes as $class)--}}
            {{--                            <li>--}}
            {{--                                <h5><a href="{{ route('front.classlevel.index.get', ['slug' => $class->slug]) }}">{{ $class->name }}</a></h5>--}}
            {{--                                <ul>--}}
            {{--                                    @foreach($class->subject as $sub)--}}
            {{--                                        <li><a href="{{route('front.subject.index.get', ['class' => $class->slug, 'subject' => $sub->slug])}}">{{ $sub->name }}</a></li>--}}
            {{--                                    @endforeach--}}
            {{--                                </ul>--}}
            {{--                            </li>--}}
            {{--                            @endforeach--}}
            {{--                        </ul>--}}
            {{--                        @endif--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </div>--}}
            <div class="support">
                <ul>
                    {{--                    <li class="vj-isteacher hidden-xs hidden-sm">--}}
                    {{--                        <a href="{{Auth::check() ? 'javascript:;' : route('front.home.trothanhgiaovien')}}">--}}
                    {{--                            {{Auth::check() ? 'Giáo viên' : 'Trở thành giáo viên'}}--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}

                    {{--<li class="vj-search">--}}
                    {{--<form method="get" action="{{ route('front.home.search') }}">--}}
                    {{--<label class="btn-search">--}}
                    {{--<input class="search-ipt" type="text" name="q" value="{{ request('q') }}" autocomplete="off"/>--}}
                    {{--<button type="submit" class="btn btn-search">--}}
                    {{--<i class="fal fa-search"></i>--}}
                    {{--</button>--}}
                    {{--</label>--}}
                    {{--</form>--}}

                    {{--<div class="box-dropdown" id="search_dropdown">--}}

                    {{--</div>--}}
                    {{--</li>--}}

                    {{--                    @include('nqadmin-dashboard::frontend.components.header.dropdown.cart.list')--}}

                </ul>
            </div>
            <div class="user right-menu">
                @if(Auth::check())
                    {{--                    <div class="pull-left box-notification hidden-xs hidden-sm">--}}
                    {{--                        @include('nqadmin-dashboard::frontend.components.header.dropdown.notification.list')--}}
                    {{--                    </div>--}}
                    {{--                    <!--box-notification-->--}}

                    <div class="pull-left box-user">
                        <div class="img-user">
                            @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>Auth::user()])
                        </div>
                        <div class="box-dropdown">
                            <div class="form-dropdown form-dropdown-top-center form-user">
                                @include('nqadmin-dashboard::frontend.components.header.dropdown.user.info')

                                @include('nqadmin-dashboard::frontend.components.header.dropdown.user.menu')
                            </div>
                        </div>
                    </div>
                    <!--box-user-->
                @else
                    <h6 class="not-login"><i class="fal fa-user"></i></h6>
                    <ul>
{{--                        <li><a href="#register-box" type="button" class="btn vj-btn btn-popup">Đăng ký</a></li>--}}
                        <li><a href="#login-box" type="button" class="btn vj-btn btn-popup">Đăng nhập</a></li>
                    </ul>
                @endif
            </div>
        </nav>
    </div>

    @if (Agent::isMobile())
        <div class="menu-mobile">
            <div class="content-menu left-menu">
                @if(Auth::check())
                    <div class="form-user">
                        @include('nqadmin-dashboard::frontend.components.header.dropdown.user.info')
                    </div>
                    <div class="form-user">
                        @include('nqadmin-dashboard::frontend.components.header.dropdown.user.menu')
                    </div>
                @else
                    <div class="form-user">
                        <div class="sign-in clearfix">
                            <a href="#login-box" class="btn-popup">
                                <i class="fas fa-sign-in-alt pull-left"></i>
                                <p class="overflow">Đăng nhập</p>
                            </a>
                        </div>

{{--                        <div class="login clearfix">--}}
{{--                            <a href="#register-box" class="btn-popup">--}}
{{--                                <i class="far fa-registered pull-left"></i>--}}
{{--                                <p class="overflow">Đăng ký</p>--}}
{{--                            </a>--}}
{{--                        </div>--}}

                    </div>
                @endif
            </div>
            <div class="menu-show-level">
                <ul class="list-category level-1">
                    <li class="li-level-1 back">
                        <div class="lable-list">
                            <a href="#">
                                <i class="fas fa-chevron-left"></i>
                                Danh mục
                            </a>
                        </div>
                    </li>
                    @foreach($classes as $class)
                        <li class="li-level-1">
                            <div class="lable-list">
                                <a href="{{ route('front.classlevel.index.get', ['slug' => $class->slug]) }}"><i class="fas fa-graduation-cap"></i>{{ $class->name }}</a>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            <ul class="level-2">
                                <li class="li-level-2 back">
                                    <a href="#">
                                        <i class="fas fa-chevron-left"></i>
                                        Menu
                                    </a>
                                </li>
                                @foreach($class->subject as $sub)
                                    <li class="li-level-2">
                                        <a href="{{route('front.subject.index.get', ['class' => $class->slug, 'subject' => $sub->slug])}}">
                                            {{ $sub->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</header>
{{--<!--end header-->--}}
{{--<div class="box-popup box-popup-login" id="register-box">--}}
{{--    <div class="main-popup">--}}
{{--        <div class="header-popup">--}}
{{--            <span class="close-popup"></span>--}}
{{--        </div>--}}
{{--        <div class="content-popup">--}}
{{--            <div class="popup-register">--}}
{{--                <div class="left">--}}
{{--                    <h3 class="txt-popup">Đăng ký</h3>--}}
{{--                    <form class="form-signin1 full_side text-white" action="{{ route('front.register.post') }}" method="post">--}}
{{--                        {{ csrf_field() }}--}}
{{--                        <div class="box-form-default">--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="text" class="input-form" name="first_name" placeholder="Tên đầy đủ" required/>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="phone" class="input-form" name="phone" placeholder="Số điện thoại" required/>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="password" class="input-form" name="password" placeholder="Mật khẩu" required/>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <select class="input-form" name="classlevel">--}}
{{--                                    <option value="">-- Chọn đơn vị ---</option>--}}
{{--                                    @foreach($allClassLevel as $lv)--}}
{{--                                        <option value="{{$lv->id}}">{{$lv->name}} - MST: {{$lv->mst}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="clearfix box-btn text-center">--}}
{{--                                <button type="submit" class="btn btn-default-yellow btn-small">Đăng ký</button>--}}
{{--                            </div>--}}
{{--                            <div class="bottom text-center">--}}
{{--                                <p>Bạn đã có tài khoản? <a href="javascript:;" id="switch-login">Đăng nhập</a></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="right hidden-xs hidden-sm">--}}
{{--                    <span class="logo text-center">anticovid</span>--}}
{{--                    <p>Bằng cách đăng ký, bạn đồng ý với Điều khoản sử dụng và Chính sách Bảo mật của chúng tôi.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="box-popup box-popup-login" id="login-box">
    <div class="main-popup">
        <div class="header-popup">
            <span class="close-popup"></span>
        </div>
        <div class="content-popup">
            <div class="popup-login">
                <div class="left">
                    <h3 class="txt-popup">Đăng nhập</h3>
                    <form class="form-signin1 full_side text-white" action="{{ route('front.login.post') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-form-default">
                            <div class="form-group">
                                <input type="phone" class="input-form" placeholder="Số điện thoại" name="phone">
                            </div>
                            <div class="form-group form-password">
                                <div class="show-password">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                                <input type="password" class="input-form" placeholder="Mật khẩu" name="password">
                            </div>
                            <div class="clearfix box-btn text-center">
                                <button type="submit" class="btn btn-default-yellow btn-small">Đăng nhập</button>
                            </div>
                            <div class="txt-forgot text-center">
                                <a href="javascript:;" id="switch-forget-password">Quên mật khẩu?</a>
                            </div>
                            <div class="bottom text-center">
                                <p>Bạn chưa có tài khoản? Hãy liên hệ với cơ quan chủ quản để đăng ký</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="right hidden-xs hidden-sm">
                    <span class="logo text-center">anticovid</span>
                    <p>Bằng cách đăng ký, bạn đồng ý với Điều khoản sử dụng và Chính sách Bảo mật của chúng tôi.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-popup box-popup-login" id="forget-password">
    <div class="main-popup">
        <div class="header-popup">
            <span class="close-popup"></span>
        </div>
        <div class="content-popup">
            <div class="popup-login">
                <div class="left">
                    <h3 class="txt-popup">Quên mật khẩu</h3>
                    <form class="form-signin1 full_side text-white" action="{{ route('password.reset') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-form-default">
                            <div class="form-group">
                                <label for="">Nhập địa chỉ email bạn đăng ký để lấy lại mật khẩu</label>
                                <input type="text" class="input-form" placeholder="Email" name="email">
                            </div>
                            <div class="clearfix box-btn text-center">
                                <button type="submit" class="btn btn-default-yellow btn-small">Lấy lại mật khẩu</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="right hidden-xs hidden-sm">
                    <span class="logo text-center">anticovid</span>
                    <p>Bằng cách đăng ký, bạn đồng ý với Điều khoản sử dụng và Chính sách Bảo mật của chúng tôi.</p>
                </div>
            </div>
        </div>
    </div>
</div>