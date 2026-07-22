@props([
    'loading' => false,
    'disabled' => false,
    'loadingText' => 'Loading...',
    'variant' => 'primary',
    'type' => 'submit',
    'class' => '',
])

@php
    $variants = [
        'primary' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'secondary' => 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<button
    type="{{ $type }}"
    data-loading-button
    data-loading-text="{{ $loadingText }}"
    @disabled($disabled || $loading)
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center gap-2 transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-70 {$variantClass} {$class}"]) }}
>
    @if($loading)
        <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"/><path class="opacity-90" fill="currentColor" d="M12 3a9 9 0 0 0-9 9h3a6 6 0 0 1 6-6V3Z"/></svg>
        <span>{{ $loadingText }}</span>
    @else
        {{ $slot }}
    @endif
</button>
