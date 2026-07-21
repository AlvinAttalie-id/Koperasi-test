@props([
    'name' => 'search',
    'placeholder' => 'Search...',
    'value' => null,
    'class' => ''
])

@php
    $currentValue = request($name, $value);
@endphp

<div x-data="{ q: '{{ $currentValue }}' }" class="relative {{ $class }}">
    <!-- Search Icon -->
    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
    </svg>
    <input
        type="text"
        name="{{ $name }}"
        x-model="q"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => "w-full h-10 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 pl-9 pr-9 focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 hover:border-gray-300 transition-colors"
        ]) }}
    />
    <!-- Clear button -->
    <button
        type="button"
        x-show="q.length > 0"
        @click="q = ''; $nextTick(() => { $el.closest('form')?.submit() || (window.location.href = window.location.pathname) })"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
        style="display: none;"
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</div>
