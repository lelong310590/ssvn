@if($item->checkSaleAvailable())
    <div class="pull-left">
        <p class="price old">{{ number_format($item->getOriginal('price')) }} VNĐ</p>
    </div>
@endif
<div class="pull-right">
    <p class="price text-right">
        @if($item->price==0)
            <span>Miễn phí</span>
        @else
            <span>{{ number_format($item->price) }} </span>VNĐ
        @endif
    </p>
</div>