@props([
    'action' => '',
    'class' => ''
])

@php
    // Calculate active filters count (excluding pagination, sorting, and search)
    $activeFiltersCount = collect(request()->except(['page', 'sort_by', 'sort_dir', 'search']))
        ->filter(fn($val, $key) => !is_null($val) && $val !== '' && !($key === 'sort' && $val === 'newest'))
        ->count();
@endphp

<div x-data="{ isOpen: false }" {{ $attributes->merge(['class' => "bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4 {$class}"]) }}>
    <button
        type="button"
        @click="isOpen = !isOpen"
        class="w-full flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors"
    >
        <div class="flex items-center gap-2">
            <!-- Filter Icon -->
            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
            </svg>
            <span>Filters</span>
            @if($activeFiltersCount > 0)
                <span class="inline-flex items-center justify-center w-5 h-5 ml-1 text-[10px] font-bold text-white bg-green-600 rounded-full select-none">
                    {{ $activeFiltersCount }}
                </span>
            @endif
        </div>
        
        <!-- Chevron Up/Down Icons -->
        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="isOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <form action="{{ $action }}" method="GET" x-show="isOpen" x-transition.origin.top.duration.200ms class="pt-4 space-y-5 border-t border-gray-100">
        <!-- Maintain active search and sorting state when applying filters -->
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{ $slot }}
        </div>
        
        <div class="flex justify-end gap-3 pt-3 border-t border-gray-50">
            <a
                href="{{ strtok(request()->fullUrl(), '?') . (request('search') ? '?search=' . urlencode(request('search')) : '') }}"
                class="h-10 px-4 flex items-center justify-center text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors select-none"
            >
                Reset Filters
            </a>
            <button
                type="submit"
                class="h-10 px-5 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors select-none"
            >
                Apply Filters
            </button>
        </div>
    </form>
</div>
