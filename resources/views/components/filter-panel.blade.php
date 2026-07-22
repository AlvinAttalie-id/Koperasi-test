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

<div x-data="{
    isOpen: false,
    panelStyle: '',
    positionPanel() {
        if (window.innerWidth < 640) {
            this.panelStyle = '';
            return;
        }

        const trigger = this.$refs.trigger.getBoundingClientRect();
        const panel = this.$refs.panel;
        const gutter = 16;
        const width = Math.min(360, window.innerWidth - (gutter * 2));
        const left = Math.max(gutter, Math.min(trigger.left, window.innerWidth - width - gutter));
        let top = trigger.bottom + 12;
        const panelHeight = panel.offsetHeight || 400;

        if (top + panelHeight > window.innerHeight - gutter && trigger.top - panelHeight - 12 >= gutter) {
            top = trigger.top - panelHeight - 12;
        }

        this.panelStyle = `position: fixed; left: ${left}px; top: ${Math.max(gutter, top)}px; width: ${width}px;`;
    }
}" 
x-init="window.addEventListener('popstate', () => { isOpen = false }); window.addEventListener('resize', () => { if (isOpen) positionPanel() })"
@keydown.escape.window="isOpen = false"
{{ $attributes->merge(['class' => "relative w-full sm:w-auto {$class}"]) }}>
    <button
        x-ref="trigger"
        type="button"
        @click="isOpen = !isOpen; if (isOpen) $nextTick(() => positionPanel())"
        class="flex w-full sm:w-auto items-center justify-center gap-2 h-10 px-3 sm:px-4 text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors whitespace-nowrap"
    >
        <!-- Filter Icon -->
        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
        </svg>
        <span class="truncate">Filters</span>
        @if($activeFiltersCount > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-green-600 rounded-full select-none shrink-0">
                {{ $activeFiltersCount }}
            </span>
        @endif
        
        <!-- Chevron Up/Down Icons -->
        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" :class="isOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <!-- Filter Dropdown/Panel -->
    <div x-cloak x-show="isOpen"
         x-ref="panel"
         :style="panelStyle"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.outside="isOpen = false"
         class="filter-panel absolute left-0 top-full mt-3 w-full sm:mt-0 bg-white border border-gray-200 rounded-xl shadow-lg p-4 sm:p-5 space-y-4 z-50 max-h-[calc(100vh-2rem)] overflow-y-auto">
        <form action="{{ $action }}" method="GET" class="filter-panel-content space-y-4 w-full min-w-0">
            <!-- Maintain active search and sorting state when applying filters -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="space-y-4">
                {{ $slot }}
            </div>
            
            <div class="flex gap-3 pt-3 border-t border-gray-50 sm:justify-end">
                <a
                    href="{{ strtok(request()->fullUrl(), '?') . (request('search') ? '?search=' . urlencode(request('search')) : '') }}"
                    class="h-10 flex-1 sm:flex-none sm:w-auto px-4 flex items-center justify-center text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors select-none"
                >
                    Reset
                </a>
                <button
                    type="submit"
                    class="h-10 flex-1 sm:flex-none sm:w-auto px-5 flex items-center justify-center text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors select-none"
                >
                    Apply
                </button>
            </div>
        </form>
    </div>
</div>
