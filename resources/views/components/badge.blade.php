@props([
    'variant' => 'default',
    'size' => 'md',
    'dot' => false,
    'class' => ''
])

@php
    $variants = [
        'default' => 'bg-gray-100 text-gray-800 border-gray-200',
        'success' => 'bg-green-50 text-green-700 border-green-200',
        'danger' => 'bg-red-50 text-red-700 border-red-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'info' => 'bg-blue-50 text-blue-700 border-blue-200',
    ];

    $dotColors = [
        'default' => 'bg-gray-400',
        'success' => 'bg-green-500',
        'danger' => 'bg-red-500',
        'warning' => 'bg-amber-500',
        'info' => 'bg-blue-500',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
    $dotClass = $dotColors[$variant] ?? $dotColors['default'];
    $sizeClass = $size === 'sm' ? 'px-2 py-0.5 text-[10px]' : 'px-2.5 py-1 text-xs';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border font-medium select-none {$sizeClass} {$variantClass} {$class}"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $dotClass }}"></span>
    @endif
    {{ $slot }}
</span>
