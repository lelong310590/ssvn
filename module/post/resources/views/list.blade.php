@extends('nqadmin-dashboard::backend.master')
@section('content')

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Bài viết</h3>
                    <p>Tạo bài viết hoặc trang tĩnh</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-lg-8 col-xl-4">
                    <a class="activity-block success" href="{{route('nqadmin::post.index.get', ['type' => 'post'])}}">
                        <div class="media">
                            <div class="media-body">
                                <h5>Bài viết</h5>
                            </div>
                        </div>
                        <br>
                        <div class="media">
                            <div class="media-body"><span class="progress-heading">Danh sách bài viết</span></div>
                        </div>
                        <i class="bg-icon text-center fa fa-list-ul"></i>
                    </a>
                </div>

                <div class="col-md-8 col-lg-8 col-xl-4">
                    <a class="activity-block success" href="{{route('nqadmin::post.create.get', ['type' => 'post'])}}">
                        <div class="media">
                            <div class="media-body">
                                <h5>Thêm bài viết mới</h5>
                            </div>
                        </div>
                        <br>
                        <div class="media">
                            <div class="media-body"><span class="progress-heading">Thêm bài viết mới</span></div>
                        </div>
                        <i class="bg-icon text-center fa fa-edit"></i>
                    </a>
                </div>

{{--                <div class="col-md-8 col-lg-8 col-xl-4">--}}
{{--                    <a class="activity-block warning" href="{{route('nqadmin::post.index.get', ['type' => 'page'])}}">--}}
{{--                        <div class="media">--}}
{{--                            <div class="media-body">--}}
{{--                                <h5>Trang tĩnh</h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <br>--}}
{{--                        <div class="media">--}}
{{--                            <div class="media-body"><span class="progress-heading">Danh sách trang tĩnh</span></div>--}}
{{--                        </div>--}}
{{--                        <i class="bg-icon text-center fa fa-list-ul"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <div class="col-md-8 col-lg-8 col-xl-4">--}}
{{--                    <a class="activity-block warning" href="{{route('nqadmin::post.create.get', ['type' => 'page'])}}">--}}
{{--                        <div class="media">--}}
{{--                            <div class="media-body">--}}
{{--                                <h5>Thêm trang tĩnh</h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <br>--}}
{{--                        <div class="media">--}}
{{--                            <div class="media-body"><span class="progress-heading">Thêm trang tĩnh</span></div>--}}
{{--                        </div>--}}
{{--                        <i class="bg-icon text-center fa fa-edit"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

@endsection