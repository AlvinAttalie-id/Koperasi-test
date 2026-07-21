@props([
    'title' => null,
    'subtitle' => null,
    'class' => ''
])

<div {{ $attributes->merge(['class' => "bg-white border border-gray-200 rounded-xl p-6 shadow-sm {$class}"]) }}>
    @if($title || isset($action))
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                @if($title)
                    <h3 class="text-base font-semibold text-gray-900 leading-none">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-xs text-gray-400 mt-1.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if(isset($action))
                <div class="shrink-0">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
