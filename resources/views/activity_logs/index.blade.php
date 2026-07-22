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
<div class="space-y-4 px-3 sm:px-6">
    <x-card class="!px-3.5 sm:!px-5">
        <!-- Title and description of security timeline -->
        <div class="mb-4">
            <h3 class="text-base font-semibold text-gray-900 leading-none">System Activity Logs</h3>
            <p class="text-xs text-gray-400 mt-1.5">Audit trail of all actions performed in the system.</p>
        </div>

        <!-- Logs Table -->
        <x-data-table :headers="$headers" mobileCards>
            @forelse($logs as $log)
                <!-- Desktop/Tablet Table Row -->
                <tr class="hover:bg-gray-50/80 transition-colors group hidden xl:table-row">
                    <td class="py-3.5 px-3 first:pl-0 text-sm text-gray-700 flex-1 min-w-[220px]">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$log->user?->name ?? 'System'" size="sm" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $log->user?->name ?? 'System' }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $log->user?->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 font-mono text-xs min-w-[120px]">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $log->activity }}
                        </span>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-600 min-w-[200px]">
                        {{ $log->description }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm text-gray-400 min-w-[150px] whitespace-nowrap">
                        {{ $log->created_at ? $log->created_at->format('M d, Y H:i:s') : '-' }}
                    </td>
                </tr>

                <!-- Mobile Card View (< 640px) -->
                <div class="responsive-data-card xl:hidden w-full bg-white border border-gray-100 rounded-xl p-3.5 space-y-3 break-words min-w-0">
                    <div class="responsive-data-card__header">
                        <x-avatar :name="$log->user?->name ?? 'System'" size="md" class="responsive-data-card__avatar" />
                        <div class="responsive-data-card__user-info">
                            <p class="text-base font-semibold text-gray-900 break-anywhere">{{ $log->user?->name ?? 'System' }}</p>
                            <p class="text-sm text-gray-400 break-anywhere">{{ $log->user?->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="responsive-data-card__content pt-2 border-t border-gray-100">
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Activity</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $log->activity }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Date</p>
                            <p class="text-sm text-gray-900 break-words">{{ $log->created_at ? $log->created_at->format('M d, Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Description</p>
                            <p class="text-sm text-gray-900 break-words">{{ $log->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Desktop Empty State -->
                <tr class="hidden xl:table-row">
                    <td colspan="4">
                        <x-empty-state
                            title="No activity logs found"
                            description="All system operations will be recorded here."
                        />
                    </td>
                </tr>
                <!-- Mobile Empty State -->
                <div class="xl:hidden">
                    <x-empty-state
                        title="No activity logs found"
                        description="All system operations will be recorded here."
                    />
                </div>
            @endforelse
        </x-data-table>

        <!-- Pagination -->
        <x-pagination :paginator="$logs" />
    </x-card>
</div>
@endsection
