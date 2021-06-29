<span class="close-popup"></span>
<div class="content-view-fast">
    <div class="top">
        <h2 class="txt-title">{{ $course->name }}</h2>
        <p class="des-top">{{ $course->owner->first_name }} / {{ $course->owner->position }}</p>
    </div>
    <div class="detail row">
        <div class="col-xs-6 left-detail">
            <div class="box-video">
                <div class="show-img">
                    <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}">
                        <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 right-detail">
            <div class="row list">
                <div class="col-xs-6 quick-view-detail-item">
                    <span class="icon pull-left">
                        <i class="far fa-clock"></i>
                    </span>
                    <span class="overflow">Thời lượng: {{ secToHR($course->getDuration()) }}</span>
                </div>
                <div class="col-xs-6 quick-view-detail-item">
                    <span class="icon pull-left">
                        <i class="far fa-user-circle"></i>
                    </span>
                    <span class="overflow">Trình độ: {{ $classlevel->name }}</span>
                </div>
                <div class="col-xs-6 quick-view-detail-item">
                    <span class="icon pull-left">
                        <i class="far fa-play-circle"></i>
                    </span>
                    <span class="overflow"> Bài học: {{ $course->getCurriculumVideo() }}</span>
                </div>
                <div class="col-xs-6 quick-view-detail-item">
                    <div class="box-star">
                        @include('nqadmin-course::frontend.components.course.star',['item'=>$course])
                    </div>
                </div>
                <div class="col-xs-6 quick-view-detail-item">
                    <span class="icon pull-left"></span>
                    <span class="overflow">{{ $course->getTotalStudent() }} Học viên theo học</span>
                </div>
            </div>
            @include('nqadmin-course::frontend.components.course.price-quickview',['item'=>$course])
            <div class="des">
                <p>{!! strip_tags(str_limit($course->getLdp->description, '300', '...')) !!}</p>
            </div>
            <div class="bottom row">
                <div class="col-xs-6">
                    @if(!$course->checkBought())
                        <input type="hidden" id="" value="{{ $course->id }}">
                        <a href="javascript:;" class="btn btn-default-yellow" id="dang-ky-hoc">Đăng ký học</a>
                    @endif
                </div>
                <div class="col-xs-6">
                    <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}" class="btn btn-default-yellow">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>