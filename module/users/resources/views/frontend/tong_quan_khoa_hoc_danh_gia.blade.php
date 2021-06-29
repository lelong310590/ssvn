<?php
use Illuminate\Support\Facades\DB;
?>
@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="container">
                <div class="box-overview-management">
                    <div class="box-filtered text-center top-overview-management">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.topmenu')
                    </div>
                    <!--top-overview-management-->

                    <div class="box-overview-qa row">
                        <div class="col-xs-3 left-overview-qa">
                            <form id="filter_form" class="box-form-default" method="get" action="">
                                <div class="box-dropdown-single">
                                    <div class="dropdown-single">
                                        <select class="show-txt" name="course">
                                            <option value="0">Tất cả các Khóa đào tạo</option>
                                            <option value="1">Cũ nhất</option>
                                        </select>
                                        {{--<span class="show-txt">Tất cả các Khóa đào tạo<i class="fas fa-chevron-down pull-right"></i></span>--}}
                                        {{--<ul class="form-dropdown">--}}
                                        {{--<li><a href="#" class="active">Tất cả các Khóa đào tạo</a> </li>--}}
                                        {{--<li><a href="#">Cũ nhất</a> </li>--}}
                                        {{--</ul>--}}
                                    </div>
                                </div>

                                <div class="box-choose">
                                    <div class="form-group form-check">
                                        <label>
                                            <input type="checkbox" value="1" name="not_reply" <?php if (isset($_REQUEST['not_reply'])) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            Không trả lời
                                        </label>
                                    </div>
                                </div>

                                <div class="box-choose box-rate">
                                    <div class="form-group form-check clearfix">
                                        <label class="pull-left">
                                            <input type="radio" name="rate" value="1" <?php if (isset($_REQUEST['rate']) && $_REQUEST['rate'] == 1) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            1 Sao
                                        </label>
                                        <div class="box-star pull-left">
                                            <ul class="clearfix">
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-group form-check clearfix">
                                        <label class="pull-left">
                                            <input type="radio" name="rate" value="2" <?php if (isset($_REQUEST['rate']) && $_REQUEST['rate'] == 2) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            2 Sao
                                        </label>
                                        <div class="box-star pull-left">
                                            <ul class="clearfix">
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-group form-check clearfix">
                                        <label class="pull-left">
                                            <input type="radio" name="rate" value="3" <?php if (isset($_REQUEST['rate']) && $_REQUEST['rate'] == 3) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            3 Sao
                                        </label>
                                        <div class="box-star pull-left">
                                            <ul class="clearfix">
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-group form-check clearfix">
                                        <label class="pull-left">
                                            <input type="radio" name="rate" value="4" <?php if (isset($_REQUEST['rate']) && $_REQUEST['rate'] == 4) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            4 Sao
                                        </label>
                                        <div class="box-star pull-left">
                                            <ul class="clearfix">
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="form-group form-check clearfix">
                                        <label class="pull-left">
                                            <input type="radio" name="rate" value="5" <?php if (isset($_REQUEST['rate']) && $_REQUEST['rate'] == 5) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            5 Sao
                                        </label>
                                        <div class="box-star pull-left">
                                            <ul class="clearfix">
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                                <li class="pull-left"><i class="fas fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-dropdown-single">
                                    <span class="txt">Sắp xếp theo:</span>
                                    <div class="dropdown-single">
                                        <select class="show-txt" name="rating">
                                            <option value="0">Mới nhất</option>
                                            <option value="1" <?php if (isset($_REQUEST['rating']) && $_REQUEST['rating'] == 1) {
                                                echo 'selected';
                                            }?>>Cũ nhất
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-9 right-overview-qa">
                            <div class="box-detail-question">
                                @foreach($ratings as $rating)
                                    <div class="list-course-announcement ">
                                        <?php
                                        $ldp = DB::table('course_ldp')
                                            ->where('course_id', $rating->course)
                                            ->first();
                                        ?>
                                        <div class="top-course-announcement clearfix box-info">
                                            <a href="#" class="img pull-left">
                                                <img src="{{asset(isset($ldp->thumbnail)?$ldp->thumbnail:'adminux/img/course-df-thumbnail.jpg')}}">
                                                <i class="fas fa-file-image"></i>
                                            </a>
                                            <div class="overflow">
                                                <h4 class="name"><a href="#">{{ $rating->getcourse->name }}</a></h4>
                                                <div class="box-star pull-left">
                                                    <ul class="clearfix">
                                                        @while($rating->rating_number>0)
                                                            <li class="pull-left"><i class="fas fa-star"></i></li>
                                                            <?php $rating->rating_number--;?>
                                                        @endwhile
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment-course">
                                            <div class="main-comment-course">
                                                <div class="list-comment">
                                                    <div class="left">
                                                        <a href="#" class="img pull-left img-circle">
                                                            <img src="{{asset(isset($rating->owner->thumbnail)?$rating->owner->thumbnail:'')}}" alt="" width="" height="">
                                                        </a>
                                                        <div class="overflow content">
                                                            <div class="top clearfix">
                                                                <h4 class="name pull-left"><a href="#">{{ $rating->owner->first_name }}</a></h4>
                                                                <span class="overflow">{{ time_elapsed_string($rating->created_at) }} <i class="fab fa-font-awesome-flag"></i> </span>
                                                            </div>
                                                            <div class="des">
                                                                <p>{{ $rating->content }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($rating->answer)
                                                    <?php $answer = json_decode($rating->answer);?>
                                                    <div class="comment-child">
                                                        <div class="list-comment">
                                                            <div class="left">
                                                                <a href="#" class="img pull-left img-circle">
                                                                    <img src="{{asset(isset($thump)?$thump:'')}}" alt="" width="" height="">
                                                                </a>
                                                                <div class="overflow content">
                                                                    <div class="top clearfix">
                                                                        <h4 class="name pull-left"><a href="#">{{ $rating->owner->first_name }}</a></h4>
                                                                        <span class="overflow">- Giảng viên  .{{  time_elapsed_string($answer->time) }} <i class="fab fa-font-awesome-flag"></i> </span>
                                                                    </div>
                                                                    <div class="des">
                                                                        <p>{{ $answer->content }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="right editor">
                                                                <div class="right-editor">
                                                                    <a href="javascript:void(0)" class="icon-exclamation"><i class="fas fa-ellipsis-v"></i></a>
                                                                    <div class="link box-dropdown">
                                                                        <div class="form-dropdown form-dropdown-top-right">
                                                                            <div class="list">
                                                                                <a href="{{ route('front.users.delete_answer.post',['id'=>$rating->id]) }}" onclick="return confirm('Are you sure?')">
                                                                                    <p class="overflow">Xóa bỏ</p>
                                                                                </a>
                                                                            </div>
                                                                            <div class="list">
                                                                                <a href="#" onclick="$('#reply{{ $rating->id }}').show();return false;">
                                                                                    <p class="overflow">Sửa</p>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                            </div>
                                            <form class="box-form-default" method="post" action="{{ route('front.users.reply_review.post') }}">
                                                {{ csrf_field() }}
                                                <div class="top-comment-course" id="reply{{ $rating->id }}" <?php if($rating->answer){?>style="display: none;"<?php }?>>
                                                    <div class="main-left">
                                                        <div class="content pull-left">

                                                            <div class="editor">
                                                                <div class="left-editor">
                                                                    <input name="content" type="text" value="{{ isset($rating->answer)?json_decode($rating->answer)->content:'' }}" class="input-form" placeholder="Viết bình luận của bạn">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="main-right">
                                                        <input type="hidden" name="id" value="{{ $rating->id }}">
                                                        <button type="submit" class="btn btn-default-yellow">Thêm câu trả lời</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--list-course-announcement-->
                                @endforeach

                                <div class="box-paging">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            {{ $ratings->appends($_GET)->render() }}
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
    <!--main-page-->
@endsection
@push('js')
    <script>
        $('#filter_form input,select').change(function () {
            $("#filter_form").submit();
        })
    </script>
@endpush