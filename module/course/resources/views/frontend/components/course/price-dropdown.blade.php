@if($item->price==0)
    <p class="news pull-left">Miễn phí</p>
@else
    <p class="news pull-left">{{ number_format($item->price) }} VNĐ</p>
@endif
@if($item->checkSaleAvailable())
    <p class="old pull-left">{{ number_format($item->getOriginal('price')) }} VNĐ</p>
@endif