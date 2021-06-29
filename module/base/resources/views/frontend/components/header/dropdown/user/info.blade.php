<a class="info-user clearfix" href="{{route('front.users.info.get')}}">
    <div class="img pull-left">

        @if (!empty(Auth::user()->thumbnail))
            <img src="{{ asset(Auth::user()->thumbnail) }}" alt="" class="round-image">
        @else
            <div class="img-user-by-name">{{substr(Auth::user()->first_name,0,1)}}</div>
        @endif

    </div>
    <div class="overflow">
        <p class="name">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</p>
        <p class="gmail">{{ Auth::user()->email }}</p>
    </div>
</a>