<div class="list clearfix">
    <div class="img pull-left">
        <a  href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}"><img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height=""></a>
        <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}" class="play"><i class="fas fa-play"></i></a>
    </div>
    <div class="overflow">
        <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}">{{ $course->name }} </a></h4>
        <div class="box-finish overflow">
            <div class="chart">
                <span class="finish" style="width: {{ number_format($course->getProcess()) }}%"></span>
            </div>
            <div class="clearfix">
                <span class="txt pull-left">Hoàn thành {{ number_format($course->getProcess(),0) }}%</span>
                {{--<div class="box-star pull-right">--}}
                    {{--@include('nqadmin-course::frontend.components.course.only_star',['item'=>$course])--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>