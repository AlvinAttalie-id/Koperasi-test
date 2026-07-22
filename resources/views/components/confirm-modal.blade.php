@props([
    'name',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to perform this action?',
    'confirmLabel' => 'Confirm',
    'variant' => 'danger',
    'method' => 'POST'
])

<div
    x-data="{ open: false, actionUrl: '' }"
    data-loading-modal
    x-show="open"
    @open-modal-{{ $name }}.window="open = true; actionUrl = $event.detail.actionUrl || ''"
    @close-modal-{{ $name }}.window="open = false"
    @keydown.escape.window="if (!$el.dataset.loading) open = false"
    x-effect="document.body.style.overflow = open ? 'hidden' : ''"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <!-- Backdrop with blur -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        @click="!$root.dataset.loading && (open = false)"
    ></div>

    <!-- Modal Content Panel -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-96 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-96 translate-y-2"
        class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] z-10 overflow-hidden"
    >
        @if($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">{{ $title }}</h2>
                <button
                    type="button"
                    @click="!$root.dataset.loading && (open = false)"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="flex-1 overflow-y-auto px-6 py-4">
            <p class="text-sm text-gray-600">{{ $message }}</p>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 bg-gray-50/50">
            <button
                type="button"
                @click="!$root.dataset.loading && (open = false)"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
                Cancel
            </button>
            <form :action="actionUrl" method="POST" class="inline">
                @csrf
                @method($method)
                <x-loading-button
                    :loading-text="$confirmLabel === 'Delete' ? 'Deleting...' : 'Saving...'"
                    :variant="$variant === 'danger' ? 'danger' : 'primary'"
                    class="px-4 py-2 text-sm font-medium rounded-lg"
                >
                    {{ $confirmLabel }}
                </x-loading-button>
            </form>
        </div>
    </div>
</div>
