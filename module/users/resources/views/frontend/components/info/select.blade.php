<?php
if ($name == 'position') {
    $meta_value = (object)[
        "meta_key" => $name,
        "meta_value" => $data->getOriginal($name),
        "status" => "public",
    ];
} else {
    $meta_value = $data->data->where('meta_key', $name)->first();
}

?>
<div class="form col-xs-7">
    <div class="box-select">
        <input type="hidden" name="{{ $name }}[]" class="{{ $name }}_value" value="{{ $key=$meta_value?$meta_value->meta_value:'' }}">
        <span class="txt-find input-form {{ isset($type)?'width120':0 }} {{ $name }}_show">{{ isset($options[$key])?$options[$key]:'Chọn' }}</span>
        <ul class="list-select">
            @foreach($options as $key=>$option)
                <li class="{{ $name }}" rel="{{ $option }}" data-value="{{ $key }}">{{ $option }}</li>
            @endforeach
        </ul>
    </div>
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])