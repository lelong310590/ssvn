@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="page-course-management">
            <div class="container">
                <div class="box-overview-management">
                    <div class="box-filtered text-center top-overview-management">
                    </div>
                    <!--top-overview-management-->
                    <div class="box-overview-course">
                        <div class="box-top-table row">
                            <div class="col-xs-6">
                                <div class="content clearfix">
                                    <div class="left pull-left">
                                        <span class="icon pull-left"><i class="fas fa-dollar-sign"></i></span>
                                        <span class="text pull-left">Tổng doanh thu</span>
                                    </div>
                                    <div class="right pull-right">
                                        <span class="money">{{ number_format($total) }} đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="content clearfix">
                                    <div class="left pull-left">
                                        <span class="icon pull-left"><i class="fas fa-star"></i></span>
                                        <span class="text pull-left">Tổng lượt mua </span>
                                    </div>
                                    <div class="right pull-right">
                                        <span class="point">{{ $orderDetail->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-xs-4">--}}
                                {{--<div class="content clearfix">--}}
                                    {{--<div class="left pull-left">--}}
                                        {{--<span class="icon pull-left"><i class="fas fa-users"></i></span>--}}
                                        {{--<span class="text pull-left">Tổng số học sinh </span>--}}
                                    {{--</div>--}}
                                    {{--<div class="right pull-right">--}}
                                        {{--<span class="number">{{ 123 }}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!--box-top-table-->

                        <div class="top-my-course row">
                            <div class="col-xs-12">
                                <div class="search-my-course pull-left">
                                    <form method="get" action="">
                                        <span class="pull-left txt">Tìm kiếm</span>
                                        <div class="box-search pull-left">
                                            <div class="form-group">
                                                <input type="search" name="keyword" class="txt-form" placeholder="Tìm kiếm bài học" value="{{ request('keyword') }}">
                                                <button type="submit" class="btn btn-search">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--search-my-course-->

                            {{--<div class="box-dropdown-single pull-right box-sort-by">--}}
                            {{--@include('nqadmin-dashboard::frontend.components.search.order_dropdown')--}}
                            {{--</div>--}}
                            <!--box-dropdown-single-->
                            </div>
                        </div>
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
                                                <p class="title">Học sinh</p>
                                            </div>
                                            <div class="col-xs-3"><p class="title">Giá gốc</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-purchase-history">
                                @foreach($orderDetail as $order)
                                <div class="row list">
                                    <div class="col-xs-6 left-history">
                                        <div class="img pull-left">
                                            <img src="{{ asset($order->course->getThumbnail()) }}" alt="" width="" height="">
                                        </div>
                                        <div class="overflow txt-history">
                                            <h4 class="txt">{{ $order->course->name }} </h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 right-history">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <p class="title">Ngày tháng</p>
                                                <p>{{ $order->created_at }}</p>
                                            </div>
                                            <div class="col-xs-3">
                                                <p class="title">Tổng tiền</p>
                                                <p>{{ $order->price }}</p>
                                            </div>
                                            <div class="col-xs-3">
                                                <p class="title">Học sinh</p>
                                                <p>{{ $order->getAuthor->first_name }}</p>
                                            </div>
                                            <div class="col-xs-3">
                                                <p class="title">Giá gốc</p>
                                                <p>{{ $order->base_price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="box-paging">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            {{ $orderDetail->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!--box-paging-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection