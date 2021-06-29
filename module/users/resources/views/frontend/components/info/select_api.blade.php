<?php
$meta_value = $data->data->where('meta_key', $name)->first();

$name_attr = $name == 'city' ? 'province_name' : 'district_name';
$value_attr = $name == 'city' ? 'id' : 'id';
?>
<div class="form col-xs-7">
    <div class="box-select">
        <input type="hidden" name="{{ $name }}[]" class="{{ $name }}_value" value="{{ $meta_value?$meta_value->meta_value:'' }}">
        <span class="txt-find input-form {{ isset($type)?'width120':0 }} {{ $name }}_show">{{ isset($meta_value->meta_value)?$meta_value->meta_value:'Chọn' }}</span>
        <ul class="list-select" id="{{ $name }}_list">
            @foreach($options as $key=>$option)
                <li class="{{ $name }}" rel="{{ $option->$name_attr }}" alt="{{ $option->$value_attr }}" data-value="{{ $option->$name_attr }}">{{ $option->$name_attr }}</li>
            @endforeach
        </ul>
    </div>
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])