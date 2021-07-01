@inject('courseCurriculumItemsRepository','Course\Repositories\CourseCurriculumItemsRepository')

@php
    $videoBaseUrl = config('app.video_url');
    $hasVideo = $course->getVideoPromo() != "";
    $url = $course->getVideoPromo();
    $videoUrl = explode('/index.m3u8',$url)[0];

    $freeCurri = $courseCurriculumItemsRepository->with(['getMedia' => function ($e) {
        return $e->orderBy('created_at', 'desc')->select(['url', 'thumbnail', 'curriculum_item'])->where('type', 'video/mp4');
    }])->findWhere([
        'preview' => 'active',
        'status' => 'active',
        'course_id' => $course->id
    ], ['name', 'id']);

@endphp

@if($hasVideo)
    <div class="modal fade" id="previewPromo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Giới thiệu về Khóa đào tạo</h4>
                </div>
                <div class="modal-body">
                    <video id="my-video" class="video-js" controls preload="auto" width="100%" height="264"
                           poster="{{ ($course->getThumbnail()) }}" data-setup='{"fluid": true}'>
                        <source src="{{ $videoBaseUrl.$videoUrl }}" type='video/mp4'>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>

                    @if (!empty($freeCurri))
                        <div class="other-preview">
                            <p class="other-preview-title">Các nội dung trong khóa học</p>
                            <div class="other-preview-list">
                                <div class="other-preview-list-item">
                                    <a href="javascript:;" data-link="{{$videoBaseUrl.$videoUrl}}" class="active-preview">
                                        <div class="other-preview-thumbnail">
                                            <img src="{{ asset($course->getThumbnail()) }}" alt="" class="img-responsive">
                                        </div>
                                        <div class="other-preview-description">
                                            <i class="far fa-play-circle"></i>
                                            <span>Video giới thiệu</span>
                                        </div>
                                    </a>
                                </div>
                                @foreach($freeCurri as $curi)
                                    @php
                                        $url = isset($curi->getMedia[0]) ? $curi->getMedia[0]->url : '';
                                        $thumbnail = isset($curi->getMedia[0]) ? $curi->getMedia[0]->thumbnail : '';
                                    @endphp
                                    <div class="other-preview-list-item">
                                        <a href="javascript:;" data-link="{{$videoBaseUrl.$url.''}}" id="video{{ $curi->id }}">
                                            <div class="other-preview-thumbnail">
                                                <img src="{{asset($thumbnail)}}" alt="" class="img-responsive">
                                            </div>
                                            <div class="other-preview-description">
                                                <i class="far fa-play-circle"></i>
                                                <span>{{$curi->name}}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endif
<div class="col-xs-4 col-xs-push-8 right-buy-course">
    <div class="box-info-course">
        <div class="box-video">
            <a href="javascript:;" class="{{$hasVideo ? 'clickModalPreview show-img' : 'show-img'}}">
                <div class="box-img">
                    <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
                    @if ($course->type == 'normal')
                        <div class="overlay-preview">
                            <i class="far fa-play-circle"></i>
                        </div>
                    @endif
                </div>
            </a>
        </div>

        <div class="detail-course">

            @if ($course->price != 0)
                @include('nqadmin-course::frontend.components.course.price-detail',['item'=>$course])
            @endif
            {{--<p>Giúp nhóm của bạn tiếp cận với 2.000 Khóa đào tạo hàng đầu của Udemy mọi lúc, mọi nơi.</p>--}}

            <div class="box-btn row">
                @if($course->price==0)
                    <div class="col-xs-12">
                        <form method="post" action="{{ route('front.cart.checkoutfree.post',['id'=>$course->id]) }}" id="addtocheckout">
                            {{ csrf_field() }}
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="couponCode" value="{{ request('couponCode') }}">
                            @if (auth()->check())
                                <a href="javascript:;" class="btn btn-default-yellow" onclick="return document.getElementById('addtocheckout').submit();">Tham gia ngay</a>
                            @else
                                <a href="#login-box" class="btn btn-default-yellow btn-popup center-block">Tham gia ngay</a>
                            @endif
                        </form>
                    </div>
                @else
                    <div class="col-xs-6">
                        <form method="post" action="{{ route('front.cart.addtocart.post') }}" id="addtocheckout">
                            {{ csrf_field() }}
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="couponCode" value="{{ request('couponCode') }}">
                            <a href="javascript:;" class="btn btn-default-yellow" onclick="return document.getElementById('addtocheckout').submit();">Mua ngay</a>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <a href="#" class="btn btn-default-white" id="addtocart" rel="{{ $course->id }}">Thêm vào giỏ hàng</a>
                    </div>
                @endif
            </div>

            @if($course->price != 0)
                <div class="form-sale">
                    <div class="form-group">
                        <input type="search" class="txt-form" placeholder="Nhập mã khuyến mại" value="{{ request('couponCode') }}" id="coupon_code">
                        <button class="btn btn-default-yellow" onclick="return accept_code('{{ route('front.course.buy.get',['slug'=>$course->slug]) }}');">Áp dụng</button>
                    </div>
                </div>
            @endif

            <div class="list">
                @if ($course->type == 'normal')
                    <p><i class="far fa-clock"></i><span class="txt">Thời gian:</span> {{ secToHR($duration) }}</p>
                @endif

{{--                <p><i class="fas fa-suitcase"></i><span class="txt">Trình độ:</span> {{ isset($level->name)?$level->name:'' }}</p>--}}

                @if ($course->type == 'normal')
                    <p><i class="fas fa-book"></i><span class="txt">Bài giảng:</span> {{ $course->getCurriculumVideo() }} bài </p>
                @endif

                <p><i class="fas fa-file"></i><span class="txt">Học liệu:</span> {{ $hoclieu }} </p>

                @if ($course->type == 'test')
                    <p><i class="fas fa-book"></i><span class="txt">Trắc nghiệm:</span> {{ $course->countCurriculumTest() }} bài </p>
                @endif
            </div>

        </div>
    </div>
    <!--box-info-course-->


</div>

@push('js')
    <link href="https://vjs.zencdn.net/7.0.5/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.0.5/video.js"></script>
    <script type="text/javascript">
        var player = videojs('my-video');
        $('.clickModalPreview').on('click', function (e) {
            $('#previewPromo').modal()
        })

        $('#previewPromo').on('hidden.bs.modal', function (e) {
            // do something...
            player.pause();
        })

        $('.other-preview-list-item a').on('click', function (e) {
            var _this = $(e.currentTarget);
            $('.other-preview-list-item a').removeClass('active-preview');
            _this.addClass('active-preview');
            var link = _this.attr('data-link');
            player.src({type: 'video/mp4', src: link});
            player.play();
        })

        function accept_code(url) {
            var coupon_code = $('#coupon_code').val();
            if (coupon_code != '') {
                window.location.href = url + '?couponCode=' + coupon_code;
            }
        }
    </script>
@endpush

@push('css')
    <style>
        #previewPromo .modal-dialog {
            width: 700px;
        }

        #previewPromo .modal-header {
            background: #ffa477;
            color: #fff
        }

        #previewPromo .modal-header .close {
            opacity: 1;
            color: #fff;
        }

        #previewPromo .modal-body {
            padding: 0
        }
    </style>

@endpush