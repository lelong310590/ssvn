<div class="box-course-other">
    <h2 class="txt-title-home">Các Khóa đào tạo tương tự</h2>
    <div class="main-course-other">
        <div class="box-list">
            <h3 class="txt-title">Các khóa liên quan </h3>
            <div class="list-course-other">
                @foreach($relate as $c)
                    @include('nqadmin-course::frontend.components.course.relate',['data'=>$c])
                @endforeach

            </div>
        </div>

        <div class="box-list">
            <h3 class="txt-title">Các khóa bán chạy </h3>
            <div class="list-course-other">
                @foreach($top as $c)
                    @include('nqadmin-course::frontend.components.course.relate',['data'=>$c])
                @endforeach
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="javascript:void(0)" class="less"><i class="fas fa-chevron-down"></i></a>
    </div>
</div>