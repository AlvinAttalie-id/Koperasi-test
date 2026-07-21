@props([
    'title',
    'value',
    'trend' => null,
    'trendLabel' => 'vs last month',
    'iconColor' => 'text-green-600',
    'iconBg' => 'bg-green-50',
    'class' => ''
])

<div {{ $attributes->merge(['class' => "bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex items-center justify-between gap-4 {$class}"]) }}>
    <div class="space-y-2">
        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $title }}</span>
        <div class="flex items-baseline gap-2">
            <span class="text-2xl font-bold text-gray-900 leading-none">{{ $value }}</span>
            @if($trend !== null && $trend !== 0)
                <span class="text-xs font-semibold {{ $trend > 0 ? 'text-green-600' : 'text-red-500' }}">
                    {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                </span>
            @endif
        </div>
        @if($trendLabel)
            <p class="text-[10px] text-gray-400">
                {{ $trendLabel }}
            </p>
        @endif
    </div>
    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ $iconBg }}">
        @if(isset($icon))
            {{ $icon }}
        @endif
    </div>
</div>
