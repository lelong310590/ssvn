<div class="pull-left">
    @include('nqadmin-course::frontend.components.course.only_star',['item'=>$item->getAverageRating()])
</div>
@if(!isset($small_star))
    <div class="overflow">
        <p>{{ $item->getAverageRating() }} <span>({{ number_format($item->getRating->count()) }})</span></p>
    </div>
@endif