@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-1 rounded-md border border-gray-300 bg-white shadow-sm px-1 py-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-2 text-sm text-gray-400 cursor-not-allowed select-none">
                    ‹
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-600 rounded transition">
                        ‹
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="px-3 py-2 text-sm text-gray-400 select-none">
                        {{ $element }}
                    </li>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-2 text-sm font-bold text-white bg-blue-600 rounded">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-600 rounded transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-600 rounded transition">
                        ›
                    </a>
                </li>
            @else
                <li class="px-3 py-2 text-sm text-gray-400 cursor-not-allowed select-none">
                    ›
                </li>
            @endif
        </ul>
    </nav>
@endif
