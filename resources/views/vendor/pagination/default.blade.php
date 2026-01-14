@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2.5 text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2.5 text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-primary-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2.5 text-gray-700 bg-white border-2 border-gray-200 rounded-xl font-semibold">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-5 py-2.5 text-white bg-primary-600 rounded-xl font-bold shadow-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-5 py-2.5 text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-primary-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 font-semibold">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2.5 text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-primary-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <span class="px-4 py-2.5 text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </span>
        @endif
    </nav>
@endif
