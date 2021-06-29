<div class="list-message not-seen">
    <div class="top clearfix">
        <div class="box-img pull-left left">
            <a href="#" class="img pull-left img-circle">
                @if(!empty($chat_user))
                    @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$chat_user])
                @else
                    <img src="{{ asset('frontend/images/anonymous.png') }}" alt="" width="" height="">
                @endif
            </a>
        </div>
        <div class="overflow main right">
            <h4 class="name pull-left"><a href="#">{{ !empty($chat_user)?$chat_user->first_name:'Tin nhắn mới' }}</a></h4>
        </div>
    </div>
    <div class="content">
        <div class="pull-left left icon"></div>
        <div class="overflow right des">
            <p>Tin nhắn mới</p>
        </div>
    </div>
</div>