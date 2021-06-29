@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="page-course-management">
            <div class="top-course-management">
                <div class="top-course-management">
                    @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.top',['id'=>$id])
                </div>
            </div>
            <!--top-course-management-->

            <div class="container">
                <div class="content-course-management row">
                    <div class="left-course-management col-xs-3">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.leftmenu',['id'=>$id])
                    </div>
                    <div class="right-course-management col-xs-9">
                        <h2 class="txt-title">Phân tích và thống kê</h2>

                        <div class="box-statistics">
                            <div class="top-statistics row">
                                <div class="col-xs-5 left-top-statistics">
                                    <p class="txt">Đánh giá trung bình</p>
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="number pull-left">{{ $course->getAverageRating() }}</div>
                                                <div class="pull-right box-star">
                                                    @include('nqadmin-course::frontend.components.course.only_star',['item'=>$course->getAverageRating()])
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="box-btn">--}}
                                            {{--<a href="#" class="btn btn-small btn-default-white">Xem tất cả nhận xét</a>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                                <div class="col-xs-7 right-top-statistics">
                                    <p class="txt">Tiêu thụ nội dung</p>
                                    <div class="content">
                                        <div class="content-detail">
                                            <p class="pull-left">Sinh viên tham gia từ 3 tháng trở lại đây.</p>
                                            <div class="overflow">
                                                <div class="list clearfix">
                                                    <div class="number pull-left">
                                                        <span>136</span> phút
                                                    </div>
                                                    <p class="overflow">Trung bình mỗi học sinh hoạt động</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--top-statistics-->

                            <div class="box-chart-statistics">
                                <div class="box-chart-1">
                                    <p class="txt">Lượt truy cập trang đích theo nguồn lưu lượng truy cập bên ngoài</p>
                                    <div class="main-chart">
                                        <div class="form-chart">
                                            <div class="chart-form">
                                                <div id="embed-api-auth-container"></div>
                                                <div id="chart-container"></div>
                                                <div id="view-selector-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="box-chart-2">--}}
                                    {{--<p class="txt">Số học sinh mới đăng ký so với sinh viên tích cực</p>--}}
                                    {{--<div class="main-chart">--}}
                                        {{--<div class="form-chart">--}}
                                            {{--<div class="chart-form">--}}
                                                {{--<img src="{{asset('frontend/images/img-25.jpg')}}">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--content-course-management-->

        </div>
    </div>
    <!--main-page-->

@endsection

@push('js')
    @if (!empty($course->google_analytics_id))
    <script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));

        gapi.analytics.ready(function() {

            /**
             * Authorize the user immediately if the user has already granted access.
             * If no access has been created, render an authorize button inside the
             * element with the ID "embed-api-auth-container".
             */
            gapi.analytics.auth.authorize({
                container: 'embed-api-auth-container',
                clientid: '{{$course->google_analytics_id}}'
            });


            /**
             * Create a new ViewSelector instance to be rendered inside of an
             * element with the id "view-selector-container".
             */
            var viewSelector = new gapi.analytics.ViewSelector({
                container: 'view-selector-container'
            });

            // Render the view selector to the page.
            viewSelector.execute();


            /**
             * Create a new DataChart instance with the given query parameters
             * and Google chart options. It will be rendered inside an element
             * with the id "chart-container".
             */
            var dataChart = new gapi.analytics.googleCharts.DataChart({
                query: {
                    metrics: 'ga:sessions',
                    dimensions: 'ga:date',
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday'
                },
                chart: {
                    container: 'chart-container',
                    type: 'LINE',
                    options: {
                        width: '100%'
                    }
                }
            });


            /**
             * Render the dataChart on the page whenever a new view is selected.
             */
            viewSelector.on('change', function(ids) {
                dataChart.set({query: {ids: ids}}).execute();
            });

        });
    </script>
    @endif
@endpush