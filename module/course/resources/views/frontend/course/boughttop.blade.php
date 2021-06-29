@push('js')
    <script src="{{asset('frontend/vendor/FlipClock-master/compiled/flipclock.min.js')}}"></script>
    <script>
        var clock;
        var startTime = parseInt("{{strtotime($course->time_start)}}");
        var now = parseInt("{{time()}}");
        var endTime = parseInt("{{strtotime($course->time_end)}}");

        $(document).ready(function() {
            if (startTime > now) {
                var startClock;
                startClock = $('#getting-started').FlipClock({
                    clockFace: 'HourlyCounter',
                    autoStart: false,
                    callbacks: {
                        stop: function() {
                            location.reload();
                        }
                    }
                });

                startClock.setTime(startTime - now);
                startClock.setCountdown(true);
                startClock.start();
            }

            if (now > startTime & now < endTime) {
                var endClock;

                endClock = $('#getting-end').FlipClock({
                    clockFace: 'HourlyCounter',
                    autoStart: false,
                    callbacks: {
                        stop: function() {
                            location.reload();
                        }
                    }
                });

                endClock.setTime(endTime - now);
                endClock.setCountdown(true);
                endClock.start();
            }

        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('frontend/vendor/FlipClock-master/compiled/flipclock.css')}}">
@endpush

@php
    $now = time();
    $startTime = strtotime($course->time_start);
    $endTime = strtotime($course->time_end);
    $doExam = false;
    if (Auth::check()) {
        $user = Auth::user();
        $check = $user->checkDoExam($course->id);
        $doExam = $check;
    }

@endphp

