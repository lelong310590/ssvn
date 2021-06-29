<?php

use Users\Models\Users;

?>
@extends('nqadmin-dashboard::frontend.master')

@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $description = $course->getLdp()->select('excerpt')->first();
@endphp

@section('title', $course->name)
@section('seo_title', $course->name)
@section('seo_description', !empty($description) ? $description->exceprt : '')
@section('seo_keywords', '')

@section('content')
    <div class="main-page">
        <div class="page-course">

            @include('nqadmin-course::frontend.course.boughttop')

            <div class="container">
            <!--top-course-->

                <div class="content-course">
                @include('nqadmin-course::frontend.components.box-filtered')
                <!--box-filtered-->

                    <div class="box-course-announcement">
                        @foreach($question as $q)
                            <a name="{{ $q->id }}"></a>
                            <div class="list-course-announcement">
                                <div class="top-course-announcement clearfix box-info">
                                    <a href="#" class="img pull-left">
                                        <img src="{{ asset(isset($q->getCourses->owner->thumbnail)?$q->getCourses->owner->thumbnail:'') }}">
                                        <i class="fas fa-file-image"></i>
                                    </a>
                                    <div class="overflow">
                                        <h4 class="name"><a href="#">{{ $q->getCourses->owner->first_name }}</a></h4>
                                        <p class="clearfix">
                                            <span class="pull-left">Đăng một thông báo</span>
                                            <span class="pull-left">{{ time_elapsed_string($q->created_at) }} <i class="fab fa-font-awesome-flag"></i> </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="content-course-announcement">
                                    {!! $q->content !!}
                                </div>
                            </div>
                            <!--list-course-announcement-->
                        @endforeach

                    </div>
                    <!--box-course-announcement-->
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->

@endsection