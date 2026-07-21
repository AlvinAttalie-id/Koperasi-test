@props([
    'title' => 'Dashboard',
    'breadcrumb' => []
])

@php
    $user = auth()->user();
    $unreadCount = $user ? \App\Models\Notification::where('user_id', $user->id)->where('is_read', false)->count() : 0;
    $latestNotifications = $user ? \App\Models\Notification::where('user_id', $user->id)->latest('created_at')->take(3)->get() : collect();
    
    $roleLabel = match($user?->role) {
        \App\Enums\UserRole::SuperAdmin => 'Super Admin',
        \App\Enums\UserRole::Fo => 'Front Office',
        \App\Enums\UserRole::Member => 'Member',
        default => 'User'
    };
@endphp

<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 shrink-0">
    <div class="flex items-center gap-3">
        <!-- Mobile hamburger menu button -->
        <button
            @click="mobileOpen = true"
            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors"
        >
            <!-- Menu Icon -->
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div>
            @if(!empty($breadcrumb))
                <div class="hidden sm:flex items-center gap-1 text-xs text-gray-400 mb-0.5">
                    @foreach($breadcrumb as $i => $crumb)
                        <span class="flex items-center gap-1">
                            @if($i > 0)
                                <span>/</span>
                            @endif
                            <span class="{{ $loop->last ? 'text-gray-700' : '' }}">{{ $crumb }}</span>
                        </span>
                    @endforeach
                </div>
            @endif
            <h1 class="text-base font-semibold text-gray-900">{{ $title }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <!-- Notifications Bell Dropdown -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button
                @click="notifOpen = !notifOpen"
                @click.away="notifOpen = false"
                class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors relative"
            >
                <!-- Bell Icon -->
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                @if($unreadCount > 0)
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-green-500 border-2 border-white"></span>
                @endif
            </button>

            <!-- Dropdown menu -->
            <div
                x-show="notifOpen"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 top-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-900">Notifications</span>
                    <a href="{{ route('notifications.index') }}" class="text-xs text-green-600 hover:text-green-700 font-medium">
                        View all
                    </a>
                </div>
                <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                    @forelse($latestNotifications as $notification)
                        <div class="px-4 py-3 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-green-50/50' : '' }}">
                            <p class="text-sm font-medium text-gray-800">{{ $notification->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $notification->message }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-xs text-gray-400">
                            No notifications yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ profileOpen: false }">
            <button
                @click="profileOpen = !profileOpen"
                @click.away="profileOpen = false"
                class="flex items-center gap-2 h-9 px-2 rounded-lg hover:bg-gray-100 transition-colors"
            >
                <x-avatar :name="$user?->name ?? 'User'" size="sm" />
                <div class="hidden sm:block text-left">
                    <div class="text-sm font-medium text-gray-900 leading-tight">{{ $user?->name ?? 'User' }}</div>
                    <div class="text-xs text-gray-400 leading-tight">{{ $roleLabel }}</div>
                </div>
                <!-- Chevron Down -->
                <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
                x-show="profileOpen"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 top-12 w-52 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $user?->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $user?->email }}</p>
                </div>
                <div class="py-1">
                    <a
                        href="{{ route('profile.show') }}"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        <!-- Profile/User Icon -->
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        My Profile
                    </a>
                    <a
                        href="{{ route('profile.edit') }}"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        <!-- Settings Icon -->
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Settings
                    </a>
                    
                    <div class="border-t border-gray-100 mt-1 pt-1">
                        <!-- Sign Out Button -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <a
                            href="#"
                            @click.prevent="document.getElementById('logout-form').submit()"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                        >
                            <!-- Sign Out Icon -->
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Sign out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
