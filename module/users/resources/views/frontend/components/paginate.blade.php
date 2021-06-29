@if ($paginator->hasPages())
    <div class="box-paging">
        <div class="clearfix">
            <div class="pull-right">
                <span class="txt pull-left">Trang</span>
                <ul class="overflow">
                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="pull-left"><a href="javascript:void(0)" class="active">{{ $page }}</a></li>
                                @else
                                    <li class="pull-left"><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif