<div class="pull-left money price text-right">
    @if($item->price==0)
        <p class="news">Miễn phí</p>
    @else
        <p class="news">{{ number_format($item->price) }} <span>VNĐ</span></p>
    @endif
    @if($item->checkSaleAvailable())
        <p class="old">{{ number_format($item->getOriginal('price')) }} VNĐ</p>
    @endif
</div>