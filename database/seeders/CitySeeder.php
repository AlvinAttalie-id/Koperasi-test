<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CityType;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dki = Province::where('code', '31')->first();
        $jabar = Province::where('code', '32')->first();
        $jatim = Province::where('code', '35')->first();

        $cities = [
            ['province_id' => $dki?->id ?? 1, 'code' => '3171', 'name' => 'JAKARTA SELATAN', 'type' => CityType::Kota->value],
            ['province_id' => $dki?->id ?? 1, 'code' => '3172', 'name' => 'JAKARTA TIMUR', 'type' => CityType::Kota->value],
            ['province_id' => $jabar?->id ?? 2, 'code' => '3273', 'name' => 'BANDUNG', 'type' => CityType::Kota->value],
            ['province_id' => $jabar?->id ?? 2, 'code' => '3204', 'name' => 'BANDUNG', 'type' => CityType::Kabupaten->value],
            ['province_id' => $jatim?->id ?? 4, 'code' => '3578', 'name' => 'SURABAYA', 'type' => CityType::Kota->value],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['code' => $city['code']], $city);
        }
    }
}
