<div class="form-dropdown">
    <ul>
        @foreach($course as $c)
        <li>
            <i class="fas fa-search pull-left"></i>
            <a href="{{ route('front.course.buy.get',['slug'=>$c->slug]) }}" class="overflow">
            <?php
            echo str_replace($q,"<span>".$q."</span>",$c->name);
                ?>
            </a>
        </li>
        @endforeach
    </ul>
</div>