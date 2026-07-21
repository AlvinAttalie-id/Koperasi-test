@props([
    'label' => null,
    'error' => null,
    'hint' => null,
    'name' => '',
    'value' => null,
    'required' => false,
    'rows' => 4,
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
    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => "w-full bg-white border rounded-lg text-sm text-gray-900 placeholder-gray-400 p-3 transition-colors resize-none focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed " .
            ($hasError ? 'border-red-400 focus:ring-red-500/30 focus:border-red-500 ' : 'border-gray-200 hover:border-gray-300 ') .
            $class
        ]) }}
    >{{ $inputValue }}</textarea>
    @if($hasError)
        <p class="text-xs text-red-500">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
