<div class="box-filtered text-center clearfix">
    <ul class="clearfix">
        <li class="pull-left">
            <a href="{{ route('front.course.buy.get',['tab'=>1,'slug'=>$course->slug]) }}" class="{{ request('tab')==1?'active':'' }}">Tổng quan</a>
        </li>
        <li class="pull-left">
            <a href="{{ route('front.course.buy.get',['tab'=>2,'slug'=>$course->slug]) }}" class="{{ request('tab')==2||empty(request('tab'))?'active':'' }}">
                Nội dung {{($course->type == 'exam') ? 'bài thi' : 'Khóa đào tạo'}}
            </a>
        </li>

        @if ($course->type != 'exam')
        <li class="pull-left">
            <a href="{{ route('front.course.buy.get',['tab'=>3,'slug'=>$course->slug]) }}" class="{{ request('tab')==3?'active':'' }}">
                Hỏi đáp Khóa đào tạo
            </a>
        </li>
        <li class="pull-left">
            <a href="{{ route('front.course.buy.get',['tab'=>4,'slug'=>$course->slug]) }}" class="{{ request('tab')==4?'active':'' }}">Thông báo</a>
        </li>
        @endif
    </ul>
</div>