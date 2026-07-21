@props([
    'label' => null,
    'error' => null,
    'hint' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'text',
    'name' => '',
    'value' => null,
    'required' => false,
    'class' => ''
])

@php
    $hasError = $errors->has($name) || $error;
    $errorMessage = $error ?? $errors->first($name);
    $inputValue = old($name, $value);
    $isPassword = $type === 'password';
@endphp

<div class="flex flex-col gap-1.5 w-full" @if($isPassword) x-data="{ showPassword: false }" @endif>
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif
    <div class="relative">
        @if($icon && $iconPosition === 'left')
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                {{ $icon }}
            </div>
        @endif
        
        <input
            @if($isPassword)
                :type="showPassword ? 'text' : 'password'"
            @else
                type="{{ $type }}"
            @endif
            name="{{ $name }}"
            value="{{ $inputValue }}"
            {{ $attributes->merge([
                'class' => "w-full h-10 bg-white border rounded-lg text-sm text-gray-900 placeholder-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed " .
                ($hasError ? 'border-red-400 focus:ring-red-500/30 focus:border-red-500 ' : 'border-gray-200 hover:border-gray-300 ') .
                ($icon && $iconPosition === 'left' ? 'pl-9 ' : 'pl-3 ') .
                ($isPassword || ($icon && $iconPosition === 'right') ? 'pr-10 ' : 'pr-3 ') .
                $class
            ]) }}
        />

        @if($isPassword)
            <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <!-- Eye icon -->
                <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <!-- Eye-slash icon -->
                <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.815 7.815 3 3m-3-3a10.479 10.479 0 0 1-4.148 1.48M12 9.75c-1.242 0-2.25 1.008-2.25 2.25 0 .235.036.46.104.672M12 9.75a2.25 2.25 0 0 1 2.246 2.246M12 9.75v3.75m0-3.75h3.75" />
                </svg>
            </button>
        @elseif($icon && $iconPosition === 'right')
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                {{ $icon }}
            </div>
        @endif
    </div>
    @if($hasError)
        <p class="text-xs text-red-500">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
