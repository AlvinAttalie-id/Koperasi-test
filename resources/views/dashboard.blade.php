@extends('layouts.app')

@php
    $title = 'Dashboard';
    $breadcrumb = ['Home', 'Dashboard'];
    $role = auth()->user()->role;
@endphp

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    @if($role === \App\Enums\UserRole::SuperAdmin)
        <!-- Super Admin Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <x-stat-card
                title="Total Members"
                value="{{ number_format($stats['total_members']) }}"
                icon-color="text-blue-600"
                icon-bg="bg-blue-50"
            >
                <x-slot:icon>
                    <!-- Users Icon -->
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109A4.125 4.125 0 0 1 9.75 16.5c1.39 0 2.63.69 3.375 1.748m.007-8.175a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM19.235 9.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                    </svg>
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card
                title="Total Front Office"
                value="{{ number_format($stats['total_fo']) }}"
                icon-color="text-purple-600"
                icon-bg="bg-purple-50"
            >
                <x-slot:icon>
                    <!-- UserCheck Icon -->
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card
                title="Active Members"
                value="{{ number_format($stats['active_members']) }}"
                icon-color="text-green-600"
                icon-bg="bg-green-50"
            >
                <x-slot:icon>
                    <!-- Activity Icon -->
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.6ZM18 12a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card
                title="Inactive Members"
                value="{{ number_format($stats['inactive_members']) }}"
                icon-color="text-red-600"
                icon-bg="bg-red-50"
            >
                <x-slot:icon>
                    <!-- UserX Icon -->
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </x-slot:icon>
            </x-stat-card>
        </div>

        <!-- Super Admin Quick Actions -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('members.create') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-sm font-medium">Register Member</span>
            </a>
            <a href="{{ route('members.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109A4.125 4.125 0 0 1 9.75 16.5c1.39 0 2.63.69 3.375 1.748m.007-8.175a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM19.235 9.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                </svg>
                <span class="text-sm font-medium">Manage Members</span>
            </a>
            <a href="{{ route('front-offices.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="text-sm font-medium">Front Office</span>
            </a>
            <a href="{{ route('login-logs.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>
                <span class="text-sm font-medium">Security Logs</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Front Offices -->
            <div class="lg:col-span-2">
                <x-card title="Recent Front Offices" subtitle="Latest registered Front Office staff">
                    <x-slot:action>
                        <a href="{{ route('front-offices.index') }}" class="flex items-center gap-1 text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                            View all
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </a>
                    </x-slot:action>
                    
                    <div class="space-y-3">
                        @forelse($stats['recent_front_offices'] as $fo)
                            <div class="flex items-center gap-3 py-2 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                                <x-avatar :name="$fo->name" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $fo->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $fo->email }}</p>
                                </div>
                                @php
                                    $foStatus = $fo->status instanceof \App\Enums\UserStatus ? $fo->status->value : $fo->status;
                                @endphp
                                <x-badge variant="{{ $foStatus === 'active' ? 'success' : 'danger' }}" dot>
                                    {{ ucfirst($foStatus) }}
                                </x-badge>
                            </div>
                        @empty
                            <div class="text-center py-6 text-sm text-gray-400">
                                No Front Office staff registered yet.
                            </div>
                        @endforelse
                    </div>
                </x-card>
            </div>

            <!-- Activity Logs Summary -->
            <div>
                <x-card title="Recent Activity">
                    <x-slot:action>
                        <a href="{{ route('activity-logs.index') }}" class="flex items-center gap-1 text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                            View all
                        </a>
                    </x-slot:action>
                    
                    <div class="space-y-4">
                        @forelse($stats['recent_activities'] as $log)
                            <div class="flex gap-3 items-start">
                                <div class="w-2 h-2 rounded-full bg-green-500 shrink-0 mt-1.5"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-800 leading-tight truncate">
                                        {{ $log->user?->name ?? 'System' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $log->description }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400">
                                No recent activities.
                            </div>
                        @endforelse
                    </div>
                </x-card>
            </div>
        </div>

    @elseif($role === \App\Enums\UserRole::Fo)
        <!-- Front Office Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <x-stat-card
                title="Total Registered Members"
                value="{{ number_format($stats['total_registered_members']) }}"
                icon-color="text-green-600"
                icon-bg="bg-green-50"
            >
                <x-slot:icon>
                    <!-- Users Icon -->
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109A4.125 4.125 0 0 1 9.75 16.5c1.39 0 2.63.69 3.375 1.748m.007-8.175a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM19.235 9.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                    </svg>
                </x-slot:icon>
            </x-stat-card>
        </div>

        <!-- Front Office Quick Actions -->
        <div class="grid grid-cols-2 gap-4 max-w-lg">
            <a href="{{ route('members.create') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-sm font-medium">Register Member</span>
            </a>
            <a href="{{ route('members.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-colors shadow-sm text-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109A4.125 4.125 0 0 1 9.75 16.5c1.39 0 2.63.69 3.375 1.748m.007-8.175a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM19.235 9.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                </svg>
                <span class="text-sm font-medium">Manage Members</span>
            </a>
        </div>

        <!-- Latest Members -->
        <x-card title="Latest Registered Members" subtitle="Latest registered cooperative members">
            <x-slot:action>
                <a href="{{ route('members.index') }}" class="flex items-center gap-1 text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                    View all
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </x-slot:action>
            
            <div class="space-y-3">
                @forelse($stats['latest_members'] as $profile)
                    <div class="flex items-center gap-3 py-2 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                        <x-avatar :name="$profile->user->name" size="sm" />
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $profile->user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $profile->member_number }}</p>
                        </div>
                        @php
                            $memberStatus = $profile->user->status instanceof \App\Enums\UserStatus ? $profile->user->status->value : $profile->user->status;
                        @endphp
                        <x-badge variant="{{ $memberStatus === 'active' ? 'success' : 'danger' }}" dot>
                            {{ ucfirst($memberStatus) }}
                        </x-badge>
                    </div>
                @empty
                    <div class="text-center py-6 text-sm text-gray-400">
                        No members registered yet.
                    </div>
                @endforelse
            </div>
        </x-card>

    @else
        <!-- Member Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Member profile summary card -->
            <div class="lg:col-span-2">
                <x-card title="My Member Profile" subtitle="Detailed information of your cooperative membership">
                    <x-slot:action>
                        <a href="{{ route('profile.show') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            View details
                        </a>
                    </x-slot:action>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                            <x-avatar :name="$stats['user']->name" size="lg" />
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $stats['user']->name }}</h4>
                                <p class="text-sm text-gray-500 font-mono">{{ $stats['member_profile']?->member_number ?? 'Membership pending' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs text-gray-400 block">Email Address</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $stats['user']->email }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">Phone Number</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $stats['user']->phone ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">Join Date</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $stats['member_profile']?->register_date ? \Carbon\Carbon::parse($stats['member_profile']->register_date)->format('F d, Y') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">Status</span>
                                <div>
                                    @php
                                        $userStatus = $stats['user']->status instanceof \App\Enums\UserStatus ? $stats['user']->status->value : $stats['user']->status;
                                    @endphp
                                    <x-badge variant="{{ $userStatus === 'active' ? 'success' : 'danger' }}" dot>
                                        {{ ucfirst($userStatus) }}
                                    </x-badge>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Address Summary card -->
            <div>
                <x-card title="My Address Info">
                    @if($stats['member_profile'])
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-xs text-gray-400 block">Province</span>
                                <span class="text-gray-900 font-medium">{{ $stats['member_profile']->province?->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">City</span>
                                <span class="text-gray-900 font-medium">{{ $stats['member_profile']->city?->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">District</span>
                                <span class="text-gray-900 font-medium">{{ $stats['member_profile']->district?->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">Village</span>
                                <span class="text-gray-900 font-medium">{{ $stats['member_profile']->village?->name ?? '-' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 text-sm text-gray-400">
                            No address information available.
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    @endif
</div>
@endsection
