<div x-data="{
    toasts: [],
    add(message, variant = 'info', title = '') {
        const id = Date.now() + Math.random().toString(36).substring(2, 9);
        this.toasts.push({ id, message, variant, title });
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}"
x-init="
    @if(session('success'))
        add('{{ session('success') }}', 'success', 'Success');
    @endif
    @if(session('error'))
        add('{{ session('error') }}', 'error', 'Error');
    @endif
    @if(session('warning'))
        add('{{ session('warning') }}', 'warning', 'Warning');
    @endif
    @if(session('info'))
        add('{{ session('info') }}', 'info', 'Info');
    @endif
"
@toast.window="add($event.detail.message, $event.detail.variant, $event.detail.title)"
class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => { show = false; setTimeout(() => remove(toast.id), 300) }, 4000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            :class="{
                'bg-white border-l-4 border-green-500': toast.variant === 'success',
                'bg-white border-l-4 border-red-500': toast.variant === 'error',
                'bg-white border-l-4 border-amber-500': toast.variant === 'warning',
                'bg-white border-l-4 border-blue-500': toast.variant === 'info'
            }"
            class="rounded-xl shadow-lg flex items-start gap-3 p-4 min-w-[280px] max-w-sm pointer-events-auto bg-white border border-gray-100"
        >
            <!-- Variant Icon SVG -->
            <div :class="{
                'text-green-500': toast.variant === 'success',
                'text-red-500': toast.variant === 'error',
                'text-amber-500': toast.variant === 'warning',
                'text-blue-500': toast.variant === 'info'
            }" class="shrink-0 mt-0.5">
                <template x-if="toast.variant === 'success'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </template>
                <template x-if="toast.variant === 'error'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </template>
                <template x-if="toast.variant === 'warning'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                </template>
                <template x-if="toast.variant === 'info'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.085 1.085l-.04.04m-1.085 1.085h1.125m-1.125-3h1.125m-1.125 3h1.125M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </template>
            </div>
            
            <div class="flex-1 min-w-0">
                <p x-show="toast.title" class="text-sm font-semibold text-gray-900" x-text="toast.title"></p>
                <p class="text-sm text-gray-600" x-text="toast.message"></p>
            </div>
            
            <button
                @click="show = false; setTimeout(() => remove(toast.id), 300)"
                class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </template>
</div>
