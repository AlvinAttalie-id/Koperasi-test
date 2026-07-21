@props([
    'show' => false,
])

<div id="loading-overlay" class="opacity-0 pointer-events-none">
    <div class="flex flex-col items-center gap-4">
        <div class="loading-spinner"></div>
        <p class="text-sm text-gray-600 font-medium">Loading...</p>
    </div>
</div>
