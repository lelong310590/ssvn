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
                            <h3 class="txt">Các chứng chỉ đã đạt được</h3>
                        </div>
                        <div class="box-my-course box-course">
                        <!--top-my-course-->
                            <div class="content-my-course">
                                <div class="row list-course">
                                    @foreach($certificates as $c)
                                        <div class="col-xs-3 main-course">
                                            <div class="course">
                                                <div class="img box-img">
                                                    <img src="{{ asset($c->image) }}" alt="" width="" height="">
                                                </div>
                                                <div class="content">
                                                    <h4 class="txt">
                                                        {{$c->subject->name}}
                                                    </h4>
                                                    <div class="certificate-toolbar">
                                                        <a href="{{ asset($c->image) }}" download="true">
                                                            <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                                        </a>

                                                        <a data-fancybox="single" href="{{ asset($c->image) }}">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="box-paging clearfix">
                                <div class="pull-right">
                                    {{ $certificates->appends($_GET)->render() }}
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

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
@endpush