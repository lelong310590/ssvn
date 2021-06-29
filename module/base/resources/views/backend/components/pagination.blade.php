<?php $link_limit = 7; ?>
@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <li class="{{ ($paginator->currentPage() == 1) ? 'page-item disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">Quay lại</a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="{{ ($paginator->currentPage() == $i) ? 'page-item active' : '' }}">
                    <a  class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'page-item disabled' : '' }}">
            <a  class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Trang kế</a>
        </li>
    </ul>
@endif