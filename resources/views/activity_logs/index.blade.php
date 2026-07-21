@extends('layouts.app')

@php
    $title = 'Activity Logs';
    $breadcrumb = ['Home', 'Activity Logs'];
    
    $headers = [
        'actor' => 'User',
        'activity' => 'Activity',
        'description' => 'Description',
        'date' => 'Date & Time'
    ];
@endphp

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-6">
    <x-card>
        <!-- Title and description of security timeline -->
        <div class="mb-6">
            <h3 class="text-base font-semibold text-gray-900 leading-none">System Activity Logs</h3>
            <p class="text-xs text-gray-400 mt-1.5">Audit trail of all actions performed in the system.</p>
        </div>

        <!-- Logs Table -->
        <x-data-table :headers="$headers">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50/80 transition-colors group">
                    <td class="py-3.5 px-3 first:pl-0 text-sm text-gray-700">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$log->user?->name ?? 'System'" size="sm" />
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $log->user?->name ?? 'System' }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $log->user?->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 font-mono text-xs">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $log->activity }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-600">
                        {{ $log->description }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm text-gray-400">
                        {{ $log->created_at ? $log->created_at->format('M d, Y H:i:s') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <x-empty-state
                            title="No activity logs found"
                            description="All system operations will be recorded here."
                        />
                    </td>
                </tr>
            @endforelse
        </x-data-table>

        <!-- Pagination -->
        <x-pagination :paginator="$logs" />
    </x-card>
</div>
@endsection
