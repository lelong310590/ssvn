@php
    $targetArray = $target->target;
    $who = isset($targetArray->who) ? $targetArray->who : [];
    $what = isset($targetArray->what) ? $targetArray->what : [];
    $required = isset($targetArray->required) ? $targetArray->required : [];
@endphp

<div class="card-body">
    <p>Bạn đang trên đường để tạo ra một Khóa đào tạo! Các mô tả bạn viết ở đây sẽ giúp học sinh quyết định xem Khóa đào tạo của bạn là khoá học nào cho chúng.</p>
    <br>
    <div class="target-wrapper">
        <p>Những kiến thức và công cụ được yêu cầu?</p>
        <div class="row">
            <ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_1')}}">
                @foreach($required as $item)
                    <li class="ui-state-default">
                        <input type="text"
                               class="form-control"
                               autocomplete="off"
                               name="required[]"
                               placeholder="{{config('course.target_ph_1')}}"
                               value="{{$item}}"
                        >
                        <i class="fa fa-bars move-item"></i>
                        <a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
                    </li>
                @endforeach
                <li class="ui-state-default">
                    <input type="text"
                           class="form-control target-input-content"
                           autocomplete="off"
                           data-name-value="required[]"
                           placeholder="{{config('course.target_ph_1')}}"
                    >
                    <i class="fa fa-bars move-item"></i>
                    <a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
                </li>
            </ul>
            <div class="sortable-add-more col-sm-16 float-left">
                <a href="" class="sortable-add-more-button" data-name-value="required[]"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
            </div>
        </div>
    </div>

    <div class="target-wrapper">
        <p>Ai nên học Khóa đào tạo này?</p>
        <div class="row">
            <ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_2')}}">
                @foreach($who as $item)
                    <li class="ui-state-default">
                        <input type="text"
                               class="form-control"
                               autocomplete="off"
                               name="who[]"
                               placeholder="{{config('course.target_ph_2')}}"
                               value="{{$item}}"
                        >
                        <i class="fa fa-bars move-item"></i>
                        <a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
                    </li>
                @endforeach
                <li class="ui-state-default">
                    <input type="text"
                           class="form-control target-input-content"
                           autocomplete="off"
                           data-name-value="who[]"
                           placeholder="{{config('course.target_ph_2')}}"
                    >
                    <i class="fa fa-bars move-item"></i>
                    <a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
                </li>
            </ul>
            <div class="sortable-add-more col-sm-16 float-left">
                <a href="" class="sortable-add-more-button" data-name-value="who[]"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
            </div>
        </div>
    </div>

    <div class="target-wrapper">
        <p>Học sinh sẽ đạt được những gì hoặc có thể làm sau khi tham gia Khóa đào tạo?</p>
        <div class="row">
            <ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_3')}}">
                @foreach($what as $item)
                    <li class="ui-state-default">
                        <input type="text"
                               class="form-control"
                               autocomplete="off"
                               name="what[]"
                               placeholder="{{config('course.target_ph_3')}}"
                               value="{{$item}}"
                        >
                        <i class="fa fa-bars move-item"></i>
                        <a href="" class="target-delete-item" data-name-value="what[]"><i class="fa fa-times"></i></a>
                    </li>
                @endforeach
                <li class="ui-state-default">
                    <input type="text"
                           class="form-control target-input-content"
                           autocomplete="off"
                           data-name-value="what[]"
                           placeholder="{{config('course.target_ph_3')}}"
                    >
                    <i class="fa fa-bars move-item"></i>
                    <a href="" class="target-delete-item" data-name-value="what[]"><i class="fa fa-times"></i></a>
                </li>
            </ul>
            <div class="sortable-add-more col-sm-16 float-left">
                <a href="" class="sortable-add-more-button"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
            </div>
        </div>
    </div>
</div>