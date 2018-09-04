@if ($paginator->lastPage() > 1)
    <ul class="pagination gallery-pagination">
        @if ($paginator->currentPage() != 1)
        <li>
            <a href="{{ $paginator->previousPageUrl() }}">
                &lsaquo;
            </a>
        </li>
        @endif
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
                $totalLink = 10;
                $halfTotalLink = floor($totalLink / 2);
                $from = $paginator->currentPage() - $halfTotalLink;
                $to = $paginator->currentPage() + $halfTotalLink;
                if ($paginator->currentPage() < $halfTotalLink) {
                   $to += $halfTotalLink - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $halfTotalLink) {
                    $from -= $halfTotalLink - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
            ?>
            @if ($from < $i && $i < $to)
                <li>
                    <a href="{{ $paginator->url($i) }}" class="{{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
                        <span>{{ $i }}</span>
                    </a>
                </li>
            @endif
        @endfor
        @if ($paginator->currentPage() != $paginator->lastPage())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}">
                &rsaquo;
            </a>
        </li>
        @endif
    </ul>
@endif
