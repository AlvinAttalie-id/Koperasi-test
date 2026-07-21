@props([
    'type' => 'table',
    'rows' => 5,
    'cols' => 5
])

@if ($type === 'cards')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @for ($i = 0; $i < 4; $i++)
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-4 animate-pulse">
                <div class="flex items-center justify-between">
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                    <div class="w-10 h-10 bg-gray-200 rounded-xl"></div>
                </div>
                <div class="h-8 bg-gray-200 rounded w-32"></div>
                <div class="h-3 bg-gray-200 rounded w-20"></div>
            </div>
        @endfor
    </div>
@elseif ($type === 'page')
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-4 animate-pulse">
                    <div class="flex items-center justify-between">
                        <div class="h-4 bg-gray-200 rounded w-24"></div>
                        <div class="w-10 h-10 bg-gray-200 rounded-xl"></div>
                    </div>
                    <div class="h-8 bg-gray-200 rounded w-32"></div>
                    <div class="h-3 bg-gray-200 rounded w-20"></div>
                </div>
            @endfor
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-3 animate-pulse">
            <div class="h-5 bg-gray-200 rounded w-40 mb-6"></div>
            @for ($i = 0; $i < $rows; $i++)
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 bg-gray-200 rounded-full shrink-0"></div>
                    <div class="h-4 bg-gray-200 rounded flex-1"></div>
                    @for ($j = 0; $j < $cols - 2; $j++)
                        <div class="h-4 bg-gray-200 rounded w-24"></div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>
@else
    <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-3 animate-pulse">
        @for ($i = 0; $i < $rows; $i++)
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 bg-gray-200 rounded-full shrink-0"></div>
                <div class="h-4 bg-gray-200 rounded flex-1"></div>
                @for ($j = 0; $j < $cols - 2; $j++)
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                @endfor
            </div>
        @endfor
    </div>
@endif
