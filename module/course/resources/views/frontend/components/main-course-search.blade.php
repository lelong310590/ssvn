<h1 class="wrap__title"><a href="javascript:void(0)" class="mb__wrap-left"><i class="fal fa-list"></i></a> Tìm kiếm: “{{ request('q') }}”</h1>
<div class="product-list list-3">
    <ul>
        @foreach($course as $item)
            <li>
                <a href="{{ route('front.course.buy.get',['slug'=>$item->slug]) }}" class="pro-img">
                    <img src="{{ asset($item->getThumbnail()) }}" alt="khoa hoc" title="khoa hoc"/>
                </a>
                <p class="pro-lbl">
                    @php
                        $classLevel = $item->getLdp->getClassLevel()->first();
                        $subjects = $item->getLdp->getSubject()->first();
                        $description = $item->getLdp->description;
                    @endphp

                    @if (!empty($subjects))
                        <span class="btn vj-btn">{{$subjects->name}}</span>
                    @endif

                    @if (!empty($classLevel))
                        <span class="btn vj-btn">{{$classLevel->name}}</span>
                    @endif
                </p>
                <h4><a href="{{ route('front.course.buy.get',['slug'=>$item->slug]) }}">{{ $item->name }}</a></h4>
                <div class="pro-bottom">

                    @if($item->checkSaleAvailable())
                        <div class="pull-left">
                            <p class="price old">{{ number_format($item->getOriginal('price')) }} VNĐ</p>
                        </div>
                    @endif
                    <div class="pull-right">
                        <p class="price text-right">
                            @if($item->price==0)
                                <span>Miễn phí</span>
                            @else
                                <span>{{ number_format($item->price) }} </span>VNĐ
                            @endif
                        </p>
                    </div>

                    {{--<span class="star-line">--}}
                    {{--<span class="active"></span>--}}
                    {{--<span></span>--}}
                    {{--<span></span>--}}
                    {{--</span>--}}

                    {{--<span class="pro-view"><i class="far fa-user-tie"></i> 5</span>--}}
                    {{--<span class="pro-buy"><i class="far fa-trophy"></i> 2</span>--}}
                </div>
                <ul class="pro-hover">
                    <li><h4><a href="#">{{ $item->name }}</a></h4></li>
                    <li class="pro-des">
                        {{str_limit(strip_tags($description), 150, '..')}}
                    </li>
                    <li><a href="{{ route('front.course.buy.get',['slug'=>$item->slug]) }}" class="btn vj-btn vj-more">Chi tiết</a></li>
                    <li class="pro-star">
                        @for($i=1; $i <= 5; $i++)
                            @if($i<=$item->getAverageRating())
                                <i class="fas fa-star"></i>
                            @endif
                            @if($i>$item->getAverageRating())
                                @if($i-$item->getAverageRating()==0.5)
                                    <i class="fas fa-star-half"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endif
                        @endfor
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>
</div>
<div class="vj-paging">
    <span>Có tổng số {{ $course->lastPage() }} trang tìm thấy</span>
    {{ $course->appends(request()->input())->render('vendor.pagination.default') }}
</div>