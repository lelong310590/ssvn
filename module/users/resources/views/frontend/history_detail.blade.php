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
                            <h3 class="txt">Lịch sử mua hàng</h3>
                        </div>
                        <div class="box-purchase-history">
                            <div class="back">
                                <a href="{{ url()->previous() }}"><i class="fas fa-chevron-left"></i> Quay lại</a>
                            </div>
                            <div class="box-buy-detail">
                                <div class="top-buy">
                                    <p class="txt">Biên nhận - Ngày {{ date('d',strtotime($order->created_at)) }} tháng {{ date('m',strtotime($order->created_at)) }}
                                        năm {{ date('Y',strtotime($order->created_at)) }}</p>
                                </div>

                                <div class="row box-info">
                                    <div class="col-xs-5 right-info">
                                        <p class="date"><span>Số hoá đơn: </span>{{ $order->getOrderCode() }}</p>
                                    </div>
                                </div>

                                <div class="table-buy">
                                    <div class="top-table border">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <p class="txt-title">Tiêu đề</p>
                                            </div>
                                            <div class="col-xs-2">
                                                <p class="txt-title">Đã ra lệnh</p>
                                            </div>
                                            <div class="col-xs-2">
                                                <p class="txt-title">Mã giảm giá</p>
                                            </div>
                                            <div class="col-xs-1">
                                                <p class="txt-title">Số lượng</p>
                                            </div>
                                            <div class="col-xs-1 text-center">
                                                <p class="txt-title">Giá bán</p>
                                            </div>
                                            <div class="col-xs-1 text-center">
                                                <p class="txt-title">Số tiền</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-table border">
                                        <?php $total_price = 0 ?>
                                        @foreach($order->detail as $item)
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <p class="txt-title">Tiêu đề</p>
                                                    <p>{{ $item->course->name }}</p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="txt-title">Đã ra lệnh</p>
                                                    <p>{{ date('d',strtotime($item->created_at)) }} Tháng {{ date('m',strtotime($item->created_at)) }}
                                                        năm {{ date('Y',strtotime($item->created_at)) }} </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="txt-title">Mã giảm giá</p>
                                                    <p>{{ $item->coupon?$item->coupon->code:'' }}</p>
                                                </div>
                                                <div class="col-xs-1">
                                                    <p class="txt-title">Số lượng</p>
                                                    <p>1</p>
                                                </div>
                                                <div class="col-xs-1 text-center">
                                                    <p class="txt-title">Giá bán</p>
                                                    <?php $total_price += $item->base_price ?>
                                                    <p>{{ number_format($item->base_price) }}</p>
                                                </div>
                                                <div class="col-xs-1 text-center">
                                                    <p class="txt-title">Số tiền</p>
                                                    <p>{{ number_format($item->price) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="bottom-table">
                                        <div class="row">
                                            <div class="col-xs-9"></div>
                                            <div class="col-xs-2">
                                                <p>Toàn bộ</p>
                                            </div>
                                            <div class="col-xs-1">
                                                <p>{{ number_format($total_price) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom-table">
                                        <div class="row">
                                            <div class="col-xs-9"></div>
                                            <div class="col-xs-2">
                                                <p>Tổng số chi trả</p>
                                            </div>
                                            <div class="col-xs-1">
                                                <p>{{ number_format($order->total_price) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border note">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->

@endsection