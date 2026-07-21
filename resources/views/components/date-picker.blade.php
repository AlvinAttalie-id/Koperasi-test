@props([
    'label' => null,
    'error' => null,
    'hint' => null,
    'name' => '',
    'value' => null,
    'required' => false,
    'class' => ''
])

@php
    $hasError = $errors->has($name) || $error;
    $errorMessage = $error ?? $errors->first($name);
    $inputValue = old($name, $value);
@endphp

<div class="flex flex-col gap-1.5 w-full">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif
    <div class="relative">
        <!-- Calendar SVG Icon -->
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none z-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
        </svg>
        <input
            type="date"
            name="{{ $name }}"
            value="{{ $inputValue }}"
            {{ $attributes->merge([
                'class' => "w-full h-10 bg-white border rounded-lg text-sm text-gray-900 pl-9 pr-3 cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed " .
                ($hasError ? 'border-red-400 focus:ring-red-500/30 focus:border-red-500 ' : 'border-gray-200 hover:border-gray-300 ') .
                $class
            ]) }}
        />
    </div>
    @if($hasError)
        <p class="text-xs text-red-500">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
