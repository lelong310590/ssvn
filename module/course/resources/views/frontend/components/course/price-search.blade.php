<p class="price pull-left">
    @if($item->price==0)
        <span>Miễn phí</span>
    @else
        <span>{{ number_format($item->price) }} </span>VNĐ
    @endif
</p>
@if($item->checkSaleAvailable())
    <p class="price old pull-left">{{ number_format($item->getOriginal('price')) }} VNĐ</p>
@endif