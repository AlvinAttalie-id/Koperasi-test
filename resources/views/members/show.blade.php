@extends('layouts.app')

@php
    $title = $member->user->name;
    $breadcrumb = ['Home', 'Members', $member->user->name];
@endphp

@section('title', $member->user->name . ' — Member Detail')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Member Details</h2>
        <a href="{{ route('members.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            Back to list
        </a>
    </div>

    <!-- Profile Header -->
    <x-card>
        <div class="flex items-center gap-4 border-b border-gray-100 pb-6 mb-6">
            <x-avatar :name="$member->user->name" size="lg" />
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-bold text-gray-900">{{ $member->user->name }}</h3>
                <p class="text-sm text-gray-500 font-mono">{{ $member->member_number }}</p>
            </div>
            <div>
                @php $statusVal = $member->user->status instanceof \App\Enums\UserStatus ? $member->user->status->value : $member->user->status; @endphp
                <x-badge variant="{{ $statusVal === 'active' ? 'success' : 'danger' }}" dot>
                    {{ ucfirst($statusVal) }}
                </x-badge>
            </div>
        </div>

        <!-- Personal Info -->
        <h4 class="text-sm font-semibold text-gray-900 mb-4">Personal Information</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">NIK</span>
                <p class="text-sm font-medium text-gray-900 mt-1 font-mono">{{ $member->nik }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Gender</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ ucfirst($member->gender instanceof \App\Enums\Gender ? $member->gender->value : $member->gender) }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Birth Place</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->birth_place }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Birth Date</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ \Carbon\Carbon::parse($member->birth_date)->format('F d, Y') }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Occupation</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->occupation }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Registration Date</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ \Carbon\Carbon::parse($member->register_date)->format('F d, Y') }}</p>
            </div>
        </div>

        <!-- Contact Info -->
        <h4 class="text-sm font-semibold text-gray-900 mb-4 pt-4 border-t border-gray-100">Contact Information</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Email</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->user->email }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->user->phone ?? '-' }}</p>
            </div>
        </div>

        <!-- Address -->
        <h4 class="text-sm font-semibold text-gray-900 mb-4 pt-4 border-t border-gray-100">Address</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="sm:col-span-2">
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Full Address</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->address }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Province</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->province?->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">City</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->city?->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">District</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->district?->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Village</span>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->village?->name ?? '-' }}</p>
            </div>
        </div>

        <!-- Registered By -->
        @if($member->creator)
            <h4 class="text-sm font-semibold text-gray-900 mb-4 pt-4 border-t border-gray-100">Registered By</h4>
            <div class="flex items-center gap-3">
                <x-avatar :name="$member->creator->name" size="sm" />
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $member->creator->name }}</p>
                    <p class="text-xs text-gray-400">{{ $member->created_at->format('F d, Y \\a\\t H:i') }}</p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
            <a href="{{ route('members.edit', $member->uuid) }}" class="h-10 px-4 flex items-center justify-center gap-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                Edit
            </a>
            <button type="button" @click="$dispatch('open-modal-delete-member-detail', { actionUrl: '{{ route('members.destroy', $member->uuid) }}' })" class="h-10 px-4 flex items-center justify-center gap-2 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                Delete
            </button>
        </div>
    </x-card>
</div>

<x-confirm-modal
    name="delete-member-detail"
    title="Delete Member"
    message="Remove {{ $member->user->name }} from the system? This action cannot be undone."
    confirm-label="Delete"
    variant="danger"
    method="DELETE"
/>
@endsection
