@php
    $icons = [
        '<i class="far fa-keyboard"></i>', '<i class="far fa-language"></i>', '<i class="far fa-graduation-cap"></i>',
        '<i class="fas fa-briefcase"></i>', '<i class="fas fa-cogs"></i>', '<i class="fas fa-users"></i>'
    ]
@endphp
<!--box-student-level-->
<div class="vj-level">
    <div class="container">
        <h4>Theo trình độ</h4>
        <ul>
            @foreach($level as $l)
                <li>
                    <a href="{{ route('front.level.list.get',['slug'=>$l->slug]) }}">
                        @if (isset($icons[$loop->index]))
                            <span class="lv-icon">{!! $icons[$loop->index] !!}</span>
                        @else
                            <span class="lv-icon"><i class="far fa-keyboard"></i></span>
                        @endif
                        <span class="lv-txt">{{ $l->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!--level-->