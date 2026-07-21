@extends('layouts.app')

@php
    $title = 'Notifications';
    $breadcrumb = ['Home', 'Notifications'];
@endphp

@section('title', 'Notifications')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">All Notifications</h2>
    </div>

    <x-card>
        <div class="divide-y divide-gray-100 -mx-6">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 flex items-start justify-between gap-4 transition-colors {{ !$notification->is_read ? 'bg-green-50/40 hover:bg-green-50/60' : 'hover:bg-gray-50' }}">
                    <div class="flex gap-3">
                        <!-- Unread Dot -->
                        @if(!$notification->is_read)
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-transparent mt-1.5 shrink-0"></span>
                        @endif
                        
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $notification->title }}</p>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-1 font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if(!$notification->is_read)
                        <!-- Mark as Read Form -->
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button
                                type="submit"
                                class="shrink-0 h-8 px-3 rounded-lg border border-gray-200 text-xs font-semibold text-gray-600 hover:text-green-600 hover:border-green-200 hover:bg-green-50 transition-all flex items-center gap-1"
                                title="Mark as read"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                Mark as read
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="py-12">
                    <x-empty-state
                        title="All caught up!"
                        description="You have no notifications at the moment."
                    />
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <x-pagination :paginator="$notifications" />
    </x-card>
</div>
@endsection
