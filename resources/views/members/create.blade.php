@extends('layouts.app')

@php
    $title = 'Register Member';
    $breadcrumb = ['Home', 'Members', 'Register'];
@endphp

@section('title', 'Register Member')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Register New Member</h2>
        <a href="{{ route('members.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            Back to list
        </a>
    </div>

    <form method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data" class="space-y-6"
          x-data="{
              province_id: '{{ old('province_id') }}',
              city_id: '{{ old('city_id') }}',
              district_id: '{{ old('district_id') }}',
              village_id: '{{ old('village_id') }}',
              cities: [],
              districts: [],
              villages: [],
              async loadCities() {
                  if (!this.province_id) { this.cities = []; this.city_id = ''; this.districts = []; this.district_id = ''; this.villages = []; this.village_id = ''; return; }
                  const res = await fetch('/cities?province_id=' + this.province_id);
                  const data = await res.json();
                  this.cities = data.data || data;
                  this.city_id = ''; this.districts = []; this.district_id = ''; this.villages = []; this.village_id = '';
              },
              async loadDistricts() {
                  if (!this.city_id) { this.districts = []; this.district_id = ''; this.villages = []; this.village_id = ''; return; }
                  const res = await fetch('/districts?city_id=' + this.city_id);
                  const data = await res.json();
                  this.districts = data.data || data;
                  this.district_id = ''; this.villages = []; this.village_id = '';
              },
              async loadVillages() {
                  if (!this.district_id) { this.villages = []; this.village_id = ''; return; }
                  const res = await fetch('/villages?district_id=' + this.district_id);
                  const data = await res.json();
                  this.villages = data.data || data;
                  this.village_id = '';
              }
          }"
          x-init="
              if (province_id) { await loadCities(); city_id = '{{ old('city_id') }}'; }
              if (city_id) { await loadDistricts(); district_id = '{{ old('district_id') }}'; }
              if (district_id) { await loadVillages(); village_id = '{{ old('village_id') }}'; }
          "
    >
        @csrf

        <!-- Personal Information -->
        <x-card title="Personal Information" subtitle="Basic identity details of the member">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form-input label="Full Name" name="name" placeholder="Enter full name" required />
                <x-form-input label="NIK (National ID)" name="nik" placeholder="16-digit national ID" required />
                <x-select-dropdown
                    label="Gender"
                    name="gender"
                    :options="[['value' => 'male', 'label' => 'Male'], ['value' => 'female', 'label' => 'Female']]"
                    required
                />
                <x-form-input label="Birth Place" name="birth_place" placeholder="e.g. Jakarta" required />
                <x-date-picker label="Birth Date" name="birth_date" required />
                <x-form-input label="Occupation" name="occupation" placeholder="e.g. Farmer, Teacher" required />
            </div>
        </x-card>

        <!-- Address -->
        <x-card title="Address Information" subtitle="Residential address with location cascade">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <x-textarea label="Full Address" name="address" placeholder="Street address, RT/RW, etc." required />
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1.5 block">
                        Province <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select name="province_id" x-model="province_id" @change="loadCities()"
                            class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 {{ $errors->has('province_id') ? 'border-red-400' : '' }}">
                            <option value="">Select Province</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                    @error('province_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1.5 block">
                        City <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select name="city_id" x-model="city_id" @change="loadDistricts()" :disabled="!province_id"
                            class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed {{ $errors->has('city_id') ? 'border-red-400' : '' }}">
                            <option value="">Select City</option>
                            <template x-for="city in cities" :key="city.id">
                                <option :value="city.id" x-text="city.name"></option>
                            </template>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                    @error('city_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1.5 block">
                        District <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select name="district_id" x-model="district_id" @change="loadVillages()" :disabled="!city_id"
                            class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed {{ $errors->has('district_id') ? 'border-red-400' : '' }}">
                            <option value="">Select District</option>
                            <template x-for="dist in districts" :key="dist.id">
                                <option :value="dist.id" x-text="dist.name"></option>
                            </template>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                    @error('district_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1.5 block">
                        Village <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select name="village_id" x-model="village_id" :disabled="!district_id"
                            class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed {{ $errors->has('village_id') ? 'border-red-400' : '' }}">
                            <option value="">Select Village</option>
                            <template x-for="vil in villages" :key="vil.id">
                                <option :value="vil.id" x-text="vil.name"></option>
                            </template>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                    @error('village_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-card>

        <!-- Account Information -->
        <x-card title="Account Information" subtitle="Login credentials and registration date">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form-input label="Email Address" type="email" name="email" placeholder="member@email.com" required />
                <x-form-input label="Phone Number" name="phone" placeholder="08XXXXXXXXXX" />
                <x-form-input label="Password" type="password" name="password" placeholder="••••••••" required hint="Minimum 8 characters" />
                <x-date-picker label="Registration Date" name="register_date" required />
            </div>
        </x-card>

        <div class="flex justify-end gap-3">
            <a href="{{ route('members.index') }}" class="h-10 px-4 flex items-center justify-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="h-10 px-6 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                Register Member
            </button>
        </div>
    </form>
</div>
@endsection
