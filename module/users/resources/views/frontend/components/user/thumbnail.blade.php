@if (!empty($user->thumbnail))
    <img src="{{ asset($user->thumbnail) }}" alt="" width="" height="">
@else
    <div class="img-user-by-name">{{substr($user->first_name, 0, 1)}}</div>
@endif