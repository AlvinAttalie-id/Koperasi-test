@extends('layouts.app')

@php
    $title = 'Change Password';
    $breadcrumb = ['Home', 'Profile', 'Change Password'];
@endphp

@section('title', 'Change Password')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Change Password</h2>
        <a href="{{ route('profile.show') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            Back to profile
        </a>
    </div>

    <x-card>
        <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-input
                label="Current Password"
                type="password"
                name="current_password"
                placeholder="••••••••"
                required
            />

            <x-form-input
                label="New Password"
                type="password"
                name="password"
                placeholder="••••••••"
                required
                hint="Minimum 8 characters"
            />

            <x-form-input
                label="Confirm New Password"
                type="password"
                name="password_confirmation"
                placeholder="••••••••"
                required
            />

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a
                    href="{{ route('profile.show') }}"
                    class="h-10 px-4 flex items-center justify-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="h-10 px-4 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors"
                >
                    Update Password
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
