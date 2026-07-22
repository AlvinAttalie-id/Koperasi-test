@extends('layouts.app')

@php
    $title = 'Edit Profile';
    $breadcrumb = ['Home', 'Profile', 'Edit'];
@endphp

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Edit My Profile</h2>
        <a href="{{ route('profile.show') }}" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            Back to profile
        </a>
    </div>

    @if(!$memberProfile)
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <x-card title="Account Details">
                <p class="text-sm text-gray-500 mb-5">Update the contact details for your account.</p>
                <div class="space-y-4">
                    <x-form-input label="Full Name" name="name" :value="$user->name" placeholder="Enter full name" required />
                    <x-form-input label="Phone Number" name="phone" :value="$user->phone" placeholder="08XXXXXXXXXX" />
                </div>
            </x-card>

            <div class="flex justify-end gap-3">
                <a href="{{ route('profile.show') }}" class="h-10 px-4 flex items-center justify-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="h-10 px-6 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">Save Changes</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6"
              x-data="{
                  province_id: '{{ old('province_id', $memberProfile->province_id) }}',
                  city_id: '{{ old('city_id', $memberProfile->city_id) }}',
                  district_id: '{{ old('district_id', $memberProfile->district_id) }}',
                  village_id: '{{ old('village_id', $memberProfile->village_id) }}',
                  cities: @js($cities->map(fn($c) => ['id' => $c->id, 'name' => $c->name])),
                  districts: @js($districts->map(fn($d) => ['id' => $d->id, 'name' => $d->name])),
                  villages: @js($villages->map(fn($v) => ['id' => $v->id, 'name' => $v->name])),
                  async loadCities() {
                      if (!this.province_id) { this.cities = []; this.city_id = ''; this.districts = []; this.district_id = ''; this.villages = []; this.village_id = ''; return; }
                      const res = await fetch('/cities?province_id=' + this.province_id, { headers: { 'Accept': 'application/json' } });
                      const data = await res.json();
                      this.cities = data.data || data;
                      this.city_id = ''; this.districts = []; this.district_id = ''; this.villages = []; this.village_id = '';
                  },
                  async loadDistricts() {
                      if (!this.city_id) { this.districts = []; this.district_id = ''; this.villages = []; this.village_id = ''; return; }
                      const res = await fetch('/districts?city_id=' + this.city_id, { headers: { 'Accept': 'application/json' } });
                      const data = await res.json();
                      this.districts = data.data || data;
                      this.district_id = ''; this.villages = []; this.village_id = '';
                  },
                  async loadVillages() {
                      if (!this.district_id) { this.villages = []; this.village_id = ''; return; }
                      const res = await fetch('/villages?district_id=' + this.district_id, { headers: { 'Accept': 'application/json' } });
                      const data = await res.json();
                      this.villages = data.data || data;
                      this.village_id = '';
                  }
              }"
        >
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-2">
                    <p class="text-sm font-medium text-red-700">Please fix the following errors:</p>
                    <ul class="mt-1 list-disc list-inside text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-2">
                    <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <x-card title="Edit Profile Details">
                <p class="text-xs text-gray-400 mb-5 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2">
                    Member Number, NIK, and Registration Date cannot be changed. Contact admin if you need to update them.
                </p>

                <div class="space-y-4">
                    <x-form-input label="Full Name" name="name" :value="$user->name" placeholder="Enter full name" required />
                    <x-form-input label="Phone Number" name="phone" :value="$user->phone" placeholder="08XXXXXXXXXX" />

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-select-dropdown
                            label="Gender"
                            name="gender"
                            :value="$memberProfile->gender instanceof \App\Enums\Gender ? $memberProfile->gender->value : $memberProfile->gender"
                            :options="[['value' => 'male', 'label' => 'Male'], ['value' => 'female', 'label' => 'Female']]"
                            required
                        />
                        <x-form-input label="Birth Place" name="birth_place" :value="$memberProfile->birth_place" placeholder="e.g. Jakarta" required />
                        <x-date-picker label="Birth Date" name="birth_date" :value="$memberProfile->birth_date ? \Carbon\Carbon::parse($memberProfile->birth_date)->format('Y-m-d') : ''" required />
                    </div>

                    <x-form-input label="Occupation" name="occupation" :value="$memberProfile->occupation" placeholder="e.g. Farmer, Teacher" required />

                    <div class="sm:col-span-2">
                        <x-textarea label="Full Address" name="address" :value="$memberProfile->address" placeholder="Street address, RT/RW, etc." required />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1.5 block">Province <span class="text-red-500 ml-0.5">*</span></label>
                            <div class="relative">
                                <select name="province_id" x-model="province_id" @change="loadCities()"
                                    class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500">
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
                            <label class="text-sm font-medium text-gray-700 mb-1.5 block">City <span class="text-red-500 ml-0.5">*</span></label>
                            <div class="relative">
                                <select name="city_id" x-model="city_id" @change="loadDistricts()" :disabled="!province_id"
                                    class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                                    <option value="">Select City</option>
                                    <template x-for="city in cities" :key="city.id"><option :value="city.id" x-text="city.name" :selected="city.id == city_id"></option></template>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                            @error('city_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1.5 block">District <span class="text-red-500 ml-0.5">*</span></label>
                            <div class="relative">
                                <select name="district_id" x-model="district_id" @change="loadVillages()" :disabled="!city_id"
                                    class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                                    <option value="">Select District</option>
                                    <template x-for="dist in districts" :key="dist.id"><option :value="dist.id" x-text="dist.name" :selected="dist.id == district_id"></option></template>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                            @error('district_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1.5 block">Village <span class="text-red-500 ml-0.5">*</span></label>
                            <div class="relative">
                                <select name="village_id" x-model="village_id" :disabled="!district_id"
                                    class="w-full h-10 bg-white border border-gray-200 rounded-lg text-sm pl-3 pr-9 appearance-none cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                                    <option value="">Select Village</option>
                                    <template x-for="vil in villages" :key="vil.id"><option :value="vil.id" x-text="vil.name" :selected="vil.id == village_id"></option></template>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                            @error('village_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Read only profile blocks -->
                    <div class="pt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-100">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-400">Member Number</label>
                            <div class="h-10 bg-gray-50 border border-gray-200 rounded-lg px-3 flex items-center text-sm text-gray-400 font-mono select-none cursor-not-allowed">
                                {{ $memberProfile->member_number }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-400">NIK</label>
                            <div class="h-10 bg-gray-50 border border-gray-200 rounded-lg px-3 flex items-center text-sm text-gray-400 font-mono select-none cursor-not-allowed">
                                {{ $memberProfile->nik }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-400">Registration Date</label>
                            <div class="h-10 bg-gray-50 border border-gray-200 rounded-lg px-3 flex items-center text-sm text-gray-400 select-none cursor-not-allowed">
                                {{ \Carbon\Carbon::parse($memberProfile->register_date)->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <div class="flex justify-end gap-3">
                <a href="{{ route('profile.show') }}" class="h-10 px-4 flex items-center justify-center text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="h-10 px-6 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">Save Changes</button>
            </div>
        </form>
    @endif
</div>
@endsection
