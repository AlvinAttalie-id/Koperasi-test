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
<div class="space-y-6">
    <x-card>
        <!-- Title and description of login logs -->
        <div class="mb-6">
            <h3 class="text-base font-semibold text-gray-900 leading-none">Security & Login Logs</h3>
            <p class="text-xs text-gray-400 mt-1.5">Track recent login attempts and active sessions.</p>
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
                        {{ $log->ip_address }}
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-500 max-w-[200px] truncate" title="{{ $log->user_agent }}">
                        {{ $log->user_agent }}
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-400">
                        {{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->format('M d, Y H:i:s') : '-' }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm">
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
                <tr>
                    <td colspan="5">
                        <x-empty-state
                            title="No login logs found"
                            description="All system authentication events will be tracked here."
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
