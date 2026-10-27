
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-between items-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="btn btn-disabled">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-primary">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-primary">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="btn btn-disabled">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
