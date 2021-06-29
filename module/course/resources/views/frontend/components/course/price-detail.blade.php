<div class="money price">
    @if(!empty(request('couponCode')) && !empty($item->checkCoupon(request('couponCode'))))
        <?php
            $coupon = $item->checkCoupon(request('couponCode'));
        ?>
        @if($item->getOriginal('price')-$coupon->price==0)
            {{--<span class="news">Miễn phí</span>--}}
        @else
            <span class="news">{{ number_format($item->getOriginal('price')-$coupon->price) }} VNĐ</span>
        @endif
        <span class="old">{{ number_format($item->getOriginal('price')) }} VNĐ</span>
        <span class="sale text-right">
            @if($item->getOriginal('price')-$coupon->price>0)
                Giảm {{ number_format(($coupon->price)/$item->getOriginal('price')*100,0) }}%
            @else
                Giảm 100%
            @endif
        </span>
    @else
        @if($item->price==0)
            {{--<span class="news">Miễn phí</span>--}}
        @else
            <span class="news">{{ number_format($item->price) }} VNĐ</span>
        @endif
        @if($item->checkSaleAvailable())
            <span class="old">{{ number_format($item->getOriginal('price')) }} VNĐ</span>
            <span class="sale text-right">
                @if($item->getOriginal('price')>0)
                    Giảm {{ number_format(($item->getOriginal('price')-$item->price)/$item->getOriginal('price')*100,0) }}%
                @else
                    Giảm 100%
                @endif
            </span>
            <?php
            $sale_course = app('sale_system')->where('min_price', '<=', $item->getOriginal('price'))->where('max_price', '>=', $item->getOriginal('price'))->first();
            ?>
            <p><span>{{ humanTiming(strtotime($sale_course->end_time)) }}</span> còn lại ở mức giá này!</p>
        @endif
    @endif
</div>