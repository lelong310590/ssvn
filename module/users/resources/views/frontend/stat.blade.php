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
                                                <p> Chứng chỉ cấp phát: <b>{{$certificates}}</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="stats-item">
                                                <i class="fab fa-leanpub"></i>
                                                <p> Các khóa đào tạo: <b>{{$courses}}</b></p>
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

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="list-company">
                                                @if (auth('nqadmin')->user()->hard_role > 3)
                                                <p><b>Các doanh nghiệp trong địa phương</b></p>
                                                @endif
                                                <div class="list-company-table {{auth('nqadmin')->user()->hard_role <= 3 ? 'list-company-table-single' : ''}}">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th width="50">STT</th>
                                                                <th>Tên doanh nghiệp</th>
                                                                <th width="100">MST</th>
                                                                <th class="text-center">Tổng số lao động</th>
                                                                <th>Lao động đã đào tạo</th>
                                                                <th>Tỷ lệ (%)</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($companies as $cpn)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$cpn->name}}</td>
                                                                    <td>{{$cpn->mst}}</td>
                                                                    <td class="text-center">{{$cpn->get_users_count}}</td>
                                                                    <td class="text-center">{{$cpn->get_certificate_count}}</td>
                                                                    <td class="text-center">
                                                                        @if ($cpn->get_certificate_count > $cpn->get_users_count)
                                                                            100%
                                                                        @elseif ($cpn->get_users_count == 0)
                                                                            0%
                                                                        @else
                                                                            {{round($cpn->get_certificate_count/$cpn->get_users_count, 4)*100}} %
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5">Không có dữ liệu</td>
                                                                </tr>
                                                            @endforelse

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($unlearnUser != false)
                                        <div class="col-xs-12">
                                            <p><b>Danh sách lao động chưa hoàn thành chứng chỉ</b></p>
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
                                                        $i = $unlearnUser->perPage() * ($unlearnUser->currentPage() - 1) + 1
                                                    @endphp
                                                    @foreach($unlearnUser as $e)
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
                                                {{ $unlearnUser->appends(request()->input())->render('vendor.pagination.default') }}
                                            </div>
                                        </div>
                                        @endif
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
