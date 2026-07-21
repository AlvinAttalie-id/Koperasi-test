@extends('layouts.app')

@php
    $title = 'My Profile';
    $breadcrumb = ['Home', 'Profile'];
    $role = $user->role;
    $roleLabel = match($role) {
        \App\Enums\UserRole::SuperAdmin => 'Super Admin',
        \App\Enums\UserRole::Fo => 'Front Office',
        \App\Enums\UserRole::Member => 'Member',
        default => 'User'
    };
    $memberProfile = $user->memberProfile;
@endphp

@section('title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Profile Header Card -->
    <x-card>
        <div class="flex items-center gap-5">
            <x-avatar :name="$user->name" size="lg" />
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $user->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    @if($memberProfile)
                        <span class="text-sm font-mono text-gray-500">{{ $memberProfile->member_number }}</span>
                    @else
                        <span class="text-sm text-gray-500 font-medium">{{ $roleLabel }}</span>
                    @endif
                    @php $statusVal = $user->status instanceof \App\Enums\UserStatus ? $user->status->value : $user->status; @endphp
                    <x-badge variant="{{ $statusVal === 'active' ? 'success' : 'danger' }}" dot>
                        {{ ucfirst($statusVal) }}
                    </x-badge>
                </div>
                <p class="text-xs text-gray-400 mt-1">Account Created: {{ $user->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </x-card>

    <!-- Detailed Personal Info Card -->
    <x-card title="Personal Information">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Email -->
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Email Address</p>
                    <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Phone -->
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.157-5.09-3.422-6.248-6.248l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H3.6c-1.243 0-2.25 1.008-2.25 2.25V6.75Z" /></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Phone Number</p>
                    <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $user->phone ?? '-' }}</p>
                </div>
            </div>

            @if($memberProfile)
                <!-- NIK -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">NIK</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5 font-mono">{{ $memberProfile->nik }}</p>
                    </div>
                </div>

                <!-- Gender -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Gender</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ ucfirst($memberProfile->gender instanceof \App\Enums\Gender ? $memberProfile->gender->value : $memberProfile->gender) }}</p>
                    </div>
                </div>

                <!-- Birth Place / Date -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Birth Info</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5">
                            {{ $memberProfile->birth_place }}, {{ \Carbon\Carbon::parse($memberProfile->birth_date)->format('d M, Y') }}
                        </p>
                    </div>
                </div>

                <!-- Occupation -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0a9.003 9.003 0 0 0-3.375-6.172l-.75-.536a2.25 2.25 0 0 0-3.23.42l-.864 1.152a2.25 2.25 0 0 1-3.23.42l-.864-1.152a2.25 2.25 0 0 0-3.23-.42l-.75.536A9.003 9.003 0 0 0 3.75 14.15m16.5 0V7.5a2.25 2.25 0 0 0-2.25-2.25h-15c-1.03 0-1.9.693-2.166 1.638m.375 7.262V7.5m15 0v3.75m-15 0v3.75m3-11.25V18a2.25 2.25 0 0 0 2.25 2.25h9A2.25 2.25 0 0 0 15 18V3.75m-6 0h6" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Occupation</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $memberProfile->occupation }}</p>
                    </div>
                </div>
            @endif
        </div>
    </x-card>

    @if($memberProfile)
        <!-- Member Address Card -->
        <x-card title="Address Details">
            <div class="space-y-4">
                <div>
                    <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block">Full Address</span>
                    <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $memberProfile->address }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block">Province</span>
                        <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $memberProfile->province?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block">City</span>
                        <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $memberProfile->city?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block">District</span>
                        <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $memberProfile->district?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block">Village</span>
                        <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $memberProfile->village?->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </x-card>
    @endif

    <!-- Profile Action Card -->
    <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4">
        <a
            href="{{ route('profile.password.edit') }}"
            class="h-10 px-4 flex items-center justify-center gap-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
        >
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
            Change Password
        </a>
        @if($memberProfile)
            <a
                href="{{ route('profile.edit') }}"
                class="h-10 px-5 flex items-center justify-center gap-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                Edit Profile
            </a>
        @endif
    </div>
</div>
@endsection
