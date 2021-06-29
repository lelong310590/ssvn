<div class="top-message">
    <h2 class="txt-title">Tin nhắn <i class="far fa-comments"></i></h2>
    <p class="txt">Bạn có {{ $user->messages->where('seen', 'disable')->count() }} tin nhắn chưa đọc</p>
</div>