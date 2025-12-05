@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="px-4 py-3 sm:px-0">

    {{-- Mobile Version --}}
    <div class="flex items-center justify-between sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
            ← Previous
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
            ← Previous
        </a>
        @endif

        <span class="text-sm text-gray-600">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
            Next →
        </a>
        @else
        <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
            Next →
        </span>
        @endif
    </div>

    {{-- Desktop Version --}}
    <div class="hidden sm:flex sm:items-center sm:justify-between">

        {{-- Results Info --}}
        <div>
            <p class="text-sm text-gray-600">
                Showing
                <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        {{-- Pagination Buttons --}}
        <div class="flex items-center gap-1">

            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
            {{-- Three Dots Separator --}}
            @if (is_string($element))
            <span class="px-4 py-2 text-sm font-medium text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <span class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg">
                {{ $page }}
            </span>
            @else
            <a href="{{ $url }}"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"
                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                {{ $page }}
            </a>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            @else
            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            @endif

        </div>
    </div>
</nav>
@endif