<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jaksel = City::where('code', '3171')->first();
        $bandung = City::where('code', '3273')->first();
        $surabaya = City::where('code', '3578')->first();

        $districts = [
            ['city_id' => $jaksel?->id ?? 1, 'code' => '317101', 'name' => 'KAYAMAT BARU'],
            ['city_id' => $jaksel?->id ?? 1, 'code' => '317102', 'name' => 'KEBAYORAN BARU'],
            ['city_id' => $bandung?->id ?? 3, 'code' => '327301', 'name' => 'COBLONG'],
            ['city_id' => $surabaya?->id ?? 5, 'code' => '357801', 'name' => 'TEBALSARI'],
        ];

        foreach ($districts as $district) {
            District::firstOrCreate(['code' => $district['code']], $district);
        }
    }
}
