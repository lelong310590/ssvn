<?php
$meta_value = $data->data->where('meta_key', $name)->first();
?>
<div class="form col-xs-7">
    <div class="default">
        <div class="pull-left"><span class="text-default {{ $name }}_show">{{ $meta_value?$meta_value->meta_value:'' }}</span></div>
        <div class="pull-right">
            {{--<span class="text">Đã xác minh</span>--}}
            <a href="javascript:void(0)" class="text-change">Thay đổi {{ $options[$name] }}</a>
        </div>
    </div>
    <div class="change-form">
        <div class="row">
            <div class="col-xs-6">
                <input type="text" class="input-form {{ $name }}_value" name="{{ $name }}[]" value="{{ $meta_value?$meta_value->meta_value:'' }}">
            </div>
            <div class="col-xs-6">
                <div class="pull-right">
                    <a href="javascript:void(0)" class="save pull-left text-right" rel="{{ $name }}">Lưu thay đổi</a>
                    <a href="javascript:void(0)" class="cancel pull-left text-right">Hủy</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])