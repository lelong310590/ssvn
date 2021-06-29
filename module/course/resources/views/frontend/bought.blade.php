<?php
use Illuminate\Support\Facades\DB;
?>
@extends('nqadmin-dashboard::frontend.master')

@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $description = $course->getLdp()->select('excerpt')->where('id', $course->id)->first();
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

                    @if ($course->type != 'exam')
                    <div class="box-active">
                        @include('nqadmin-course::frontend.components.tab1.box-active')
                    </div>
                    <!--box-active-->
                    @endif

                    <div class="box-about-course">
                        <h3 class="txt-title-home">Về {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}} này</h3>
                        <p class="text-home">{{ nl2br(e(isset($course->getLdp->excerpt)?$course->getLdp->excerpt:'')) }}</p>
                        <div class="content-about-course">

                            @if ($course->type != 'exam')
                                <div class="list clearfix">
                                <div class="left pull-left">
                                    <p>Bởi các con số</p>
                                </div>
                                <div class="right overflow">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <p>Bài giảng: {{ $course->getCurriculumVideo() }}</p>
                                        </div>
                                        <div class="col-xs-4">
                                            <?php
                                            if (isset($course->getLdp->classlevel)) {
                                                $classLevelId = $course->getLdp->classlevel;
                                                $classLevel = DB::table('classlevel')->find($classLevelId);
                                            }
                                            ?>
                                            @isset($course->getLdp->classlevel)
                                                <p>Cấp độ kỹ năng: {{ $classLevel->name }} </p>
                                            @endisset
                                        </div>
                                        <div class="col-xs-4">
                                            <p>Ngôn ngữ: Tiếng Việt</p>
                                        </div>
                                        <div class="col-xs-4">
                                            <p>Video: {{ secToHR($duration) }}</p>
                                        </div>
                                        <div class="col-xs-4">
                                            <?php $hs = DB::table('order_details')->where('course_id', $course->id)->distinct('customer')->count() ?>
                                            <p>{{ $hs }} sinh viên</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{--<div class="list clearfix">--}}
                                {{--<div class="left pull-left">--}}
                                    {{--<p>Tính năng, đặc điểm</p>--}}
                                {{--</div>--}}
                                {{--<div class="right overflow">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-xs-4">--}}
                                            {{--<p>Truy cập trọn đời Có sẵn trên iOS và Android</p>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-xs-4">--}}
                                            {{--<p>Giấy chứng nhận hoàn thành</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="list clearfix">
                                <div class="left pull-left">
                                    <p>Giới thiệu {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}}</p>
                                </div>
                                <div class="right overflow">

                                    {!! isset($course->getLdp->description)?$course->getLdp->description:'' !!}
                                    @if(!empty($course->getTarget))
                                        <?php $target = json_decode($course->getTarget)->target ?>
                                        @isset($target->who)

                                            @if (!empty($target->who))
                                                <h5>Ai nên tham gia {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}}</h5>
                                                <ul class="list-check">
                                                    @foreach($target->who as $w)
                                                        <li>{{$w}}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endisset
                                        @isset($target->required)
                                            @if (!empty($target->required))
                                                <h5>Yêu cầu trước khi tham gia {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}}</h5>
                                                <ul class="list-check">
                                                    @foreach($target->required as $r)
                                                        <li>{{$r}}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endisset
                                    @endif
                                    <a href="javascript:void(0)" class="less"><i class="fas fa-chevron-down"></i></a>
                                </div>
                            </div>

                            <div class="list clearfix">
                                <div class="left pull-left">
                                    <p>Giảng viên</p>
                                </div>
                                <div class="right overflow">
                                    @php
                                        $code = $course->owner->getDataByKey('code_user');
                                    @endphp
                                    <div class="clearfix box-info">
                                        <a href="{{ route('front.users.profile.get',['code' => $code ])}}" class="img pull-left">
                                            <img src="{{asset(isset($course->owner->thumbnail)?$course->owner->thumbnail:'')}}">
                                            <i class="fas fa-file-image"></i>
                                        </a>
                                        <div class="overflow">
                                            <h4 class="name"><a href="{{ route('front.users.profile.get',['code' => $code ])}}">{{ $course->owner->first_name }}</a></h4>
                                            <p>{{ $course->owner->position }}</p>
                                        </div>
                                    </div>
                                    <div class="content" style="white-space: pre-line;">
                                        {!! nl2br(e($course->owner->getDataByKey('description'))) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--box-about-course-->
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection