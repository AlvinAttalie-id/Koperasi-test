@props([
    'title' => 'No results found',
    'description' => 'Try adjusting your search or filters to find what you are looking for.',
    'class' => ''
])

<div {{ $attributes->merge(['class' => "flex flex-col items-center justify-center text-center py-12 px-4 {$class}"]) }}>
    <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 mb-4">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
        </svg>
    </div>
    <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $title }}</h3>
    <p class="text-xs text-gray-400 max-w-xs">{{ $description }}</p>
</div>
