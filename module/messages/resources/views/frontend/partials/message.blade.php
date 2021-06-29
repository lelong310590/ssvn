@foreach($user->messages as $message)
    <div class="list-message {{ $message->seen=='disable'?'not-seen':'watched' }}">
        <?php
        $temp_user = $message->getMessage->sender != $user->id ? $message->getMessage->getSender : $message->getMessage->getReceiver;
        ?>
        <div class="top clearfix">
            <div class="box-img pull-left left">
                <a href="#" class="img pull-left img-circle">
                    @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$temp_user])
                </a>
            </div>
            <div class="overflow main right">
                <h4 class="name pull-left"><a href="{{ route('front.message.index.get',['message_id'=>$message->message_id]) }}">{{ $temp_user->first_name }}</a></h4>
                <span class="pull-right">{{ $message->getMessage->getDetail->last()->created_at }} </span>
            </div>
        </div>
        <div class="content">
            <div class="pull-left left icon {{ $message->type=='star'?'favorite':'' }} check-favorite" rel="{{ $message->id }}">
                <i class="fas fa-star"></i>
            </div>
            <div class="overflow right des">
                <p>{{ $message->getMessage->getDetail->last()->message }}</p>
            </div>
            {{--<a href="#delete-box" class="delete btn-popup">--}}
            {{--<i class="fas fa-ban"></i>--}}
            {{--</a>--}}
        </div>
    </div>
@endforeach

@push('js')
    <script>
        $('.check-favorite').click(function () {
            var $this = $(this);
            var message = $(this).attr('rel');
            $.ajax({
                type: 'POST',
                url: '{!! route('front.message.star.post') !!}',
                data: {
                    _token: "{!! csrf_token() !!}",
                    message: message,
                },
                dataType: 'json',
                error: function (data) {
                    console.log(data);
                },
                success: function (data) {
                    if (data.action == 'add')
                        $this.addClass('favorite');
                    else
                        $this.removeClass('favorite');
                }
            })
        });
    </script>
@endpush