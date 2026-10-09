@if($paginator->hasPages())
    <nav class="pagination-controls" role="navigation" aria-label="Navigasi halaman">
        @if($paginator->onFirstPage())
            <span aria-disabled="true">&larr; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Sebelumnya</a>
        @endif

        <span class="pagination-current">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &rarr;</a>
        @else
            <span aria-disabled="true">Berikutnya &rarr;</span>
        @endif
    </nav>
@endif