<div class="boughttop-wrapper">
    <div class="container">
        <div class="top-course">
            <div class="left-course pull-left hidden-xs hidden-sm">
                <div class="img">
                    <div class="show-img">
                        <a href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($lecture->id)?$lecture->id:'#']) }}">
                            <img src="{{ isset($course->getLdp->thumbnail)?asset($course->getLdp->thumbnail):asset('adminux/img/course-df-thumbnail.jpg') }}" alt="" width="" height=""
                                 class="action-image">
                        </a>
                    </div>
                </div>
            </div>
            <div class="right-course overflow">
                <h3 class="name-course">{{ $course->name }}</h3>

                @if ($course->type == 'exam' && $startTime > $now)
                    <div class="course-exam-counter">
                        <p>Thời gian mở đề:</p>
                        <div id="getting-started"></div>
                    </div>
                @else

                @endif

                @if ($course->type != 'exam')
                <a href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($lecture->id)?$lecture->id:'#']) }}" class="btn btn-default-yellow action-button">
                    @if($lecture->type == 'lecture')
                        <i class="fab fa-leanpub"></i> Tiếp tục bài giảng ({{ $last_lecture_index }})
                    @else
                        <i class="fab fa-leanpub"></i> Bắt đầu làm bài ({{ $last_lecture_index }})
                    @endif
                </a>
                @endif


                @if ($course->type == 'exam' && $startTime < $now && $now < $endTime)

                    @if ($doExam)
                        <p style="margin: 0; padding: 0">Bạn đã làm bài thi này rồi.</p>
                        <a
                            href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($lecture->id)?$lecture->id:'#']) .'/test/result' }}"
                            class="btn btn-default-yellow action-button"
                        >
                            <i class="fas fa-clipboard-list"></i> Xem kết qủa
                        </a>
                    @else
                        <a href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($lecture->id)?$lecture->id:'#']) }}" class="btn btn-default-yellow action-button">
                            <i class="fab fa-leanpub"></i> Làm bài thi thử
                        </a>
                    @endif


                    <div class="course-exam-counter">
                        <p>Thời gian kết thúc thi thử:</p>
                        <div id="getting-end"></div>
                    </div>
                @endif

                @if ($course->type == 'exam' && $now > $endTime)
                    <a
                        class="btn btn-default-yellow action-button"
                        href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>isset($lecture->id)?$lecture->id:'#']) .'/test/result' }}"
                    >
                        <i class="fas fa-clipboard-list"></i> Xem kết quả
                    </a>
                @endif

                @if ($course->type != 'exam')
                <div class="clearfix box-star-change">
                    <div class="box-star pull-left">
                        @include('nqadmin-course::frontend.components.course.only_star',['item'=>$course->getYourRating()])
                    </div>


                    <div class="overflow">
                        <a href="#ratingform" class="btn-change-star" data-toggle="modal">Chỉnh sửa xếp hạng</a>
                        <div class="modal fade" id="ratingform">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #ffa477; color: #fff">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 1">&times;
                                        </button>
                                        <h4 class="modal-title">Đánh giá {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form style="margin-top: 15px" id="filter_form" class="box-form-default" method="post" action="{{ route('front.course.rating.post') }}">
                                            <p>Mời bạn đánh giá chất lượng {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}} này</p>
                                            {{ csrf_field() }}
                                            <div class="box-choose box-rate">
                                                @for($i=1; $i<=5; $i++)
                                                    <div class="form-group form-check clearfix">
                                                        <label class="pull-left">
                                                            <input type="radio" name="rate" value="{{ $i }}" {{ $rating_num==$i?'checked':'' }}>
                                                            <span class="icon"><i class="far fa-square"></i></span>
                                                        </label>
                                                        <div class="box-star pull-left" style="margin-left: 20px">
                                                            <ul class="clearfix">
                                                                @for($j=1; $j<=$i; $j++)
                                                                    <li class="pull-left"><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endfor

                                                <div class="form-group">
                                                    <label>Nội dung đánh giá của bạn: </label>
                                                    <textarea name="contentt" class="form-control" placeholder="Viết đánh giá">{{ $rating_cont }}</textarea>
                                                </div>
                                                <input type="hidden" name="id" value="{{ $course->id }}">
                                                <div class="text-center">
                                                    <input type="submit" class="btn btn-default" value="Đánh giá">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>
                </div>
                @endif

                @if ($course->type != 'exam')
                <div class="box-progress">
                    <div class="clearfix">
                        <div class="pull-left">
                            <div class="clearfix">
                                @if($course->type=='test')
                                    <p class="pull-left">
                                        <span>{{ $course->getCountFinishItem() }}</span>/<span>{{ $course->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->count() }}</span> Bộ trắc nghiệm có <span>{{ $course->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->count() }}</span> bài
                                    </p>
                                @else
                                    <p class="pull-left">
                                        <span>{{ $course->getCountFinishItem() }}</span> trong tổng số
                                        <span>{{ $course->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->count() }}</span> mục hoàn thành
                                    </p>
                                @endif
                                @if($course->getCountFinishItem() > 0)
                                    <a onclick="$('#confirm_reset_progress').show();return false;" href="#" class="overflow">Đặt lại tiến độ</a>
                                @endif
                            </div>
                        </div>
                        <div class="overflow">
                            <i class="fas fa-trophy pull-right"></i>
                        </div>
                    </div>
                    <div class="chart">
                        <span class="finish" style="width: {{ number_format($course->getProcess()) }}%;"></span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="box-popup box-popup-login" id="confirm_reset_progress">
            <div class="main-popup">
                <div class="header-popup">
                    <span class="close-popup"></span>
                </div>
                <div class="content-popup">
                    <div class="popup-login">
                        <div class="left">
                            <h3 class="txt-popup">Đặt lại tiến độ</h3>
                            <div class="box-form-default">
                                <div class="form-group">
                                    <label for="">Bạn có chắc chắn muốn đặt lại tiến độ của Khóa đào tạo này?</label>
                                    {{--<input type="text" class="input-form" placeholder="Email" name="email">--}}
                                </div>
                                <div class="clearfix box-btn text-center">
                                    <a href="{{ route('front.course.resetprogress.get',['id'=>$course->id]) }}" class="btn btn-default-yellow btn-small">Tôi đồng ý</a>
                                </div>
                                <div class="bottom text-center">
                                    {{--<p>Bạn chưa có tài khoản? <a href="javascript:;" class="switch-register">Đăng ký</a></p>--}}
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <span class="logo text-center">safecovid</span>
                            {{--<p>Bằng cách đăng ký, bạn đồng ý với Điều khoản sử dụng và Chính sách Bảo mật của chúng tôi.</p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
