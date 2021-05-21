<nav class="{{ $class ?? '' }}">
  <ul class="pagination justify-content-end">
    @unless($paginator->onFirstPage())
        <li class="page-item">
            <a class="page-link text-dark" href="{{ $paginator->previousPageUrl() }}">
                <i class="fas fa-angle-left"></i>
            </a>
        </li>
    @endunless
    @for ($i = 1; $i <= $paginator->lastPage(); $i++) 
        <li class="page-item f">
            <a class="page-link @if ($paginator->currentPage() == $i) bg-dark text-warning font-weight-bold @else text-dark @endif" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    @unless($paginator->currentPage() == $paginator->lastPage())
        <li class="page-item">
            <a class="page-link text-dark" href="{{ $paginator->nextPageUrl() }}">
                <i class="fas fa-angle-right"></i>
            </a>
        </li>
    @endunless
  </ul>
</nav>