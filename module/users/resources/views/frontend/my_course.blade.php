@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
@endphp

@section('title', $title != null ? $title->content : '')
@section('seo_title', $title != null ? $title->content : '')
@section('seo_description', $description != null ? $description->content : '')
@section('seo_keywords', $keywords != null ? $keywords->content : '')

<?php

use Illuminate\Support\Facades\DB;

?>
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
                        <h3 class="txt">Khóa đào tạo của tôi</h3>
                    </div>
                    <div class="box-my-course box-course">
                    @include('nqadmin-users::frontend.components.my_course.filter')
                    <!--top-my-course-->

                        <div class="content-my-course">
                            <div class="row list-course">

                                @if($user->boughtSuccess()->count())
                                    @foreach($courses as $course)
                                        <div class="col-xs-3 main-course">
                                            <div class="course">
                                                <div class="img box-img">
                                                    <div class="show-img" onclick="return location.href='{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($course->getLastCurriculum()->id)?$course->getLastCurriculum()->id:'#']) }}'">
                                                        <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}">{{ $course->name }} </a></h4>
                                                    <div class="box-finish">
                                                        <div class="chart">
                                                            <span class="finish" style="width: {{ number_format($course->getProcess()) }}%"></span>
                                                        </div>
                                                        <div class="clearfix">
                                                            <span class="txt pull-left">Hoàn thành {{ number_format($course->getProcess(),0) }}%</span>
                                                            <div class="box-star pull-right">
                                                                @include('nqadmin-course::frontend.components.course.only_star',['item'=>$course->getAverageRating()])
                                                            </div>
                                                        </div>
                                                        <p class="text-right">Đánh giá của bạn</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="box-paging clearfix">
                            <div class="pull-right">
                                {{ $courses->appends($_GET)->render() }}
                            </div>
                        </div>
                    </div>
                    <!--box-my-course-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--main-page-->

@endsection