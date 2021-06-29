<div class="container">
    <div class="left box-info">
        <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}" class="img pull-left">
            <img src="{{ asset($course->getThumbnail()) }}">
            <i class="fas fa-file-image"></i>
        </a>
        <div class="content overflow">
            <div class="top">
                <a href="{{ route('front.course.buy.get',['slug'=>$course->slug]) }}" class="name">{{ $course->name }}</a>
                <span class="on-off"> - {{ $course->status=='disable'?'Lưu nháp':'Trực tuyến' }}</span>
            </div>
            <p class="user">{{ $course->owner->name }}</p>
        </div>
    </div>
    <div class="right">
        <a href="{{ route('front.users.quan_ly_khoa_hoc_setting.get',['id'=>$id]) }}" class="icon-setting"><i class="fas fa-cog"></i></a>
    </div>
</div>