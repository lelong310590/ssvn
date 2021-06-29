<?php
$meta_value = $data->data->where('meta_key', $name)->first();
?>
<div class="form col-xs-7">
    @isset($type)
        <input type="text" class="input-form" name="{{ $name }}[]" value="{{ $meta_value?$meta_value->meta_value:'' }}">
    @else
        <div class="box-select">
            <input type="text" class="input-form" name="{{ $name }}[]" value="{{ $meta_value?$meta_value->meta_value:'' }}">
        </div>
    @endisset
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])