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
                            <div class="employer-tool">
                                <p><b>Nhập nhân sự</b></p>
                                <form action="{{route('front.users.employers.post')}}" method="post" role="form" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    name="excel_file"
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <button type="submit" class="btn btn-primary">Nhập dữ liệu</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!--top-my-course-->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="100">Mã nhân sự</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employers as $e)
                                        <tr>
                                            <td>EM-{{1000000 + $e->id}}</td>
                                            <td>{{$e->first_name}} {{$e->last_name}}</td>
                                            <td>{{$e->phone}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-paginate">
                                {{$employers->links()}}
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
