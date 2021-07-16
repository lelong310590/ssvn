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
                            <h3 class="txt">Danh sách người lao động</h3>
                        </div>
                        <div class="box-my-course box-course">
                            <div class="count-employer mt-4 mb-4">
                                <p>Số nhân sự dưới quyền quản lý: <b>{{$employers->total()}}</b></p>
                            </div>

                            <!--top-my-course-->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="100">STT</th>
                                        <th>Họ và tên</th>
                                        <th>Số CMND/CCCD</th>
                                        <th>Tuổi</th>
                                        <th>Số điện thoại</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = $employers->perPage() * ($employers->currentPage() - 1) + 1
                                    @endphp
                                    @foreach($employers as $e)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$e->first_name}} {{$e->last_name}}</td>
                                            <td>{{$e->citizen_identification}}</td>
                                            <td>{{$e->old}}</td>
                                            <td>{{$e->phone}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="vj-paging">
                                {{ $employers->appends(request()->input())->render('vendor.pagination.default') }}
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
