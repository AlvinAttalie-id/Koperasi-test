@props([
    'headers' => [],
    'class' => ''
])

<div {{ $attributes->merge(['class' => "overflow-x-auto -mx-6 px-6 {$class}"]) }}>
    <table class="w-full min-w-full">
        <thead>
            <tr class="border-b border-gray-100">
                @foreach($headers as $key => $header)
                    @php
                        $isSortable = is_array($header) && ($header['sortable'] ?? false);
                        $label = is_array($header) ? ($header['label'] ?? '') : $header;
                        $colClass = is_array($header) ? ($header['class'] ?? '') : '';
                        $colKey = is_array($header) ? ($header['key'] ?? $key) : (is_numeric($key) ? $header : $key);
                        
                        // Check active sorting from request
                        $sortBy = request('sort_by');
                        $sortDir = request('sort_dir', 'asc');
                        $isActive = $sortBy === $colKey;
                        $nextDir = $isActive && $sortDir === 'asc' ? 'desc' : 'asc';
                    @endphp
                    <th class="py-3 px-3 first:pl-0 last:pr-0 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide whitespace-nowrap {{ $colClass }}">
                        @if($isSortable)
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => $colKey, 'sort_dir' => $nextDir]) }}" class="flex items-center gap-1 hover:text-gray-800 transition-colors group">
                                {{ $label }}
                                <span class="text-gray-300 group-hover:text-gray-500">
                                    @if($isActive)
                                        @if($sortDir === 'asc')
                                            <!-- Up Arrow -->
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" /></svg>
                                        @else
                                            <!-- Down Arrow -->
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                        @endif
                                    @else
                                        <!-- Sortable Indicators -->
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" /></svg>
                                    @endif
                                </span>
                            </a>
                        @else
                            {{ $label }}
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            {{ $slot }}
        </tbody>
    </table>
</div>
