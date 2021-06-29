@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
@endphp

@section('title', $title->content)
@section('seo_title', $title->content)
@section('seo_description', $description->content)
@section('seo_keywords', $keywords->content)

<?php

use Illuminate\Support\Facades\DB;

?>
@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="box-top-search">
            <div class="container">
                <form id="filter_form" class="box-form-default" method="get" action="">
                {{--<div class="box-filtered pull-left">--}}
                {{--<div class="clearfix">--}}
                {{--<span class="txt pull-left">Lọc theo</span>--}}
                {{--<input type="hidden" id="m" name="m" value="{{ request('m') }}">--}}
                {{--<ul class="overflow">--}}
                {{--<li class="pull-left"><a href="#" class="active" rel="">Chứng chỉ</a></li>--}}
                {{--<li class="pull-left"><a href="#">Tiến độ</a></li>--}}
                {{--<li class="pull-left"><a href="#">Giảng viên</a></li>--}}
                {{--<li class="pull-left"><a href="#" rel="course">Tên Khóa đào tạo.</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}
                <!--box-filtered-->
                    <div class="box-dropdown-single pull-left">
                        @include('nqadmin-dashboard::frontend.components.search.order_dropdown')
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
    <!--main-page-->
@endsection
