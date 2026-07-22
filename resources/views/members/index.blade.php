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
<div class="space-y-4 px-3 sm:px-6">
    <x-card class="!px-3.5 sm:!px-5">
        <!-- Search and Filter Toolbar -->
        <div class="flex flex-col gap-3 mb-4">
            <form action="{{ route('members.index') }}" method="GET" class="w-full">
                <x-search-bar
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search members..."
                    class="w-full"
                />
            </form>

            <div class="flex flex-wrap items-center gap-3">
                <x-filter-panel action="{{ route('members.index') }}">
                    <x-select-dropdown
                        name="province_id"
                        label="Province"
                        value="{{ request('province_id') }}"
                        :options="$provinces->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray()"
                        placeholder="All Provinces"
                        x-on:change="
                            fetch('/cities?province_id=' + $event.target.value, { headers: { 'Accept': 'application/json' } })
                                .then(r => r.json())
                                .then(d => {
                                    let c = document.querySelector('[name=city_id]');
                                    if (c) {
                                        c.options.length = 0;
                                        c.options.add(new Option('All Cities', ''));
                                        (d.data || d).forEach(city => c.options.add(new Option(city.name, city.id)));
                                    }
                                    let dist = document.querySelector('[name=district_id]');
                                    if (dist) {
                                        dist.options.length = 0;
                                        dist.options.add(new Option('All Districts', ''));
                                    }
                                })
                        "
                    />
                    <x-select-dropdown
                        name="city_id"
                        label="City"
                        value="{{ request('city_id') }}"
                        :options="$cities->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->toArray()"
                        placeholder="All Cities"
                        x-on:change="
                            fetch('/districts?city_id=' + $event.target.value, { headers: { 'Accept': 'application/json' } })
                                .then(r => r.json())
                                .then(d => {
                                    let dist = document.querySelector('[name=district_id]');
                                    if (dist) {
                                        dist.options.length = 0;
                                        dist.options.add(new Option('All Districts', ''));
                                        (d.data || d).forEach(dItem => dist.options.add(new Option(dItem.name, dItem.id)));
                                    }
                                })
                        "
                    />
                    <x-select-dropdown
                        name="district_id"
                        label="District"
                        value="{{ request('district_id') }}"
                        :options="$districts->map(fn($d) => ['value' => $d->id, 'label' => $d->name])->toArray()"
                        placeholder="All Districts"
                    />
                    <x-date-picker
                        name="register_date"
                        label="Registration Date"
                        value="{{ request('register_date') }}"
                    />
                    <x-select-dropdown
                        name="sort"
                        label="Sort By"
                        value="{{ request('sort', 'newest') }}"
                        :options="[
                            ['value' => 'newest', 'label' => 'Newest First'],
                            ['value' => 'oldest', 'label' => 'Oldest First']
                        ]"
                        placeholder=""
                    />
                </x-filter-panel>

                <a
                    href="{{ route('members.create') }}"
                    class="flex items-center justify-center gap-2 h-10 px-5 sm:px-7 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition-colors shrink-0"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="hidden sm:inline">Register Member</span>
                    <span class="sm:hidden">Register</span>
                </a>
            </div>
        </div>

        <!-- Members Table -->
        <x-data-table :headers="$headers" mobileCards>
            @forelse($members as $member)
                @php
                    $statusVal = $member->user->status instanceof \App\Enums\UserStatus ? $member->user->status->value : $member->user->status;
                @endphp
                
                <!-- Desktop/Tablet Table Row -->
                <tr class="hover:bg-gray-50/80 transition-colors group hidden xl:table-row">
                    <td class="py-3.5 px-3 first:pl-0 text-sm text-gray-700 flex-1 min-w-[220px]">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$member->user->name" size="sm" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 line-clamp-2 break-words">{{ $member->user->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $member->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 w-fit whitespace-nowrap">
                        <span class="font-mono text-xs">{{ $member->member_number }}</span>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 min-w-[150px]">
                        <p class="text-sm text-gray-700 truncate">{{ $member->city?->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $member->province?->name ?? '-' }}</p>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 min-w-[100px]">
                        <x-badge variant="{{ $statusVal === 'active' ? 'success' : 'danger' }}" dot>
                            {{ ucfirst($statusVal) }}
                        </x-badge>
                    </td>
                    <td class="py-3.5 px-3 text-sm text-gray-700 min-w-[100px] whitespace-nowrap">
                        {{ $member->register_date ? \Carbon\Carbon::parse($member->register_date)->format('d M, Y') : '-' }}
                    </td>
                    <td class="py-3.5 px-3 last:pr-0 text-sm text-gray-700 w-fit">
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

                <!-- Mobile Card View (< 640px) -->
                <div class="responsive-data-card xl:hidden w-full bg-white border border-gray-100 rounded-xl p-3.5 space-y-3 break-words min-w-0">
                    <div class="responsive-data-card__header">
                        <x-avatar :name="$member->user->name" size="md" class="responsive-data-card__avatar" />
                        <div class="responsive-data-card__user-info">
                            <p class="text-base font-semibold text-gray-900 break-anywhere">{{ $member->user->name }}</p>
                            <p class="text-sm text-gray-400 break-anywhere">{{ $member->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="responsive-data-card__content pt-2 border-t border-gray-100">
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Member No.</p>
                            <p class="text-sm font-mono text-gray-900 break-words">{{ $member->member_number }}</p>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            <x-badge variant="{{ $statusVal === 'active' ? 'success' : 'danger' }}" dot>
                                {{ ucfirst($statusVal) }}
                            </x-badge>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Location</p>
                            <p class="text-sm text-gray-900 break-anywhere">{{ $member->city?->name ?? '-' }}</p>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Registered</p>
                            <p class="text-sm text-gray-900 break-words">{{ $member->register_date ? \Carbon\Carbon::parse($member->register_date)->format('d M, Y') : '-' }}</p>
                        </div>
                    </div>

                    <div class="responsive-data-card__actions flex items-center gap-3 pt-2 border-t border-gray-100 flex-wrap">
                        <a href="{{ route('members.show', $member->uuid) }}" class="flex-1 min-w-[120px] h-11 flex items-center justify-center gap-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            <span class="truncate">View</span>
                        </a>
                        <a href="{{ route('members.edit', $member->uuid) }}" class="flex-1 min-w-[120px] h-11 flex items-center justify-center gap-2 text-sm font-medium text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                            <span class="truncate">Edit</span>
                        </a>
                        <button type="button" @click="$dispatch('open-modal-delete-member', { actionUrl: '{{ route('members.destroy', $member->uuid) }}' })" class="h-11 w-11 flex items-center justify-center gap-2 text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <!-- Desktop Empty State -->
                <tr class="hidden xl:table-row">
                    <td colspan="6">
                        <x-empty-state title="No members found" description="Register your first cooperative member to get started." />
                    </td>
                </tr>
                <!-- Mobile Empty State -->
                <div class="xl:hidden">
                    <x-empty-state title="No members found" description="Register your first cooperative member to get started." />
                </div>
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
