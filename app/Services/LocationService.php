<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    /**
     * Get all provinces.
     *
     * @return Collection<int, Province>
     */
    public function getProvinces(): Collection
    {
        return Province::orderBy('name', 'asc')->get();
    }

    /**
     * Get cities by province ID.
     *
     * @return Collection<int, City>
     */
    public function getCitiesByProvince(int $provinceId): Collection
    {
        return City::where('province_id', $provinceId)->orderBy('name', 'asc')->get();
    }

    /**
     * Get districts by city ID.
     *
     * @return Collection<int, District>
     */
    public function getDistrictsByCity(int $cityId): Collection
    {
        return District::where('city_id', $cityId)->orderBy('name', 'asc')->get();
    }

    /**
     * Get villages by district ID.
     *
     * @return Collection<int, Village>
     */
    public function getVillagesByDistrict(int $districtId): Collection
    {
        return Village::where('district_id', $districtId)->orderBy('name', 'asc')->get();
    }
}
