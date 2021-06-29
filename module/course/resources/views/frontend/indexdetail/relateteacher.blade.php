<div class="content-favorite-course">
    <h3 class="txt-title-home">Các khóa khác của thầy cô</h3>
    <div class="row list-favorite-course">
        @foreach($course->getRelateCourseByTeacher() as $rlt)
            @include('nqadmin-course::frontend.components.main-course-stand',['data'=>$rlt])
        @endforeach
    </div>
</div>