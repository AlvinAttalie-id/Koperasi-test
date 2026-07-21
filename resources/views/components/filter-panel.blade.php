@props([
    'action' => '',
    'class' => ''
])

<div x-data="{ isOpen: false }" {{ $attributes->merge(['class' => "bg-white border border-gray-200 rounded-xl p-4 shadow-sm space-y-4 {$class}"]) }}>
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
        </div>
        
        <!-- Chevron Up/Down Icons -->
        <svg class="w-4 h-4 text-gray-400" :class="isOpen ? 'hidden' : 'block'" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
        <svg class="w-4 h-4 text-gray-400" :class="isOpen ? 'block' : 'hidden'" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    <form action="{{ $action }}" method="GET" x-show="isOpen" x-transition.origin.top.duration.200ms class="pt-2 space-y-4 border-t border-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{ $slot }}
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <a
                href="{{ strtok(request()->fullUrl(), '?') }}"
                class="h-9 px-4 flex items-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
                Reset Filters
            </a>
            <button
                type="submit"
                class="h-9 px-4 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors"
            >
                Apply Filters
            </button>
        </div>
    </form>
</div>
