<div class="main-course {{Route::currentRouteName() == 'front.users.profile.get' ? 'col-xs-3' : 'col-xs-4'}}">
    <div class="course">
        <div class="img">
            <a href="{{ route('front.course.buy.get',['slug'=>$data->slug]) }}" class="show-img">
                <img src="{{ asset($data->getThumbnail()) }}" alt="" width="" height="">
            </a>
        </div>
        <div class="content">
            <h4 class="txt"><a href="{{ route('front.course.buy.get',['slug'=>$data->slug]) }}">{{ $data->name }}</a></h4>
            <div class="box-star">
                <div class="pull-left">
                    @include('nqadmin-course::frontend.components.course.only_star',['item'=>$data->getAverageRating()])
                </div>
                <div class="overflow">
                    <p>{{ $data->getAverageRating() }} <span>({{ number_format($data->getRating->count()) }})</span></p>
                </div>
            </div>
            <!--box-star-->
            <div class="clearfix">
                @include('nqadmin-course::frontend.components.course.price',['item'=>$data])
            </div>
        </div>
    </div>
</div>