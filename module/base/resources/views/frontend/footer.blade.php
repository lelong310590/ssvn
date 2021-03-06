<?php

use ClassLevel\Models\ClassLevel;
use Setting\Models\Setting;
$classes = ClassLevel::with('subject')->get();
?>
<footer class="footer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('front.home.index.get')}}" class="logo pull-left" style="margin-bottom: 25px">
                    <img src="{{asset('frontend/images/logo-white.png')}}" alt="" width="200px" height="">
                </a>
                <ul class="bottom pull-left">
                    <li>
                        <label class="txt">Phone</label>
                        <span class="node">024 6327 5268</span>
                    </li>
                    <li>
                        <label class="txt">Email</label>
                        <a href="mailto:vn.anticovid19@gmail.com" class="node">vndayluidaidich@gmail.com</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5">
                        <h4>Thông tin</h4>
                        <ul>
{{--                            <li><a href="/danh-sach-khoa-hoc">Danh sách Khóa đào tạo</a></li>--}}
                            <li><a href="{{route('front::post.get', 'cau-hoi-thuong-gap')}}">Câu hỏi thường gặp</a></li>
                            <li><a href="{{route('front::post.get', 'huong-dan-su-dung-phan-mem')}}">Hướng dẫn sử dụng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Giới thiệu</h4>
                        <ul>
                            <li><a href="{{route('front::post.get', 'dieu-khoan-su-dung')}}" class="hover-color-green">Điều khoản & Điều kiện</a></li>
{{--                            <li><a href="/tuyen-dung" class="hover-color-green">Tuyển dụng</a></li>--}}
                            <li><a href="{{route('front::post.get', 'lien-he')}}" class="hover-color-green">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Tải ứng dụng</h4>
                        <ul class="app">
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=com.syt.dayluidaidich" target="_blank"><img alt="Tải nội dung trên Google Play" src="https://vietjack.com/git/images/android.svg"></a>
                            </li>
                            <li>
                                <a href="" target="_blank"><img alt="Tải nội dung trên IOS Store" src="https://vietjack.com/git/images/ios.svg"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/moh.gov.vn&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=false&amp;height=300&amp;width=307" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:220px;" allowTransparency="false"></iframe>
            </div>
        </div>
    </div>
</footer>
<!--footer-->

<div class="copyright text-center">
    Bản quyền thuộc về OneBit VietNam © 2021
</div>

<div class="mobile-fixed-bar hidden-md hidden-lg">
    <a href="{{route('front.home.index.get')}}">
        <i class="fa fa-home" aria-hidden="true"></i>
        <span>Trang chủ</span>
    </a>
    @if (Auth::check())
        @if (auth()->user()->hard_role != 99)
        <a href="{{route('front.users.my-certificate.get')}}">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            <span class="text-center">Chứng chỉ</span>
        </a>

        <a href="{{route('front.users.certificate.get')}}">
            <i class="fa fa-certificate" aria-hidden="true"></i>
            <span>DS chứng chỉ</span>
        </a>
        @endif

        <a href="{{route('front.users.info.get')}}">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <span>Tài khoản</span>
        </a>
        <a href="{{route('front::post.get', 'cau-hoi-thuong-gap')}}">
            <i class="fa fa-question" aria-hidden="true"></i>
            <span>Hướng dẫn</span>
        </a>
    @else
        <a href="#login-box" class="btn-popup">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            <span>Chứng chỉ của tôi</span>
        </a>

        <a href="#login-box" class="btn-popup">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <span>Tài khoản</span>
        </a>
        <a href="{{route('front::post.get', 'cau-hoi-thuong-gap')}}">
            <i class="fa fa-question" aria-hidden="true"></i>
            <span>Hướng dẫn</span>
        </a>
    @endif
</div>

<div class="box-view-fast">

</div>

<div class="bg-overflow"></div>
<a href="javascript:void(0)" title="Lên đầu trang" onclick="jQuery('html,body').animate({scrollTop: 0},1000);" class="go_top" style=""><i class="fa fa-angle-up" aria-hidden="true"></i></a>