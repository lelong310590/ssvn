<a href="{{ route('front.users.my_course.get') }}">Khóa đào tạocủa tôi</a>
<div class="box-dropdown">
    <div class="form-dropdown form-dropdown-top-center form-like form-default my-course-dropdown">
        @if(Auth::user()->boughtSuccess()->count())
            <div class="box-info">
                @php($boughtSuccess = Auth::user()->boughtSuccess()->slice(0, 4))
                @foreach($boughtSuccess as $item)
                    @php($course=$item->course)
                    @include('nqadmin-dashboard::frontend.components.header.dropdown.my_course.item')
                @endforeach
            </div>
            <div class="bottom">
                <a href="{{ route('front.users.my_course.get') }}" class="btn btn-default-yellow">Xem toàn bộ</a>
            </div>

        @else
            <div class="box-info text-center">
                Bạn chưa mua Khóa đào tạonào
            </div>
        @endif

    </div>
</div>