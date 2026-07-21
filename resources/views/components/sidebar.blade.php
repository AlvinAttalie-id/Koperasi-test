@php
    $role = auth()->user()->role;
    $roleLabel = match($role) {
        \App\Enums\UserRole::SuperAdmin => 'Super Admin',
        \App\Enums\UserRole::Fo => 'Front Office',
        \App\Enums\UserRole::Member => 'Member',
        default => 'User'
    };

    // Define items dynamically based on role
    $navItems = [
        [
            'route' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'visible' => true
        ],
        [
            'route' => 'front-offices.index',
            'label' => 'Front Office',
            'icon' => 'fo',
            'visible' => $role === \App\Enums\UserRole::SuperAdmin
        ],
        [
            'route' => 'members.index',
            'label' => 'Members',
            'icon' => 'members',
            'visible' => $role !== \App\Enums\UserRole::Member
        ],
        [
            'route' => 'notifications.index',
            'label' => 'Notifications',
            'icon' => 'notifications',
            'badge' => auth()->user()->notifications()->where('is_read', false)->count(),
            'visible' => true
        ],
        [
            'route' => 'activity-logs.index',
            'label' => 'Activity Logs',
            'icon' => 'activity',
            'visible' => true
        ],
        [
            'route' => 'login-logs.index',
            'label' => 'Login Logs',
            'icon' => 'login-logs',
            'visible' => true
        ],
        [
            'route' => 'profile.show',
            'label' => 'Profile',
            'icon' => 'profile',
            'visible' => true
        ],
        [
            'route' => 'profile.edit', // Maps Settings to Profile Edit for placeholder
            'label' => 'Settings',
            'icon' => 'settings',
            'visible' => true
        ]
    ];
@endphp

<!-- Mobile overlay -->
<div
    x-show="mobileOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/40 z-30 lg:hidden"
    @click="mobileOpen = false"
></div>

<aside
    :class="[
        collapsed ? 'w-16' : 'w-64',
        mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]"
    class="fixed top-0 left-0 h-full z-40 flex flex-col bg-gray-900 transition-all duration-300 ease-in-out"
>
    <!-- Logo & Brand Header -->
    <div :class="collapsed ? 'justify-center' : 'gap-3'" class="flex items-center h-16 px-4 border-b border-gray-800 shrink-0">
        <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center shrink-0">
            <!-- Leaf SVG -->
            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
            </svg>
        </div>
        <div x-show="!collapsed" x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="min-w-0">
            <div class="text-sm font-bold text-white leading-tight truncate">KSP Nusantara</div>
            <div class="text-xs text-gray-400 leading-tight truncate">{{ $roleLabel }}</div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 space-y-0.5 px-2">
        @foreach($navItems as $item)
            @if($item['visible'])
                @php
                    $isActive = false;
                    if ($item['route'] === 'dashboard') {
                        $isActive = request()->routeIs('dashboard');
                    } elseif ($item['route'] === 'front-offices.index') {
                        $isActive = request()->routeIs('front-offices.*');
                    } elseif ($item['route'] === 'members.index') {
                        $isActive = request()->routeIs('members.*');
                    } elseif ($item['route'] === 'notifications.index') {
                        $isActive = request()->routeIs('notifications.*');
                    } elseif ($item['route'] === 'activity-logs.index') {
                        $isActive = request()->routeIs('activity-logs.*');
                    } elseif ($item['route'] === 'login-logs.index') {
                        $isActive = request()->routeIs('login-logs.*');
                    } elseif ($item['route'] === 'profile.show') {
                        $isActive = request()->routeIs('profile.show');
                    } elseif ($item['route'] === 'profile.edit') {
                        $isActive = request()->routeIs('profile.edit') || request()->routeIs('profile.password.edit');
                    }
                @endphp
                <a
                    href="{{ route($item['route']) }}"
                    :class="collapsed ? 'justify-center' : ''"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-all duration-150 group {{ $isActive ? 'bg-green-600 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}"
                    title="{{ $item['label'] }}"
                >
                    <!-- Icon render -->
                    <div class="shrink-0 {{ $isActive ? 'text-white' : 'text-gray-400 group-hover:text-white' }}">
                        @if($item['icon'] === 'dashboard')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                        @elseif($item['icon'] === 'fo')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                        @elseif($item['icon'] === 'members')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109A4.125 4.125 0 0 1 9.75 16.5c1.39 0 2.63.69 3.375 1.748m.007-8.175a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM19.235 9.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                            </svg>
                        @elseif($item['icon'] === 'notifications')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        @elseif($item['icon'] === 'activity')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        @elseif($item['icon'] === 'login-logs')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        @elseif($item['icon'] === 'profile')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        @elseif($item['icon'] === 'settings')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif
                    </div>
                    
                    <!-- Label and badge -->
                    <template x-if="!collapsed">
                        <div class="flex-1 flex items-center justify-between min-w-0" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <span class="text-sm font-medium truncate">{{ $item['label'] }}</span>
                            @if(isset($item['badge']) && $item['badge'] > 0)
                                <span class="w-5 h-5 rounded-full bg-green-500 text-white text-xs flex items-center justify-center font-semibold">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </div>
                    </template>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- Collapse Toggle Button -->
    <div class="shrink-0 border-t border-gray-800 p-2">
        <button
            @click="collapsed = !collapsed"
            class="hidden lg:flex w-full items-center justify-center gap-2 px-3 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors text-sm"
        >
            <!-- Collapse arrow -->
            <svg class="w-4 h-4 transition-transform duration-300" :class="collapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span x-show="!collapsed">Collapse</span>
        </button>
    </div>
</aside>
