<li class="vj-cart box-buy pull-left">
    <a href="javascript:void(0)" class="mobile-cart-button">
        <i class="fal fa-shopping-cart"></i>
        @if(Cart::content()->count())
            <span class="badge">{{Cart::content()->count()}}</span>
        @endif
    </a>

    <div class="box-dropdown mobile-cart-wrapper">
        <div class="form-dropdown form-dropdown-top-center form-buy form-default">
            @if(Cart::content()->count())
                <div class="box-info">
                    @foreach(Cart::content() as $data)
                        @php($course=\Course\Models\Course::find($data->id))
                        @include('nqadmin-dashboard::frontend.components.header.dropdown.cart.item')
                    @endforeach
                </div>
                <div class="bottom">
                    <div class="box-total-price clearfix">
                        <span class="pull-left">Tổng tiền:</span>
                        <div class="price pull-right">
                            <span class="news pull-left">{{ Cart::subtotal(0) }} VND</span>
                        </div>
                    </div>
                    @if(empty(request('couponCode')))
                        <a href="{{ route('front.cart.checkout.get') }}" class="btn btn-default-yellow">Thanh Toán</a>
                    @else
                        <a href="{{ route('front.cart.checkout.get',['code'=>request('couponCode')]) }}" class="btn btn-default-yellow">Thanh Toán</a>
                    @endif
                </div>
            @else
                <div class="box-info">
                    Chưa thêm Khóa đào tạonào vào giỏ hàng
                </div>
            @endif
        </div>
    </div>

    <div class="mobile-cart-backdrop hidden-md hidden-lg"></div>

</li>

@push('js')
    <script>
        $('.main-course .course .bottom-course a.view-fast').each(function () {
            $(this).click(function () {
                var course_id = $(this).prev().val();
                $.ajax({
                    type: 'POST',
                    url: '{!! route('front.home.quickview.get') !!}',
                    data: {
                        _token: "{!! csrf_token() !!}",
                        course_id: course_id
                    },
                    dataType: 'json',
                    error: function (data) {
                        console.log(data);
                    },
                    success: function (data) {
                        $('.box-view-fast').html(data.html).show();
                        $('.bg-overflow').show();
                        $('#dang-ky-hoc').click(function () {
                            $('.box-view-fast').hide();
                            $('.bg-overflow').hide();
                            addToCart(course_id);
                        });
                        $('.box-view-fast .close-popup').click(function () {
                            $(this).parent().hide();
                            $('.bg-overflow').hide();
                        });
                    }
                })
            })
        });

        $('#addtocart').click(function () {
            var course_id = $(this).attr('rel');
            addToCart(course_id);
        });

        function addToCart(course_id) {
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{!! route('front.cart.addtocart.post') !!}', // the url where we want to POST
                data: {
                    _token: "{!! csrf_token() !!}",
                    course_id: course_id,
                    type: "ajax",
                },
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                    $('#message_alert').html(data.alert);
                    if (data.code) {
                        $('.box-buy').html(data.html);
                    }
                }
            })
        }

        $('#addtocartfree').click(function () {
            var course_id = $(this).attr('rel');
            addToCartFree(course_id);
        });

        function addToCartFree(course_id) {
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{!! route('front.cart.addtocart.post') !!}', // the url where we want to POST
                data: {
                    _token: "{!! csrf_token() !!}",
                    course_id: course_id,
                    type: "ajax",
                },
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                }
            })
        }

        function removeToCart(course_id) {
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '{!! route('front.cart.removetocart.post') !!}', // the url where we want to POST
                data: {
                    _token: "{!! csrf_token() !!}",
                    course_id: course_id
                },
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                    $('#message_alert').html(data.alert);
                    if (data.code) {
                        $('.box-buy').html(data.html);
                    }
                }
            })
        }
    </script>
@endpush