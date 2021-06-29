<?php

use Illuminate\Support\Facades\DB;

?>
@extends('nqadmin-dashboard::frontend.master')
@section('title', $subject->name . ' ' .$class->name)
@section('seo_title', $subject->seo_title)
@section('seo_description', $subject->seo_keywords)
@section('seo_keywords', $subject->seo_description)
@section('content')
    <div class="vj-breadcrumb">
        <div class="container">
            <a href="/">Trang chủ</a>
            <span>{{ $subject->name . ' ' .$class->name }}</span>
        </div>
    </div>
    <!--breadcrumb-->

    <div class="container wrap__page">
        <a href="javascript:void(0)" class="mb_wrap-left_close"><i class="fal fa-times"></i></a>
        <div class="wrap__left">
            @include('nqadmin-subject::frontend.filter')
        </div>
        <div class="wrap__right" id="main-course-search">
            @include('nqadmin-subject::frontend.main')
        </div>
    </div>
@endsection