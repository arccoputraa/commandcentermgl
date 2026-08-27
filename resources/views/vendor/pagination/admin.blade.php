@if ($paginator->hasPages())
    <div class="table-footer" style="display:flex; justify-content:space-between; align-items:center;">
        <span>Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data</span>
        <div class="pagination" style="display:flex; gap:8px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#a0aec0; cursor:not-allowed;">&laquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#2563eb; text-decoration:none;">&laquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#a0aec0;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding:6px 12px; border:1px solid #2563eb; background-color:#2563eb; border-radius:8px; color:#fff;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#2563eb; text-decoration:none;">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#2563eb; text-decoration:none;">&raquo;</a>
            @else
                <span style="padding:6px 12px; border:1px solid #dbe3ee; border-radius:8px; color:#a0aec0; cursor:not-allowed;">&raquo;</span>
            @endif
        </div>
    </div>
@else
    <div class="table-footer">
        <span>Menampilkan {{ $paginator->count() }} data</span>
    </div>
@endif
