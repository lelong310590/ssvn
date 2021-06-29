<div class="right col-xs-2 hidden">
    <?php $options = config('meta.status'); ?>
    <div class="box-select">
        <input type="hidden" name="{{ $name }}[]" value="{{ $key=$meta_value?$meta_value->status:array_keys(config('meta.status'))[0] }}" class="{{ $name }}_value">
        <span class="txt-find input-form {{ $name }}_show">{{ $options[$key] }}</span>
        <ul class="list-select">
            @foreach(config('meta.status') as $key=>$value)
                <li class="{{ $name }}" rel="{{ $value }}" data-value="{{ $key }}">{{ $value }}</li>
            @endforeach
        </ul>
    </div>
</div>