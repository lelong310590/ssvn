<div class="box-review">
    <h3 class="txt-title-home">Đánh giá</h3>
    <div class="content-review">
        <div class="pull-left left-review text-center">
            <div class="number-review">
                <span>{{ $course->getAverageRating() }}</span>
            </div>
            <div class="box-star">
                @include('nqadmin-course::frontend.components.course.only_star',['item'=>$course->getAverageRating()])
            </div>
            <p>Đánh giá trung bình</p>
        </div>
        <div class="overflow right-review">
            @for($i=5; $i>0; $i--)
                <?php
                $total_review = $course->getRating->where('rating_number', $i)->count();
                $percent = $course->getRating->count() > 0 ? round($total_review / $course->getRating->count() * 100) : 0;
                ?>
                <div class="list">
                    <div class="box-chart">
                        <div class="chart">
                            <span class="finish" style="width: {{ $percent  }}%"></span>
                        </div>
                    </div>
                    <div class="box-star text-right">
                        <div class="pull-left">
                            <ul class="clearfix star-five">
                                @for($j=1; $j<=$i; $j++)
                                    <li class="pull-left"><i class="fas fa-star"></i></li>
                                @endfor
                            </ul>
                        </div>
                        <div class="overflow result">
                            <p>{{ $percent }}%</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>


<div class="box-review-comment" id="ratings">
    <div class="top clearfix">
        <h3 class="txt-title-home pull-left">Nhận xét</h3>
        <div class="overflow ">
            <div class="pull-right">
                <div class="box-search">
                    <form method="post" id="searchComment">
                        <div class="form-group">
                            <input type="text" placeholder="Search in Reviews" name="srating" value="{{ request('srating') }}" data-purpose="search-input" class="txt-form">
                            <button type="submit" class="btn btn-search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="list-review-comment ">
        
        <div id="search-loading" style="display: none">
            <img src="{{asset('frontend/images/loading.apng')}}" alt="" class="img-responsive center-block">
        </div>
        
        <div class="main-review-comment" id="comment-list">
            @foreach($ratings as $rating)
                <div class="content-review-comment">
                    <div class="left-review-comment pull-left">
                        <div class="pull-left img img-circle">
                            @if (!empty($rating->owner->thumbnail))
                                <img src="{{ asset($rating->owner->thumbnail) }}" alt="">
                            @else
                                <div class="img-user-by-name">{{ substr($rating->owner->first_name, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="overflow content">
                            <p class="time">{{ time_elapsed_string($rating->created_at) }}</p>
                            <p class="name">{{ $rating->owner->first_name }}</p>
                        </div>
                    </div>
                    <div class="right-review-comment overflow">
                        <div class="box-star">
                            @include('nqadmin-course::frontend.components.course.only_star',['item'=>$rating->rating_number])
                        </div>
                        <div class="des-comment">
                            <div class="content">
                                {{ $rating->content }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center" id="comment-list-more">
            <a href="javascript:void(0)" class="less"><i class="fas fa-chevron-down"></i></a>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#searchComment').on('submit', function (e) {
            $('#search-loading').show();
            $('#comment-list').html('');
            $('#comment-list-more').hide();
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('front.ajax.searchComment')}}",
                data: {
                    _token: $('meta[name=csrf-token]').attr("content"),
                    keywords: $('input[name="srating"]').val(),
                    cid: '{{$course->id}}'
                },
            })
            .done(function(resp) {
                $('#comment-list').html(resp.data);
            })
            .always(function(resp) {
                $('#search-loading').hide();
                $('#comment-list-more').show();
            })
        })

    </script>
@endpush