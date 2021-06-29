<h3 class="txt-title-home">Hoạt động gần đây</h3>
<div class="row list-active">
    <div class="col-xs-6 content-active">
        <div class="border-eee">
            <div class="main">
                <div class="clearfix list">
                    <h3 class="txt-top">Câu hỏi gần đây</h3>
                </div>
                @foreach($questions as $q)
                    <div class="clearfix list">
                        <a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>3,'questionId'=>$q->id]) }}" class="img-circle img pull-left">
                            <img src="{{asset(isset($q->owner->thumbnail)?$q->owner->thumbnail:'')}}" alt="" width="" height="">
                        </a>
                        <div class="overflow">
                            <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>3,'questionId'=>$q->id]) }}">{!! $q->content !!}</a></h4>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center list show-more">
                <a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>3]) }}">Xem tất cả các câu hỏi</a>
            </div>
        </div>
    </div>
    <div class="col-xs-6 content-active">
        <div class="border-eee">
            <div class="main">
                <div class="clearfix list">
                    <h3 class="txt-top">Thông báo từ giáo viên</h3>
                </div>
                @foreach($answers as $a)
                    <div class="clearfix list">
                        <a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>4]).'#'.$a->id }}" class="img-circle img pull-left">
                            <img src="{{asset(isset($q->owner->thumbnail)?$q->owner->thumbnail:'')}}" alt="" width="" height="">
                        </a>
                        <div class="overflow">
                            <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>4]).'#'.$a->id }}">{!! $a->content !!}</a></h4>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center list show-more">
                <a href="{{ route('front.course.buy.get',['slug'=>$course->slug,'tab'=>4]) }}">Xem tất cả các thông báo</a>
            </div>
        </div>
    </div>
</div>