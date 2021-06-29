<span class="txt pull-left">Sắp xếp theo</span>
<div class="pull-left dropdown-single">
    <input type="hidden" name="q" value="{{ request('q') }}">
    <input type="hidden" name="filter" value="{{ request('filter') }}">
    <input type="hidden" name="key" value="{{ request('key') }}" id="search-key">
    <input type="hidden" name="order" value="{{ request('order') }}" id="search-order">
    <span class="show-txt">
        @if(config('lfm.order.'.request('key').'.'.request('order'))!='')
            {{ config('lfm.order.'.request('key').'.'.request('order')) }}
        @else
            {{ config('lfm.order.created_at.desc') }}
        @endif
        <i class="fas fa-chevron-down pull-right"></i>
    </span>
    <ul class="form-dropdown">
        @foreach(config('lfm.order') as $key=>$value)
            @foreach($value as $k=>$v)
                <li><a href="#" onclick="return changeOrder('{!! $key !!}','{!! $k !!}','{!! $v !!}')">{{ $v }}</a></li>
            @endforeach
        @endforeach
    </ul>
</div>
@push('js')
    <script>
        function changeOrder(key, order, text) {
            $('#search-key').val(key);
            $('#search-order').val(order);
            $('.show-txt').html(text + ' <i class="fas fa-chevron-down pull-right"></i>');
            $("#filter_form").submit();
        }
    </script>
@endpush