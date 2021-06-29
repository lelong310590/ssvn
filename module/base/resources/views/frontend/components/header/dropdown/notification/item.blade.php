<div class="list clearfix">
    <?php
    $tab = empty($item->answer_id) ? 4 : 3;
    $hash = empty($item->answer_id) ? $item->id : $item->answer_id;
    ?>
    <a href="{{ route('front.course.buy.get',['slug'=>$item->getCourses->slug,'tab'=>$tab]).'#'.$hash }}">
        <div class="img pull-left">
            <img src="{{ !empty($item->getAuthor)?asset($item->getAuthor->thumbnail):'' }}" alt="" width="" height="">
        </div>
        <div class="overflow">
            <p class="txt">{{ !empty($item->getAuthor)?$item->getAuthor->first_name.' tạo thông báo':'Có thông báo' }} : {{ $item->title }}</p>
            <span class="day">{{ humanTiming(strtotime($item->created_at)) }} trước</span>
        </div>
    </a>
</div>