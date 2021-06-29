<a href="javascript:void(0)" id="thong-bao-notification">
    <span class="icon-title">
        <i class="far fa-bell"></i>
        <?php $new_notifi = Auth::user()->getAdvertise()->where('advertise.status', 'active')->count() ?>
        @if($new_notifi)
            <span class="shopping-count badge" id="thong-bao-notification-count">{{ $new_notifi }}</span>
        @endif
    </span>
</a>
<div class="box-dropdown">
    <div class="form-dropdown form-dropdown-top-center form-notification form-default">
        <div class="box-info-1">
            @foreach(Auth::user()->getAdvertise()->orderBy('id','desc')->limit($new_notifi+5)->get() as $item)
                @include('nqadmin-dashboard::frontend.components.header.dropdown.notification.item')
            @endforeach
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#thong-bao-notification').mouseover(function () {
            var content = parseInt($(this).find('.shopping-count').html());
            if (content > 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ route("front.advertise.update.post") }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //console.log(xhr.responseText)
                    },
                    success: function (data) {
                        $('#thong-bao-notification-count').addClass('hidden');
                        $('#thong-bao-notification-count').html('0');
                    }
                });
            }
        });
    </script>
@endpush