@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-3 py-4">
    <p class="text-sm text-gray-500">
        Menampilkan <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
        sampai <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
        dari <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span> siswa
    </p>

    <div class="inline-flex items-center rounded-full bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border-r border-gray-200 cursor-not-allowed">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border-r border-gray-200 hover:bg-brand-50 hover:text-brand-700 transition-colors">
                ‹
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-500 bg-white">
                    {{ $element }}
                </span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-brand-600">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 bg-white hover:bg-brand-50 hover:text-brand-700 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border-l border-gray-200 hover:bg-brand-50 hover:text-brand-700 transition-colors">
                ›
            </a>
        @else
            <span class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border-l border-gray-200 cursor-not-allowed">
                ›
            </span>
        @endif
    </div>
</nav>
@endif
