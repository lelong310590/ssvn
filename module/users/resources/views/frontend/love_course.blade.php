@extends('nqadmin-dashboard::frontend.master')

@section('content')

<div class="main-page">
    <div class="page-user">
        <div class="container">
            <div class="row">
                <div class="left-user col-xs-2">
                    @include('nqadmin-users::frontend.partials.sidebar')
                </div>
                <div class="right-user col-xs-10">
                    <div class="text-center title-page">
                        <h3 class="txt">Khóa đào tạoyêu thích</h3>
                    </div>
                    <div class="box-favorite-course">
                        <div class="search-my-course">
                            <div class="box-search">
                                <div class="form-group">
                                    <input type="search" class="txt-form" placeholder="Tìm kiếm bài học">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="box-dropdown">
                                    <div class="form-dropdown">
                                        <ul>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                            <li>
                                                <i class="fas fa-search pull-left"></i>
                                                <p class="overflow">
                                                    <span>Bài giảng</span> Khóa đào tạobồi dưỡng lại kiến thức cho học sinh mất gốc
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--search-my-course-->

                        <div class="content-favorite-course">
                            <div class="row list-favorite-course">
                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-2.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-2.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-course col-xs-3">
                                    <div class="course">
                                        <div class="img box-img">
                                            <div class="show-img">
                                                <img src="../images/img-1.jpg" alt="" width="" height="">
                                            </div>
                                            <div class="show-video">
                                                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/uB4Dmwiw7-k" frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen=""></iframe>
                                            </div>
                                            <div class="favorite">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a></h4>
                                            <p class="name-teacher">Thầy Trần Mạnh Đoàn</p>
                                            <div class="box-star">
                                                <div class="pull-left">
                                                    <ul class="clearfix">
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star"></i></li>
                                                        <li class="pull-left"><i class="fas fa-star-half"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="overflow">
                                                    <p>4.5 <span>(243)</span></p>
                                                </div>
                                            </div>
                                            <!--box-star-->
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <p class="price old">500,000đ</p>
                                                </div>
                                                <div class="pull-right">
                                                    <p class="price text-right">
                                                        <span>350,000 </span>VNĐ
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--content-favorite-course-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--main-page-->

@endsection