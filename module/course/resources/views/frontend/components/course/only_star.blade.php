<ul class="clearfix">
    @for($i=1; $i <= 5; $i++)
        @if($i<=$item)
            <li class="pull-left"><i class="fas fa-star"></i></li>
        @endif
        @if($i>$item)
            @if($i-$item==0.5)
                <li class="pull-left"><i class="fas fa-star-half"></i></li>
            @else
                <li class="pull-left"><i class="far fa-star"></i></li>
            @endif
        @endif
    @endfor
</ul>