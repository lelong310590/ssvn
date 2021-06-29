<?php
//danh gia trung binh giao vien
$avg = DB::table('rating')
    ->whereIn('course', function ($query) use ($course) {
        $query->select('id')->from('course')->where('author', $course->owner->id);
    })
    ->avg('rating_number');
//tong danh gia
$total = DB::table('rating')
    ->whereIn('course', function ($query) use ($course) {
        $query->select('id')->from('course')->where('author', $course->owner->id);
    })
    ->count();

?>
<div class="box-info">
    <h3 class="txt-title-home">Thông tin giáo viên </h3>
    <div class="main-info clearfix">
        <div class="box-images pull-left">
            <a href="{{ route('front.users.profile.get',['code'=>$course->owner->getDataByKey('code_user')]) }}" class="img">
                @if (!empty($course->owner->thumbnail))
                    <img src="{{ asset($course->owner->thumbnail) }}" alt="">
                @else
                    <div class="img-user-by-name">{{ substr($course->owner->first_name, 0, 1) }}</div>
                @endif
            </a>
            <div class="text">
                <p><i class="fas fa-star"></i> {{ round($avg,1) }} Trung bình</p>
                <p><i class="fas fa-comment"></i> {{ $total }} đánh giá</p>
                <p><i class="fas fa-user"></i> {{number_format($course->owner->getTotalStudent())}} sinh viên</p>
                <p><i class="fas fa-play-circle"></i> {{ $c }} Khóa đào tạo</p>
            </div>
        </div>
        <div class="overflow">
            <h4 class="name"><a href="{{ route('front.users.profile.get',['code'=>$course->owner->getDataByKey('code_user')]) }}">{{ $course->owner->first_name }}</a></h4>
            <p class="txt">{{ $course->owner->position }}</p>
            <div class="des-comment">
                <div class="content" style="white-space: pre-line;">
                    {!! nl2br(e($course->owner->getDataByKey('description'))) !!}
                </div>
                <a href="javascript:void(0)" class="less"><i class="fas fa-chevron-down"></i></a>
            </div>
        </div>
    </div>
</div>