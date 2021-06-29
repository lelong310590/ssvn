<div class="list row">
    <div class="col-xs-6 left-list">
        <a href="{{ route('front.course.buy.get',['slug'=>$data->slug]) }}" class="img pull-left">
            <img src="{{asset(isset($data->getLdp->thumbnail)?$data->getLdp->thumbnail:'adminux/img/course-df-thumbnail.jpg')}}" alt="" width="" height="">
        </a>
        <div class="overflow content">
            <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$data->slug]) }}">{{ $data->name }} </a></h4>
            <div class="clearfix info">
                <div class="hour">
                    <i class="far fa-clock"></i> {{ secToHR($data->getDuration(), true) }}
                </div>
                <div class="date">
                    <i class="fas fa-sync-alt"></i> Cập nhật {{ $data->updated_at->format('d-m-Y') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 right-list">
        <div class="star pull-left">
            <i class="fas fa-star"></i> {{ $data->getAverageRating() }}
        </div>
        <div class="pull-left number-user">
            <i class="fas fa-user"></i> {{ $data->getTotalStudent() }}
        </div>
        @include('nqadmin-course::frontend.components.course.price-stand',['item'=>$data])
    </div>
</div>