<div class="price">
    @if($item->price==0)
        <span class="news">Miễn phí</span>
    @else
        <span class="news">{{ number_format($item->price) }} VNĐ</span>
    @endif
    @if($item->checkSaleAvailable())
        <span class="old">{{ number_format($item->getOriginal('price')) }} VNĐ</span>
    @endif
</div>