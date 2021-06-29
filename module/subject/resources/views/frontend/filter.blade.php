<form method="get" action="{{ route('front.home.search') }}" id="filter-search">
    <input type="hidden" name="class" value="{{ request('class') }}">
    <input type="hidden" name="subject" value="{{ request('subject') }}">
    <div class="vj-widgets">
        <h4>Đánh giá</h4>
        <ul>
            @for($i=5; $i>0; $i--)
                <li>
                    <label class="vj-checkbox">
                        <input type="checkbox" name="rating[]" value="{{ $i }}" @if(!empty(request('rating'))&&in_array($i,request('rating'))) checked @endif/>
                        <span>
                        @for($j=0; $j<$i; $j++)
                                <i class="fas fa-star"></i>
                            @endfor
                    </span>
                    </label>
                </li>
            @endfor
        </ul>
    </div>
    <div class="vj-widgets">
        <h4>Đặc điểm</h4>
        <ul>
            <li><label class="vj-checkbox"><input type="checkbox" name="video" value="check" @if(!empty(request('video'))) checked @endif/><span>Có video</span></label></li>
            <li><label class="vj-checkbox"><input type="checkbox" name="price[]" value="price"
                                                  @if(!empty(request('price'))&&in_array('price',request('price'))) checked @endif/><span>Có phí</span></label></li>
            <li><label class="vj-checkbox"><input type="checkbox" name="price[]" value="free" @if(!empty(request('price'))&&in_array('free',request('price'))) checked @endif/><span>Không có phí</span></label>
            </li>
        </ul>
    </div>
</form>
@push('js')
    <script>
        $('.vj-widgets ul li label input').bind('change', function () {
            event.preventDefault();
            var formData = $('#filter-search').serialize();
            // process the form
            $.ajax({
                type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                url: "{{ route('front.home.search') }}" + "?" + formData, // the url where we want to POST
                dataType: 'json', // what type of data do we expect back from the server
                cache: false
            }).done(function (data) {
                $('#main-course-search').html(data.html);
            });
        });
    </script>
@endpush