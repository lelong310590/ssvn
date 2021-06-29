<?php
$meta_value = $data->data->where('meta_key', $name)->first();
?>
<div class="form col-xs-7">
    @isset($type)
        <textarea rows="5" class="input-form" name="{{ $name }}[]">{!! $meta_value?$meta_value->meta_value:'' !!}</textarea>
    @else
        <div class="box-select">
            <textarea rows="5" class="input-form" name="{{ $name }}[]" style="height: auto">{!! $meta_value?$meta_value->meta_value:'' !!}</textarea>
        </div>
    @endisset
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])