@extends('layouts.app')

@php
    $title = $user->name;
    $breadcrumb = ['Home', 'Front Office', $user->name];
@endphp

@section('title', $user->name . ' — Front Office')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Front Office Details</h2>
        <a href="{{ route('front-offices.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Back to list
        </a>
    </div>

    <x-card>
        <div class="flex items-center gap-4 border-b border-gray-100 pb-6 mb-6">
            <x-avatar :name="$user->name" size="lg" />
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">Front Office Staff</p>
            </div>
            <div class="ml-auto">
                <x-badge variant="{{ $user->status === 'active' || ($user->status instanceof \App\Enums\UserStatus && $user->status === \App\Enums\UserStatus::Active) ? 'success' : 'danger' }}" dot size="md">
                    {{ ucfirst($user->status instanceof \App\Enums\UserStatus ? $user->status->value : $user->status) }}
                </x-badge>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Email Address</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->email }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Phone Number</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Created At</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->created_at->format('F d, Y \\a\\t H:i') }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Last Updated</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->updated_at->format('F d, Y \\a\\t H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
            <a
                href="{{ route('front-offices.edit', $user->uuid) }}"
                class="h-10 px-4 flex items-center justify-center gap-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit
            </a>
            <button
                type="button"
                @click="$dispatch('open-modal-delete-fo-detail', { actionUrl: '{{ route('front-offices.destroy', $user->uuid) }}' })"
                class="h-10 px-4 flex items-center justify-center gap-2 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Delete
            </button>
        </div>
    </x-card>
</div>

<x-confirm-modal
    name="delete-fo-detail"
    title="Delete Front Office Account"
    message="Remove {{ $user->name }} from the system? This action cannot be undone."
    confirm-label="Delete"
    variant="danger"
    method="DELETE"
/>
@endsection
