@if ($paginator->hasPages())
    <nav style="display:flex; align-items:center; justify-content:center; gap:8px;">
        @if ($paginator->onFirstPage())
            <span class="btn btn-sm" style="opacity:.35; pointer-events:none;">Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm">Sebelumnya</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="btn btn-sm" style="opacity:.5; pointer-events:none;">…</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-sm btn-dark">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn btn-sm">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm">Berikutnya</a>
        @else
            <span class="btn btn-sm" style="opacity:.35; pointer-events:none;">Berikutnya</span>
        @endif
    </nav>
@endif