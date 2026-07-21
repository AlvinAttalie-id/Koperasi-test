@extends('layouts.app')

@php
    $title = 'Edit Front Office Account';
    $breadcrumb = ['Home', 'Front Office', $user->name, 'Edit'];
@endphp

@section('title', 'Edit Front Office')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Edit Front Office</h2>
        <a href="{{ route('front-offices.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Back to list
        </a>
    </div>

    <x-card>
        <form method="POST" action="{{ route('front-offices.update', $user->uuid) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-input
                label="Full Name"
                name="name"
                :value="$user->name"
                placeholder="Enter full name"
                required
            />

            <x-form-input
                label="Email Address"
                type="email"
                name="email"
                :value="$user->email"
                placeholder="fo@ksp.id"
                required
            />

            <x-form-input
                label="Phone Number"
                name="phone"
                :value="$user->phone"
                placeholder="08XXXXXXXXXX"
            />

            <x-form-input
                label="Password"
                type="password"
                name="password"
                placeholder="Leave blank to keep current"
                hint="Leave blank to keep the current password"
            />

            <x-select-dropdown
                label="Status"
                name="status"
                :value="$user->status instanceof \App\Enums\UserStatus ? $user->status->value : $user->status"
                :options="[
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'inactive', 'label' => 'Inactive']
                ]"
                required
            />

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a
                    href="{{ route('front-offices.index') }}"
                    class="h-10 px-4 flex items-center justify-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="h-10 px-4 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors"
                >
                    Update Account
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
