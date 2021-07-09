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
                            <h3 class="txt">Thống kê</h3>
                        </div>
                        <div class="box-my-course box-course">
                            <!--top-my-course-->

                            <div class="content-my-course">
                                <div class="stats-wrapper">
                                    <div class="stat-title">Thông số tổng quan</div>
                                    <div class="row">
                                        @if (Auth::guard('nqadmin')->user()->hard_role > 2)
                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="far fa-building"></i>
                                               <p> Doanh nghiệp tham gia: <b>{{$company->count()}}</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="fas fa-users"></i>
                                                <p> Tổng số lao động: <b>{{$employers}}</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="fas fa-certificate"></i>
                                                <p> Chứng chỉ cấp phát: <b>{{$certificates}}</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="fab fa-leanpub"></i>
                                                <p> Các khóa đào tạo: <b>{{$courses}}</b></p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="stats-tool">
                                        <div class="stat-title">Thông số chi tiết</div>
                                        <form action="">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-3">
                                                    <div class="form-group">
                                                        <select name="company" id="" class="form-control">
                                                            <option value="">-- Chọn đơn vị --</option>
                                                            @foreach($company as $c)
                                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i> Lọc thông tin</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="stat-detail-wrapper">
                                            @if ($selectedCompany)
                                            <div class="stat-detail-company-info">
                                                <p>Tên đơn vị: <b><i>{{$selectedCompany->name}}</i></b> - MST: <b>{{$selectedCompany->mst}}</b></p>
                                                <p>Tổng số lao động đăng ký: <b>{{$selectedCompany->getUsers != null ? $selectedCompany->getUsers->count() : 0}}</b></p>
                                            </div>
                                            @endif
                                            @foreach($courseInCompany as $course)
                                            <div class="stat-detail-item">
                                                <div class="stat-detail-item-course">
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <div class="stat-detail-item-course-thumbnail">
                                                                <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                                                                <p>{{ $course->name }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <div class="stat-detail-item-stats">
                                                                <p>Tổng số lao động tham gia khóa đào tạo:</p>
                                                                <h4 style="color: red">{{$course->getOrderDetail != null ? $course->getOrderDetail->count() : 0}}</h4>
                                                                <p>Tổng số lao động đã hoàn thành khóa đạo tạo <i>(đã cấp chứng chỉ)</i>:</p>
                                                                <h4 style="color: green">{{$course->certificate->count()}}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="stat-detail-item-stats">
                                                                @php
                                                                    $totalEmployers = $selectedCompany->getUsers->count();
                                                                    $registeredEmployers = $course->getOrderDetail->count();
                                                                    $completedEmployers = $course->certificate->count();
                                                                @endphp
                                                                <p>Tỷ lệ lao động tham gia khóa đào tạo:</p>
                                                                <h4>
                                                                    @if ($totalEmployers == 0)
                                                                        0%
                                                                    @elseif (round($registeredEmployers/$totalEmployers * 100, 0) > 100)
                                                                        100%
                                                                    @else
                                                                        {{round($registeredEmployers/$totalEmployers * 100, 0)}}%
                                                                    @endif
                                                                </h4>
                                                                <p>Tỷ lệ lao động hoàn thành khóa đào tạo: </p>
                                                                <h4>
                                                                    {{$registeredEmployers == 0 ? 0 : round($completedEmployers/$registeredEmployers * 100, 0).'%'}}
                                                                </h4>
                                                            </div>
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
                        <!--box-my-course-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->

@endsection
