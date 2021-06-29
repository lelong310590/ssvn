<?php

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

?>
@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="container">
                <div class="box-overview-management">
                    <div class="box-filtered text-center top-overview-management">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.topmenu')
                    </div>
                    <!--top-overview-management-->
                    <div class="box-overview-course">
                        <div class="box-top-table row">
                            <div class="col-xs-4">
                                <div class="content clearfix">
                                    <div class="left pull-left">
                                        <span class="icon pull-left"><i class="fas fa-dollar-sign"></i></span>
                                        <span class="text pull-left">Tổng doanh thu</span>
                                    </div>
                                    <div class="right pull-right">
                                        <span class="money">{{ number_format($user->sell->where('status','done')->sum('price')) }} đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="content clearfix">
                                    <div class="left pull-left">
                                        <span class="icon pull-left"><i class="fas fa-star"></i></span>
                                        <span class="text pull-left">Đánh giá trung bình <i class="fas fa-exclamation-circle"></i></span>
                                    </div>
                                    <div class="right pull-right">
                                        <span class="point">{{ $getAverageRating }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="content clearfix">
                                    <div class="left pull-left">
                                        <span class="icon pull-left"><i class="fas fa-users"></i></span>
                                        <span class="text pull-left">Tổng số học sinh <i class="fas fa-exclamation-circle"></i></span>
                                    </div>
                                    <div class="right pull-right">
                                        <span class="number">{{ $user->getTotalStudent() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--box-top-table-->

                        <div class="top-my-course row">
                            <div class="col-xs-12">
                                <div class="search-my-course pull-left">
                                    <form method="get" action="">
                                        <span class="pull-left txt">Tìm kiếm</span>
                                        <div class="box-search pull-left">
                                            <div class="form-group">
                                                <input type="search" name="keyword" class="txt-form" placeholder="Tìm kiếm bài học" value="{{ request('keyword') }}">
                                                <button type="submit" class="btn btn-search">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--search-my-course-->

                            {{--<div class="box-dropdown-single pull-right box-sort-by">--}}
                            {{--@include('nqadmin-dashboard::frontend.components.search.order_dropdown')--}}
                            {{--</div>--}}
                            <!--box-dropdown-single-->
                            </div>
                        </div>

                        <div class="box-list-overview-course">
                            @foreach($user->course as $course)
                                <div class="list-overview">
                                    <div class="row">
                                        <div class="col-xs-1 box-img">
                                            <a href="{{ route('front.users.quan_ly_khoa_hoc_thong_ke.get',['id'=>$course->id]) }}">
                                                <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                                            </a>
                                        </div>
                                        <div class="col-xs-5 box-detail">
                                            <h4 class="txt-title"><a href="{{ route('front.users.quan_ly_khoa_hoc_thong_ke.get',['id'=>$course->id]) }}">{{ $course->name }}</a></h4>
                                            <p class="name-user">{{ $course->owner->first_name }}</p>
                                            <div class="bottom">
                                                <span class="pull-left online">{{ $course->status=='disable'?'Lưu nháp':'Trực tuyến' }}</span>
                                                <span class="pull-right money">{{ number_format($course->price) }} đ</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 box-content">
                                            <div class="list">
                                                <p class="txt">Kiếm được trong tháng</p>
                                                <p class="number">{{ number_format($course->getOrderDetail->where('status','done')->where('created_at', '<', date("Y-m-01 00:00:00"))->sum('price')) }} đ</p>
                                            </div>
                                            <div class="list">
                                                <p class="txt">Tổng cộng kiếm được</p>
                                                <p class="number">{{ number_format($course->getOrderDetail->where('status','done')->sum('price')) }} đ</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 box-content">
                                            <div class="list">
                                                <p class="txt">Đăng ký tháng này</p>
                                                <p class="number">{{ number_format($course->getOrderDetail->where('status','done')->where('created_at', '<', date("Y-m-01 00:00:00"))->groupBy('customer')->count()) }}</p>
                                            </div>
                                            <div class="list">
                                                <p class="txt">Tổng số sinh viên</p>
                                                <p class="number">{{ number_format($course->getTotalStudent()) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 box-point">
                                            <div class="list">
                                                <p class="txt">Đánh giá trung bình</p>
                                                <p class="number">{{ $course->getAverageRating() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection