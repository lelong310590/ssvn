<?php
use Illuminate\Support\Facades\DB;

?>
@extends('nqadmin-dashboard::frontend.master')
@section('title', $class->name)
@section('seo_title', $class->seo_title)
@section('seo_description', $class->seo_description)
@section('seo_keywords', $class->seo_keywords)

@section('content')
    <div class="main-page">
        <div class="box-top-search" style="display: none;">
            <div class="container">
                <form id="filter_form" class="box-form-default" method="get" action="">
                    <div class="box-filtered pull-left">
                        <div class="clearfix">
                            <span class="txt pull-left">Lọc theo</span>
                            <ul class="overflow">
                                <li class="pull-left"><a href="#" class="active">Chứng chỉ</a></li>
                                <li class="pull-left"><a href="#">Tiến độ</a></li>
                                <li class="pull-left"><a href="#">Giảng viên</a></li>
                                <li class="pull-left"><a href="#">Tên Khóa đào tạo.</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--box-filtered-->

                    <div class="box-dropdown-single pull-left">
                        <span class="txt pull-left">Sắp xếp theo</span>
                        <div class="pull-left dropdown-single">
                            <select class="show-txt" name="order">
                                <option value="0" <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 0) {
                                    echo 'selected';
                                }?>>Tham gia gần đây
                                </option>
                                <option value="1" <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 1) {
                                    echo 'selected';
                                }?>>Tiêu đề Khóa đào tạo(A-Z)
                                </option>
                                <option value="2" <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 2) {
                                    echo 'selected';
                                }?>>Tiến độ Khóa đào tạo(Z-A)
                                </option>
                                <option value="3" <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 3) {
                                    echo 'selected';
                                }?>>Hoàn thành (0%-100%)
                                </option>
                                <option value="4" <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 4) {
                                    echo 'selected';
                                }?>>Hoàn thành (100%-0%
                                </option>
                            </select>
                            {{--<span class="show-txt">Tham gia gần đây <i class="fas fa-chevron-down pull-right"></i></span>--}}
                            {{--<ul class="form-dropdown">--}}
                            {{--<li><a href="#">Tham gia gần đây</a> </li>--}}
                            {{--<li><a href="#">Tiêu đề Khóa đào tạo(A-Z)</a> </li>--}}
                            {{--<li><a href="#">Tiến độ Khóa đào tạo(Z-A)</a> </li>--}}
                            {{--<li><a href="#">Hoàn thành (0%-100%)</a> </li>--}}
                            {{--<li><a href="#">Hoàn thành (100%-0%)</a> </li>--}}
                            {{--</ul>--}}
                        </div>
                    </div>
                    <!--box-dropdown-single-->
                </form>
            </div>
        </div>
        <!--box-top-search-->

        <div class="box-course box-course-search">
            <div class="container">
                <div class="list-course-search">
                    @include('nqadmin-course::frontend.components.main-course-search')
                </div>
                <div class="box-paging clearfix">
                    <div class="pull-right">
                        {{ $course->appends($_GET)->render() }}
                    </div>
                </div>
            </div>
        </div>
        <!--box-course-->
    </div>
@endsection