<div class="main-right box-new-message">
    <div class="top top-main-right row">
        <div class="left col-xs-9 pull-left">
            <div class="box-img pull-left ">
                <a href="#" class="img pull-left img-circle">
                    @if(!empty($chat_user))
                        @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$chat_user])
                    @else
                        <img src="{{ asset('frontend/images/anonymous.png') }}" alt="" width="" height="">
                    @endif
                </a>
            </div>
            <div class="main pull-left">
                <h4 class="name" style="margin-top: 10px;"><a href="#">{{ !empty($chat_user)?$chat_user->first_name:'Tin nhắn mới' }}</a></h4>
            </div>
        </div>

        <div class="right col-xs-3 ">
            <div class="pull-right">
                <div class="pull-left favorite-message">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="main-right-message">
        <form class="box-form-default" action="{{ route('front.message.send.post') }}" method="post">
            {{ csrf_field() }}
            <div class="new-message">
                @include('nqadmin-messages::frontend.components.find-user')

                <div class="form-group">
                    <textarea class="input-form" placeholder="Viết bình luận của bạn" name="message" required></textarea>
                </div>
                <div class="box-btn">
                    <p class="note">
                        <span class="txt-bold">Lưu ý: </span>Đối với các sự cố kỹ thuật liên quan đến trang web anticovid & ứng dụng dành cho thiết bị di động hoặc các câu hỏi về hoàn lại tiền, vui lòng liên hệ với Bộ phận hỗ trợ .
                    </p>
                    <div class="clearfix list-btn">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-default-yellow btn-send">Gửi tin</button>
                            <a href="{{ route('front.message.index.get') }}" class="btn btn-default-white">Hủy bỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>