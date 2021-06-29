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

                    <div class="box-content-course">
                        <div class="top-content-course">

                            @if ($course->type != 'exam')
                            <div class="box-search-left box-search left-search pull-left">
                                <span class="pull-left txt-lable">Tìm kiếm</span>
                                <div class="overflow">
                                    <form method="get" action="">
                                        <div class="form-group">
                                            <input type="hidden" name="tab" value="2">
                                            <input type="search" id="search_child" name="keyword" class="txt-form" placeholder="Tìm kiếm bài học" value="{{ request('keyword') }}">
                                            <button type="submit" class="btn btn-search">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif

                            @if ($course->type == 'normal')
                            <div class="overflow">
                                <div class="pull-right tab-course">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                                                                  role="tab" data-toggle="tab">Đề cương
                                                Khóa đào tạo</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                                                   data-toggle="tab">Tất cả tài nguyên</a></li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="tab-content-course">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    @include('nqadmin-course::frontend.components.tab2.section',['datas'=>$curriculum,'download'=>false])
                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    @include('nqadmin-course::frontend.components.tab2.section',['datas'=>$curriculum,'download'=>true])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection