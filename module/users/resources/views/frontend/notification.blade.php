@extends('nqadmin-dashboard::frontend.master')

@inject('settingRepository', 'Setting\Repositories\SettingRepository')
@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
    $tagline = $settingRepository->findWhere(['name' => 'seo_tagline'], ['content'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
@endphp

@section('title', $title != null ? $title->content : '')
@section('seo_title', $title != null ? $title->content : '')
@section('seo_description', $description != null ? $description->content : '')
@section('seo_keywords', $keywords != null ? $keywords->content : '')

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
                        <h3 class="txt">Thông báo của tôi</h3>
                    </div>
                    <div class="box-notification-user">
                        @foreach($notify as $k=>$v)
                        <div class="list-notification-user">
                            <div class="text-center top">
                                <h4 class="txt-title">{{ time_elapsed_string($k) }}</h4>
                            </div>
                            <div class="list-notification">
                                @foreach($v as $n)
                                <div class="clearfix main-notification">
                                    <div class="pull-left box-time text-center">
                                        <span>{{ date('H:i',strtotime($n->created_at)) }}</span>
                                    </div>
                                    <div class="box-img pull-left text-center">
                                        <a href="#" class="img-circle">
                                            <img src="{{asset('frontend/images/img-10.png')}}" alt="" width="" height="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p>
                                            <a href="#" class="txt">{{ $n->name }}:</a>
                                            <?php
                                            echo isset(json_decode($n->content)->text)?json_decode($n->content)->text:'';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center top">
                            <a href="#" class="txt-title">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--main-page-->
@endsection