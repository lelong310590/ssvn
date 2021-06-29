@extends('nqadmin-dashboard::frontend.master')

@php
    $degree = $user->getDataByKey('degree');
    $firstName = $user->first_name;
    $lastName = $user->last_name;
    $className = $user->getDataByKey('class');
    $description = $user->getDataByKey('description');
@endphp

@section('title', $degree. ' ' . $firstName . '' . $lastName . ' - ' .$className)
@section('seo_title', $degree. ' ' . $firstName . '' . $lastName . ' - ' .$className)
@section('seo_description', $description)
@section('seo_keywords', '')

@section('content')
    <div class="main-page">
        <div class="page-user page-profile">
            <div class="container">
                <div class="box-info-user box-info-teacher row">
                    <div class="left-info col-xs-6 text-center">
                        <div class="img">
                            <img src="{{ asset($user->thumbnail) }}" align="" alt="" width="" height="">
                        </div>
                        <div class="box-share">
                            <ul class="clearfix">
                                @php
                                    $website = $user->getDataByKey('website');
                                    $facebook = $user->getDataByKey('facebook');
                                    $youtube = $user->getDataByKey('youtube');
                                @endphp

                                @if (!empty($website))
                                    <li class="pull-left"><a href="{{$website}}" target="_blank"><img src="{{ asset('frontend/images/icons/world-map-global-earth-icon.svg') }}" alt="" width="" height=""></a></li>
                                @endif

                                @if (!empty($facebook))
                                    <li class="pull-left"><a href="{{$facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                @endif

                                @if (!empty($youtube))
                                    <li class="pull-left"><a href="{{$youtube}}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                @endif
                            </ul>
                        </div>
                        @if(Auth::check() && Auth::id()!=$user->id)
                            <a href="{{ route('front.message.create.get',['user_id'=>$user->getDataByKey('code_user')]) }}" class="btn btn-default-yellow btn-message">Soạn tin nhắn</a>
                        @endif
                    </div>
                    <div class="right-info col-xs-6 text-left">
                        <h3 class="txt-title">Đôi nét về tôi</h3>
                        <h5 class="name">{{ $user->first_name }}</h5>
                        <p class="competence">{{ $user->position }}</p>
                        <div class="list-info">
                            <div class="clearfix list">
                                <div class="left">
                                    <span class="icon"><i class="fas fa-graduation-cap"></i></span>
                                    <span class="text">Học vị:</span>
                                </div>
                                <div class="right">
                                    <span class="text">{{ $user->getDataByKey('degree') }}</span>
                                </div>
                            </div>
                            <div class="clearfix list">
                                <div class="left">
                                    <span class="icon"><i class="fas fa-suitcase"></i></span>
                                    <span class="text">Nơi công tác:</span>
                                </div>
                                <div class="right">
                                    <span class="text">{{ $user->getDataByKey('class_school') }}</span>
                                </div>
                            </div>
                            <div class="clearfix list">
                                <div class="left">
                                    <span class="icon"><i class="fas fa-book"></i></span>
                                    <span class="text">Bộ môn:</span>
                                </div>
                                <div class="right">
                                    <span class="text">{{ $user->getDataByKey('subject') }}</span>
                                </div>
                            </div>
                            <div class="clearfix list">
                                <div class="left">
                                    <span class="icon"><i class="fas fa-envelope"></i></span>
                                    <span class="text">Email:</span>
                                </div>
                                <div class="right">
                                    <span class="text">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="des" style="white-space: pre-line;">
                            {!! nl2br(e($user->getDataByKey('description'))) !!}
                        </div>
                        <div class="box-experience row">
                            <div class="col-xs-4 content">
                                <p class="number">{{ number_format(intval($user->getDataByKey('year_experience'))) }}</p>
                                <p class="text">Năm kinh nghiệm</p>
                            </div>
                            <div class="col-xs-4 content">
                                <p class="number">200</p>
                                <p class="text">Bài giảng online</p>
                            </div>
                            <div class="col-xs-4 content">
                                <p class="number">{{ number_format(intval($user->getDataByKey('follower'))) }}</p>
                                <p class="text">Người theo dõi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--box-info-teacher-->

                <div class="box-favorite-course box-course-user">
                    <div class="content-favorite-course">
                        <h3 class="title">Các Khóa đào tạocủa tôi</h3>
                        <div class="row list-favorite-course">
                            @foreach($user->course as $course)
                                @include('nqadmin-course::frontend.components.main-course-stand',['data'=>$course])
                            @endforeach
                        </div>
                        <div class="text-center view-all">
                            <a href="#">Xem thêm</a>
                        </div>
                    </div>
                    <!--content-favorite-course-->
                </div>
                <!--box-course-user-->
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection