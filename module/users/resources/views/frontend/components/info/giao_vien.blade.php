<?php
$value = $data->getOriginal('position');
?>
<div class="box-additional-information giao_vien {{ $value=='giao_vien'?'':'hidden' }}">
    <div class="form-group row">
        <label class="txt-label col-xs-3 text-right">Học vị</label>
        @include('nqadmin-users::frontend.components.info.text',['name'=>'degree'])
    </div>

    <div class="form-group row">
        <label class="txt-label col-xs-3 text-right">Bộ môn</label>
        @include('nqadmin-users::frontend.components.info.text',['name'=>'subject'])
    </div>

    <div class="form-group row">
        <label class="txt-label col-xs-3 text-right">Giới thiệu ngắn</label>
        @include('nqadmin-users::frontend.components.info.textarea',['name'=>'description'])
    </div>

    <div class="form-group row">
        <label class="txt-label col-xs-3 text-right">Năm kinh nghiệm</label>
        @include('nqadmin-users::frontend.components.info.text',['name'=>'year_experience'])
    </div>

    <div class="form-group row">
        <label class="txt-label col-xs-3 text-right">Người theo dõi</label>
        @include('nqadmin-users::frontend.components.info.text',['name'=>'follower'])
    </div>
</div>