@extends('nqadmin-dashboard::frontend.master')

@inject('settingRepository', 'Setting\Repositories\SettingRepository')
@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'])->first();
    $tagline = $settingRepository->findWhere(['name' => 'seo_tagline'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'])->first();
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
                            <div class="list-purchase-history">
                                <div class="top-purchase-history">
                                    <div class="row ">
                                        <div class="col-xs-6 left-history"></div>
                                        <div class="col-xs-6 right-history">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <p class="title">Ngày tháng</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="title">Tổng tiền</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="title">Hình thức</p>
                                                </div>
                                                <div class="col-xs-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-purchase-history">
                                    @foreach($bought as $item)
                                        <?php $course = $item->course ?>
                                        <div class="row list">
                                            <div class="col-xs-6 left-history">
                                                <div class="img pull-left">
                                                    <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                                                </div>
                                                <div class="overflow txt-history">
                                                    <h4 class="txt">{{ $course->name }} </h4>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 right-history">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <p class="title">Ngày tháng</p>
                                                        <p>{{ date('d/m/Y',strtotime($item->created_at)) }}</p>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <p class="title">Tổng tiền</p>
                                                        <p>{{ number_format($item->price) }} </p>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <p class="title">Hình thức</p>
                                                        <p>{{ $item->order->text_payment_method }}</p>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <a href="{{ route('front.users.history_detail.get',['order_id'=>$item->order_id]) }}" class="btn btn-default-white">Chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach

                                {{ $bought->appends(\Illuminate\Support\Facades\Input::except('page'))->links('nqadmin-users::frontend.components.paginate') }}
                                <!--box-paging-->
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