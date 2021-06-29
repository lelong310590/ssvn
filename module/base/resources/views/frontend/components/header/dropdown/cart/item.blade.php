<div class="list clearfix">
    <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}" class="img pull-left">
        <img src="{{ asset($course->getThumbnail()) }}" alt="" width="" height="">
    </a>
    <div class="overflow">
        <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}">{{ $course->name }} </a></h4>
        <div class="price clearfix">
            @include('nqadmin-course::frontend.components.course.price-dropdown',['item'=>$course])
            <a class="pull-right" href="javascript:void(0)" onclick="return removeToCart('{!! $data->rowId !!}')" title="Xóa khỏi giỏ hàng">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>