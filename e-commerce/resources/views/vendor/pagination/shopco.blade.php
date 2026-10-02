@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-10 space-x-2 text-sm font-medium select-none" role="navigation">
        
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">← Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-1 border border-gray-300 text-gray-800 rounded hover:bg-gray-100">← Previous</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-black text-white border border-black rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border border-gray-300 text-gray-800 rounded hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-1 border border-gray-300 text-gray-800 rounded hover:bg-gray-100">Next →</a>
        @else
            <span class="px-4 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">Next →</span>
        @endif

    </nav>
@endif
