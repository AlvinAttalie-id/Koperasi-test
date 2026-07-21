@extends('layouts.app')

@php
    $title = 'Member Management';
    $breadcrumb = ['Home', 'Members'];
    
    $headers = [
        'member' => ['label' => 'Member', 'sortable' => true, 'key' => 'name'],
        'member_number' => ['label' => 'Member No.', 'sortable' => true, 'key' => 'member_number'],
        'location' => 'Location',
        'status' => 'Status',
        'register_date' => ['label' => 'Registered', 'sortable' => true, 'key' => 'register_date'],
        'actions' => 'Actions'
    ];
@endphp

@section('title', 'Member Management')

@section('content')
<div class="space-y-6">
    <x-card>
        <!-- Search and Filter Toolbar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-6">
            <form action="{{ route('members.index') }}" method="GET" class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                <x-search-bar
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search members..."
                    class="sm:w-72"
                />
            </form>

            <div class="flex items-center gap-2 ml-auto w-full sm:w-auto justify-end">
                <x-filter-panel action="{{ route('members.index') }}">
                    <x-select-dropdown
                        name="province_id"
                        label="Province"
                        value="{{ request('province_id') }}"
                        :options="$provinces->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray()"
                        placeholder="All Provinces"
                        x-on:change="
                            fetch('/cities?province_id=' + $event.target.value)
                                .then(r => r.json())
                                .then(d => {
                                    let c = document.querySelector('[name=city_id]');
                                    c.innerHTML = '<option value=\"\">All Cities</option>';
                                    (d.data || d).forEach(city => {
                                        c.innerHTML += '<option value=\"' + city.id + '\">' + city.name + '</option>';
                                    });
                                })
                        "
                    />
                    <x-select-dropdown
                        name="city_id"
                        label="City"
                        value="{{ request('city_id') }}"
                        :options="[]"
                        placeholder="All Cities"
                    />
                    <x-select-dropdown
                        name="district_id"
                        label="District"
                        value="{{ request('district_id') }}"
                        :options="[]"
                        placeholder="All Districts"
                    />
                    <x-date-picker
                        name="register_date"
                        label="Registration Date"
                        value="{{ request('register_date') }}"
                    />
                </x-filter-panel>

                <a
                    href="{{ route('members.create') }}"
                    class="flex items-center gap-2 h-10 px-4 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shrink-0"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Register Member
                </a>
            </div>
        </div>

        <!-- Members Table -->
        <x-data-table :headers="$headers">
            @forelse($members as $member)
                <tr class="hover:bg-gray-50/80 transition-colors group">
                    <td class="py-3.5 px-3 first:pl-0 text-sm text-gray-700">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$member->user->name" size="sm" />
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $member->user->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $member->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700">
                        <span class="font-mono text-xs">{{ $member->member_number }}</span>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700">
                        <p class="text-sm text-gray-700 truncate">{{ $member->city?->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $member->province?->name ?? '-' }}</p>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700">
                        @php
                            $statusVal = $member->user->status instanceof \App\Enums\UserStatus ? $member->user->status->value : $member->user->status;
                        @endphp
                        <x-badge variant="{{ $statusVal === 'active' ? 'success' : 'danger' }}" dot>
                            {{ ucfirst($statusVal) }}
                        </x-badge>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700">
                        {{ $member->register_date ? \Carbon\Carbon::parse($member->register_date)->format('d M, Y') : '-' }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm text-gray-700">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('members.show', $member->uuid) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </a>
                            <a href="{{ route('members.edit', $member->uuid) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                            </a>
                            <button type="button" @click="$dispatch('open-modal-delete-member', { actionUrl: '{{ route('members.destroy', $member->uuid) }}' })" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="No members found" description="Register your first cooperative member to get started." />
                    </td>
                </tr>
            @endforelse
        </x-data-table>

        <x-pagination :paginator="$members" />
    </x-card>
</div>

<x-confirm-modal
    name="delete-member"
    title="Delete Member"
    message="Remove this member from the system? This action cannot be undone."
    confirm-label="Delete"
    variant="danger"
    method="DELETE"
/>
@endsection
