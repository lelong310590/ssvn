@if ($message = Session::get('success'))
    <div class="flash-backdrop">
        <div class="flash-content">
            <span class="close-popup flash-close"><i class="far fa-times-circle"></i></span>
            <p class="text-center flash-content-logo">anticovid</p>
            {{ $message }}
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="flash-backdrop">
        <div class="flash-content">
            <span class="close-popup flash-close"><i class="far fa-times-circle"></i></span>
            <p class="text-center flash-content-logo">anticovid</p>
            {{ $message }}
        </div>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="flash-backdrop">
        <div class="flash-content">
            <span class="close-popup flash-close"><i class="far fa-times-circle"></i></span>
            <p class="text-center flash-content-logo">anticovid</p>
            {{ $message }}
        </div>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="flash-backdrop">
        <div class="flash-content">
            <span class="close-popup flash-close"><i class="far fa-times-circle"></i></span>
            <p class="text-center flash-content-logo">anticovid</p>
            {{ $message }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="flash-backdrop">
        <div class="flash-content">
            <span class="close-popup flash-close"><i class="far fa-times-circle"></i></span>
            <p class="text-center flash-content-logo">anticovid</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div id="message_alert">

</div>