@props([
    'label' => null,
    'error' => null,
    'hint' => null,
    'name' => '',
    'options' => [],
    'placeholder' => 'Select an option',
    'value' => null,
    'required' => false,
    'class' => ''
])

@php
    $hasError = $errors->has($name) || $error;
    $errorMessage = $error ?? $errors->first($name);
    $selectedValue = old($name, $value);
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
        <select
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => "w-full h-10 bg-white border rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed " .
                ($hasError ? 'border-red-400 focus:ring-red-500/30 focus:border-red-500 ' : 'border-gray-200 hover:border-gray-300 ') .
                ($selectedValue === null || $selectedValue === '' ? 'text-gray-400 ' : 'text-gray-900 ') .
                $class
            ]) }}
        >
            <option value="" @selected($selectedValue === null || $selectedValue === '')>{{ $placeholder }}</option>
            @foreach($options as $opt)
                @php
                    $val = is_array($opt) ? ($opt['value'] ?? '') : (is_object($opt) ? ($opt->value ?? $opt->id ?? '') : $opt);
                    $lbl = is_array($opt) ? ($opt['label'] ?? '') : (is_object($opt) ? ($opt->label ?? $opt->name ?? '') : $opt);
                    $isDisabled = is_array($opt) ? ($opt['disabled'] ?? false) : false;
                @endphp
                <option value="{{ $val }}" @selected($selectedValue == $val) @disabled($isDisabled)>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>
        <!-- Chevron Down -->
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    @if($hasError)
        <p class="text-xs text-red-500">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
