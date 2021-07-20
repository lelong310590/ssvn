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
                            <h3 class="txt">Các chứng chỉ dành cho người <br/>{{$company->name}}</h3>
                        </div>
                        <div class="box-my-course box-course">
                        <!--top-my-course-->
                            <div class="get-certificate-wrapper">
                                @foreach($company->subject as $c)
                                @php
                                    $totalEmployer = $company->get_users_count;
                                    $totalCertificate = $c->get_certificates_count;
                                    $currentPercent = round($totalCertificate/$totalEmployer, 4)*100;
                                    $defaultPercent = config('base.enterprise_percent');
                                @endphp
                                <div class="get-certificate-item">
                                    <div class="get-certificate-name">
                                        <span>{{$c->name}}</span>
                                        @if ($currentPercent >= $defaultPercent)
                                            <a class="btn btn-success" href="{{route('nqadmin::course.certificate.get', ['subject_id' => $c->id, 'download' => true, 'type' => 'enterprise'])}}">Nhận chứng chỉ</a>
                                        @else
                                            <a class="btn btn-success btn-disabled" disabled="true" href="#">Nhận chứng chỉ</a>
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="get-certificate-sub-item">
                                        <small style="color: red; margin-bottom: 15px; display: block">Cần đạt {{$defaultPercent}}% lao động trong doanh nghiệp có chứng chỉ để nhận chứng chỉ doanh nghiệp</small>
                                        <p>Tổng số LĐ trong doanh nghiệp: <b>{{$totalEmployer}}</b></p>
                                        <p>
                                            Tổng số LĐ đạt chứng chỉ:
                                            <b>{{$totalCertificate}} ({{$currentPercent}}%)</b>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
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