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


@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="vj-breadcrumb">
        <div class="container">
            <a href="/">Trang chủ</a>
            <span>Tìm kiếm '{{ request('q') }}'</span>
        </div>
    </div>
    <!--breadcrumb-->

    <div class="container wrap__page">
        <a href="javascript:void(0)" class="mb_wrap-left_close"><i class="fal fa-times"></i></a>
        <div class="wrap__left">
            @include('nqadmin-course::frontend.components.filter-course-search')
        </div>
        <div class="wrap__right" id="main-course-search">
            @include('nqadmin-course::frontend.components.main-course-search')
        </div>
    </div>
    <!--search page-->
@endsection
