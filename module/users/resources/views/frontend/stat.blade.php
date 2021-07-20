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
                    @if (auth('nqadmin')->user()->hard_role <= 3)
                    <div class="left-user col-xs-2">
                        @include('nqadmin-users::frontend.partials.sidebar')
                    </div>
                    @endif
                    <div class="{{auth('nqadmin')->user()->hard_role > 3 ? 'col-xs-12' : 'col-xs-10 right-user'}}">
                        <div class="text-center title-page">
                            <h3 class="txt">Thống kê</h3>
                        </div>
                        <div class="box-my-course box-course">
                            <!--top-my-course-->
                            @if (Auth::guard('nqadmin')->user()->hard_role <= 3)
                            <a href="{{route('front.users.export.get')}}" class="btn btn-success" style="color: #fff">
                                <i class="far fa-file-excel"></i>
                                 Xuất báo cáo
                            </a>
                            @endif

                            @if (Auth::guard('nqadmin')->user()->hard_role > 3)
                            <div class="content-my-course">
                                <div class="stats-wrapper">
                                    <div class="stat-title">Thông số tổng quan cả nước</div>
                                    <div class="row">
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
                                                <p> Tổng lao động đạt CC: <b>{{$certificates}} ({{round($certificates/$employers, 4) * 100}}%)</b></p>
                                                <p> Tổng doanh nghiệp đạt CC: <b>{{0}} ({{round(0/$employers, 4) * 100}}%)</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="fab fa-leanpub"></i>
                                                <p> Các khóa đào tạo: <b>{{$courses->count()}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="filter">
                                @if (auth('nqadmin')->user()->hard_role > 3)
                                <div class="stats-wrapper">
                                    <div class="stat-title">Thông số chi tiết theo từng địa phương</div>
                                </div>
                                <div class="filter-box">
                                    <form method="GET">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="province">Tỉnh / Thành phố</label>
                                                    <select name="province" id="provinces-id" class="form-control">
                                                        <option value="">-- Chọn Tỉnh / Thành phố</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{$province->id}}"
                                                                    {{$province->id == request()->get('province') ? 'selected' : ''}}>
                                                                {{$province->province_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="province">Quận / Huyện</label>
                                                    <select name="district" id="district-id" class="form-control">
                                                        @forelse($districts as $district)
                                                            <option value="{{$district->id}}"
                                                                    {{$district->id == request()->get('district') ? 'selected' : ''}}>
                                                                {{$district->district_name}}
                                                            </option>
                                                        @empty
                                                            <option value="">-- Chọn Quận / Huyện ---</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="province">Phường / Xã</label>
                                                    <select name="ward" id="ward-id" class="form-control">
                                                        @forelse($wards as $ward)
                                                            <option value="{{$ward->id}}"
                                                                    {{$ward->id == request()->get('ward') ? 'selected' : ''}}>
                                                                {{$ward->ward_name}}
                                                            </option>
                                                        @empty
                                                            <option value="">-- Chọn Phường / Xã ---</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2">
                                                <button class="btn btn-primary" type="submit" style="margin-top: 22px">Lấy thông tin</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endif

                                @if ($rangeAge != false)
                                <div class="result-wrapper">

                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <div class="chart-age">
                                                <canvas id="chart-age"></canvas>
                                                <div class="chart-label text-center" style="margin-top: 15px">
                                                    <p><b>Độ tuổi lao động</b></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6">
                                            <div class="chart-sex {{auth('nqadmin')->user()->hard_role <= 3 ? 'chart-sex-no-padding' : ''}}">
                                                <canvas id="chart-sex"></canvas>
                                                <div class="chart-label text-center" style="margin-top: 15px">
                                                    <p><b>Giới tính</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if (Auth::guard('nqadmin')->user()->hard_role > 3)
                                        <a
                                            href="{{route('front.users.export.get', [
                                                'province' => request()->get('province'),
                                                'district' => request()->get('district'),
                                                'ward' => request()->get('ward')
                                            ])}}"
                                            class="btn btn-success"
                                            style="color: #fff; margin-bottom: 20px"
                                        >
                                            <i class="far fa-file-excel"></i>
                                            Xuất báo cáo
                                        </a>
                                    @endif

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="list-company">
                                                @if (auth('nqadmin')->user()->hard_role > 3)
                                                <p><b>Các doanh nghiệp trong địa phương</b></p>
                                                @endif

                                                @if (auth('nqadmin')->user()->hard_role > 3 && request()->get('ward') == null)
                                                    @include('nqadmin-users::frontend.components.stat.table-report-area')
                                                @elseif (auth('nqadmin')->user()->hard_role > 3 && request()->get('ward') != null)
                                                    @include('nqadmin-users::frontend.components.stat.table-report-global')
                                                @elseif (auth('nqadmin')->user()->hard_role > 1 && auth('nqadmin')->user()->hard_role <= 3)

                                                    @if (auth('nqadmin')->user()->hard_role == 3)
                                                        @include('nqadmin-users::frontend.components.stat.table-report-local-manager')
                                                    @endif

                                                    @include('nqadmin-users::frontend.components.stat.table-report-local')
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
@endpush

@push('js-init')
    <script type="text/javascript">
		jQuery(document).ready(function ($) {
			const provinceSelect = $('#provinces-id');
			const districtSelect = $('#district-id');
			const wardSelect = $('#ward-id');
			const body = $('body');

			body.on('change', '#provinces-id', function () {
				$.ajax({
					url: '{{route('ajax.get-districts')}}',
					type: 'GET',
					data: {
						provinceId: $(this).val(),
					},
					success: function( response ) {
						districtSelect.html(response.html);
						wardSelect.empty();
					},
					error: function( err ) {

					}
				});
			})

			body.on('change', '#district-id', function () {
				$.ajax({
					url: '{{route('ajax.get-wards')}}',
					type: 'GET',
					data: {
						districtId: $(this).val(),
					},
					success: function( response ) {
						wardSelect.html(response.html);
					},
					error: function( err ) {

					}
				});
			})
		})
    </script>
@endpush

@if ($rangeAge != false)
    @include('nqadmin-users::frontend.partials.stats.chart-age')
    @include('nqadmin-users::frontend.partials.stats.chart-sex')
@endif
