<div class="main-review-comment">
    @if ($ratings->isNotEmpty())
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
    @else
        <div class="content-review-comment">
            <p>Không có kết quả nào</p>
        </div>
    @endif

</div>