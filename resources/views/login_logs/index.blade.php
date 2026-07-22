@extends('layouts.app')

@php
    $title = 'Login Logs';
    $breadcrumb = ['Home', 'Login Logs'];
    
    $headers = [
        'user' => 'User',
        'ip_address' => 'IP Address',
        'user_agent' => 'Device/Browser',
        'login_at' => 'Login Time',
        'logout_at' => 'Duration/Status'
    ];
@endphp

@section('title', 'Login Logs')

@section('content')
<div class="space-y-4 px-3 sm:px-6">
    <x-card class="!px-3.5 sm:!px-5">
        <!-- Title and description of login logs -->
        <div class="mb-4">
            <h3 class="text-base font-semibold text-gray-900 leading-none">Security & Login Logs</h3>
            <p class="text-xs text-gray-400 mt-1.5">Track recent login attempts and active sessions.</p>
        </div>

        <!-- Logs Table -->
        <x-data-table :headers="$headers" mobileCards>
            <x-slot:tableRows>
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
                    <td class="py-3.5 px-3 text-sm text-gray-700 font-mono text-xs min-w-[140px] whitespace-nowrap">
                        {{ $log->ip_address }}
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-500 max-w-[200px] truncate min-w-[150px]" title="{{ $log->user_agent }}">
                        {{ $log->user_agent }}
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-400 min-w-[150px] whitespace-nowrap">
                        {{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->format('M d, Y H:i:s') : '-' }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm min-w-[120px]">
                        @if($log->logout_at)
                            @php
                                $login = \Carbon\Carbon::parse($log->login_at);
                                $logout = \Carbon\Carbon::parse($log->logout_at);
                                $duration = $login->diffForHumans($logout, true, true, 2);
                            @endphp
                            <div class="flex flex-col">
                                <span class="text-gray-700 text-sm font-medium">Logged out</span>
                                <span class="text-gray-400 text-xs mt-0.5">Duration: {{ $duration }}</span>
                            </div>
                        @else
                            <x-badge variant="success" dot>
                                Active Session
                            </x-badge>
                        @endif
                    </td>
                </tr>

            @empty
                <!-- Desktop Empty State -->
                <tr>
                    <td colspan="5">
                        <x-empty-state
                            title="No login logs found"
                            description="All system authentication events will be tracked here."
                        />
                    </td>
                </tr>
            @endforelse
            </x-slot:tableRows>

            <x-slot:mobileCardsContent>
            @forelse($logs as $log)
                <!-- Mobile Card View -->
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
                            <p class="text-xs text-gray-500 mb-1">IP Address</p>
                            <p class="text-sm font-mono text-gray-900 break-words">{{ $log->ip_address }}</p>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            @if($log->logout_at)
                                @php
                                    $login = \Carbon\Carbon::parse($log->login_at);
                                    $logout = \Carbon\Carbon::parse($log->logout_at);
                                    $duration = $login->diffForHumans($logout, true, true, 2);
                                @endphp
                                <p class="text-sm text-gray-900">Logged out</p>
                            @else
                                <x-badge variant="success" dot>
                                    Active
                                </x-badge>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Login Time</p>
                            <p class="text-sm text-gray-900 break-words">{{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->format('M d, Y H:i:s') : '-' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Mobile Empty State -->
                <div>
                    <x-empty-state
                        title="No login logs found"
                        description="All system authentication events will be tracked here."
                    />
                </div>
            @endforelse
            </x-slot:mobileCardsContent>
        </x-data-table>

        <!-- Pagination -->
        <x-pagination :paginator="$logs" />
    </x-card>
</div>
@endsection
