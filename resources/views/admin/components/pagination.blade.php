<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
    @unless($paginator->onFirstPage())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                <i class="fas fa-angle-left"></i>
            </a>
        </li>
    @endunless
    @for ($i = 1; $i <= $paginator->lastPage(); $i++) 
        <li class="page-item @if ($paginator->currentPage() == $i) active @endif">
            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    @unless($paginator->currentPage() == $paginator->lastPage())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                <i class="fas fa-angle-right"></i>
            </a>
        </li>
    @endunless
  </ul>
</nav>