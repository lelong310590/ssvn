@extends('nqadmin-dashboard::frontend.master')
@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $description = $course->getLdp()->select('excerpt')->first();
@endphp

@section('title', $course->name)
@section('seo_title', $course->name)
@section('seo_description', $description->excerpt)
@section('seo_keywords', '')

@section('content')
    <div class="main-page">
        <div class="box-buy-course">
            <div class="container">
                <div class="row main-buy-course">
                    <!--begin right-buy-course-->
                    @include('nqadmin-course::frontend.indexdetail.right')
                    <!-- end right-buy-course-->

                    <div class="col-xs-8 col-xs-pull-4 left-buy-course">
                        <div class="content-detail">
                            <div class="top-content-detail">
                                <h1 class="title">{{ $course->name }}</h1>


                                <div class="des-shot">
                                    {!! nl2br(e(isset($course->getLdp->excerpt)?$course->getLdp->excerpt:'')) !!}
                                </div>
                                <div class="list">
                                    <ul class="clearfix">
                                        <li class="box-star pull-left">
                                            @include('nqadmin-course::frontend.components.course.star',['item'=>$course])
                                        </li>
                                        <li class="pull-left">{{ $course->getTotalStudent() }} sinh viên ghi danh</li>
                                        <li class="pull-left">Được tạo bởi: <a
                                                    href="{{ route('front.users.profile.get',['code'=>$course->owner->getDataByKey('code_user')]) }}">{{ $course->owner->first_name }}</a></li>
                                        <li class="pull-left">Cập nhật lần cuối: {{ $course->updated_at->format('d-m-Y') }}</li>
                                        <li class="pull-left">Cấp độ: {{ !empty($course->getLdp->getLevel) ? $course->getLdp->getLevel->name : '' }}</li>
                                        @if (!empty($course->getLdp->getClassLevel))
                                        <li class="pull-left">
                                            @php
                                                $classLevelName = $course->getLdp->getClassLevel->name;
                                                $classLevelSlug = $course->getLdp->getClassLevel->slug;
                                            @endphp
                                            Trình độ: <a href="{{route('front.classlevel.index.get', $classLevelSlug)}}">{{ $classLevelName }}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="main-content-detail show-all">
                                @if($course->type=='test')
                                    <div class="detail">
                                        @include('nqadmin-course::frontend.realated_curriculum')
                                        <h4 class="txt-title-home">Mô tả</h4>
                                        <div class="text-justify">
                                            {!! $course->getLdp->description !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="detail">
                                        {{--<p>Với {{ $course->getCurriculumVideo() }} chuyên đề bám sát sách giáo khoa--}}
                                            {{--{{ isset($course->getLdp->getSubject->name)?$course->getLdp->getSubject->name:'' }} {{ isset($course->getLdp->getClassLevel->name)?$course->getLdp->getClassLevel->name:'' }}--}}
                                            {{--,--}}
                                            {{--{{ $course->owner->first_name }} sẽ giúp các em từng bước làm quen cũng như xây dựng kiến thức nền tảng--}}
                                            {{--môn {{ isset($course->getLdp->getSubject->name)?$course->getLdp->getSubject->name:'' }}.</p>--}}

                                        @if(!empty($course->getTarget))
                                            @php($target = json_decode($course->getTarget)->target)
                                            @isset($target->who)

                                                @isset($target->what)
                                                    @if (!empty($target->what))
                                                        <h3 class="txt-title-home" style="padding-top: 0">Bạn sẽ học được gì từ Khóa đào tạo?</h3>
                                                        <ul class="list-check">
                                                            @foreach($target->what as $h)
                                                                <li>{{$h}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endisset

                                                @if (!empty($target->who))
                                                    <h4 class="txt-title-home">Ai nên tham gia Khóa đào tạo</h4>
                                                    <ul class="list-check">
                                                        @foreach($target->who as $w)
                                                            <li>{{$w}}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                            @endisset
                                            @isset($target->required)
                                                @if (!empty($target->required))
                                                    <h4 class="txt-title-home">Yêu cầu trước khi tham gia Khóa đào tạo</h4>
                                                    <ul class="list-check">
                                                        @foreach($target->required as $r)
                                                            <li>{{$r}}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endisset
                                        @endif
                                        <h4 class="txt-title-home">Mô tả</h4>
                                        <div class="text-justify">
                                            {!! $course->getLdp->description !!}
                                        </div>

                                        @include('nqadmin-course::frontend.realated_curriculum')
                                    </div>
                                @endif
                                <div class="text-center">
                                    <a href="javascript:void(0)" class="less more"><i class="fas fa-chevron-down"></i></a>
                                </div>

                            </div>
                        </div>
                        <!--content-detail-->
                        <!--begin box-course-other-->
                        @include('nqadmin-course::frontend.indexdetail.relate')
                        <!--end box-course-other-->

                        {{--fbcomment--}}
                        @if (!$course->checkBought())
                        <div class="fb-comment">
                            <div class="fb-comments" data-order-by="social" data-href="{{request()->url()}}" data-numposts="5" data-width="100%"></div>
                        </div>
                        @endif

                        @include('nqadmin-course::frontend.indexdetail.teacher')
                        <!--box-info-->

                        @include('nqadmin-course::frontend.indexdetail.rating')
                        <!--box-review-->
                        @include('nqadmin-course::frontend.indexdetail.relateteacher')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{$course->google_analytics_id}}');
    </script>
@endpush