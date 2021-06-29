<div class="container">
    <div class="products tab-custom">
        <h2>Truy cập không giới hạn tới hơn 24.000 Khóa đào tạo</h2>
        <div class="tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#tab-1" role="tab" aria-selected="true">Mới nhất</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-2" role="tab" aria-selected="false">Được quan tâm nhất</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-3" role="tab" aria-selected="false">Khóa đào tạo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-4" role="tab" aria-selected="false">Bài trắc nghiệm</a>
                </li>
            </ul>
        </div>
        <div class="tab-content product-list list-4">
            <div class="tab-pane fade active in" id="tab-1" role="tabpanel">
                @include('nqadmin-dashboard::frontend.components.course_list_slide',['datas' => $topNews, 'type' => 'mostview'])
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                @include('nqadmin-dashboard::frontend.components.course_list_slide',['datas' => $topAll, 'type' => 'level4'])
            </div>
            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                @include('nqadmin-dashboard::frontend.components.course_list_slide',['datas' => $topCourse, 'type' => 'level1'])
            </div>
            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                @include('nqadmin-dashboard::frontend.components.course_list_slide',['datas' => $topCheck, 'type' => 'level2'])
            </div>
        </div>
    </div>
</div>
<!--products-->