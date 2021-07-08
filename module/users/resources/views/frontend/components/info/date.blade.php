<?php
$meta_value = $data->data->where('meta_key', $name)->first();
$date = $meta_value ? $meta_value->meta_value : '0-0-0';
$date = explode('-', $date);
?>
<div class="form col-xs-12 col-md-7">
    <div class="box-select pull-left">
        <input type="hidden" name="{{ $name }}[]" class="{{ $name }}_value" value="{{ $date[0] }}">
        <span class="txt-find input-form width85 {{ $name }}_show">{{ $date[0]?$date[0]:'Ngày' }}</span>
        <ul class="list-select">
            @for($i=1;$i<=31;$i++)
                <li class="{{ $name }}" rel="{{ $i }}" data-value="{{ $i }}">{{ $i }}</li>
            @endfor
        </ul>
    </div>
    <div class="box-select pull-left">
        <input type="hidden" name="{{ $name }}[]" class="{{ $name }}_value" value="{{ $date[1] }}">
        <span class="txt-find input-form width85 {{ $name }}_show">{{ $date[1]?$date[1]:'Tháng' }}</span>
        <ul class="list-select">
            @for($i=1;$i<=12;$i++)
                <li class="{{ $name }}" rel="{{ $i }}" data-value="{{ $i }}">{{ $i }}</li>
            @endfor
        </ul>
    </div>
    <div class="box-select pull-left">
        <input type="hidden" name="{{ $name }}[]" class="{{ $name }}_value" value="{{ $date[2] }}">
        <span class="txt-find input-form width85 {{ $name }}_show">{{ $date[2]?$date[2]:'Năm' }}</span>
        <ul class="list-select">
            @for($i=2010;$i<=2020;$i++)
                <li class="{{ $name }}" rel="{{ $i }}" data-value="{{ $i }}">{{ $i }}</li>
            @endfor
        </ul>
    </div>
</div>
@include('nqadmin-users::frontend.components.info.status',['name'=>$name])