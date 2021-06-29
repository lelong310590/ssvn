<?php
$temp_user = $first_message->getMessage->sender != \Auth::id() ? $first_message->getMessage->getSender : $first_message->getMessage->getReceiver;
?>
<div class="main-right">
    <div class="top top-main-right row">
        <div class="left col-xs-9 pull-left">
            <div class="box-img pull-left ">
                <a href="#" class="img pull-left img-circle">
                    @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$temp_user])
                </a>
            </div>
            <div class="main pull-left">
                <h4 class="name"><a href="#">{{ $temp_user->first_name }}</a></h4>
            </div>
        </div>

        <div class="right col-xs-3 ">
            <div class="pull-right">
                <div class="pull-left favorite-message {{ $first_message->type=='star'?'favorite':'' }} check-favorite" rel="{{ $first_message->id }}">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="main-right-message">
        @foreach($first_message->getMessage->getDetail as $detail)
            @include('nqadmin-messages::frontend.components.each-message')
        @endforeach
    </div>

    <form class="box-form-default" action="{{ route('front.message.send.post') }}" method="post" id="form-send-message">
        <div class="form-message">
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ $temp_user->id }}">
                <input class="form-input" id="message" placeholder="Viết bình luận của bạn" required>
                <input type="submit" value="Gửi tin" class="btn-default-white btn btn-small btn-send">
            </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $('.main-right-message').scrollTop($('.main-right-message')[0].scrollHeight);
        $("#form-send-message").submit(function (e) {
            e.preventDefault();
            var user_id = $('#user_id').val();
            var message = $('#message').val();
            $('#message').val('');
            $.ajax({
                type: 'POST',
                url: '{!! route('front.message.send.post') !!}',
                data: {
                    _token: "{!! csrf_token() !!}",
                    user_id: user_id,
                    message: message,
                },
                dataType: 'json',
                error: function (data) {
                    console.log(data);
                },
                success: function (data) {
                    $('.main-right-message').append(data.html);
                    $('.main-right-message').scrollTop($('.main-right-message')[0].scrollHeight);
                }
            })
        });
    </script>
@endpush