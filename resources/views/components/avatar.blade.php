@props([
    'name' => 'User',
    'size' => 'md',
    'class' => ''
])

@php
    $colors = [
        'bg-red-100 text-red-700',
        'bg-blue-100 text-blue-700',
        'bg-green-100 text-green-700',
        'bg-purple-100 text-purple-700',
        'bg-amber-100 text-amber-700',
        'bg-pink-100 text-pink-700',
    ];

    $sizes = [
        'xs' => 'w-6 h-6 text-[10px]',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm font-medium',
        'lg' => 'w-12 h-12 text-base font-semibold',
    ];

    // Compute initials
    $name = trim($name);
    $parts = preg_split('/\s+/', $name);
    if (empty($parts) || $name === '') {
        $initials = '?';
    } elseif (count($parts) === 1) {
        $initials = strtoupper(substr($parts[0], 0, 2));
    } else {
        $initials = strtoupper($parts[0][0] . $parts[1][0]);
    }

    // Deterministic hash based on name
    $index = abs(crc32($name)) % count($colors);
    $colorClass = $colors[$index];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-full flex items-center justify-center font-bold shrink-0 select-none {$sizeClass} {$colorClass} {$class}"]) }}>
    {{ $initials }}
</div>
