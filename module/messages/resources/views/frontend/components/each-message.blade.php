<div class="list-message {{ $detail->sender!=\Auth::id()?'your-message':'me-message' }}">
    <div class="main">
        <div class="content">
            <p>{{ $detail->message }}</p>
        </div>
        <div class="bottom clearfix">
            <span class="day pull-left">{{ $detail->created_at }}</span>
        </div>
    </div>
</div>