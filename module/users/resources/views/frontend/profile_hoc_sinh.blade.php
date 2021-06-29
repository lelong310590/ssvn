@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="page-user page-profile">
            <div class="container">
                <div class="box-info-user box-info-student">
                    <div class="left-info text-center pull-left">
                        <div class="img">
                            @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$user])
                        </div>
                    </div>
                    <div class="right-info text-left overflow">
                        <h3 class="txt-title">Đôi nét về tôi</h3>
                        <div class="info clearfix">
                            <h5 class="name pull-left">{{ $user->first_name }}</h5>
                            <p class="competence overflow"> - {{ $user->position }}</p>
                        </div>
                        {{--<div class="bottom clearfix">--}}
                        {{--<div class="box-share pull-left">--}}
                        {{--<ul class="clearfix">--}}
                        {{--<li class="pull-left"><a href="#"><img src="../images/icons/world-map-global-earth-icon.svg" alt="" width="" height=""></a></li>--}}
                        {{--<li class="pull-left"><a href="#"><i class="fab fa-google"></i></a></li>--}}
                        {{--<li class="pull-left"><a href="#"><i class="fab fa-facebook-f"></i></a></li>--}}
                        {{--<li class="pull-left"><a href="#"><i class="fab fa-youtube"></i></a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="pull-right">--}}
                        {{--<a href="#" class="btn btn-default-yellow btn-message">Soạn tin nhắn</a>--}}
                        {{--</div>--}}

                        {{--</div>--}}
                    </div>
                </div>
                <!--box-info-student-->


                <div class="box-tab-notifi">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="studied-tab" data-toggle="tab" href="#studied" role="tab" aria-controls="studied" aria-selected="true" aria-expanded="false">
                                Các khóa đã học của học sinh
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade in active" id="studied" role="tabpanel" aria-labelledby="studied-tab">
                            <div class="box-favorite-course box-course-user">
                                <div class="content-favorite-course">
                                    <div class="row list-favorite-course">
                                        @foreach($user->boughtSuccess() as $item)
                                            @php($course=$item->course)
                                            @include('nqadmin-course::frontend.components.main-course-stand',['data'=>$course])
                                        @endforeach
                                    </div>
                                    {{--<div class="text-center view-all">--}}
                                    {{--<a href="#">Xem thêm</a>--}}
                                    {{--</div>--}}
                                </div>
                                <!--content-favorite-course-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection