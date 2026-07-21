<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kebayoran = District::where('code', '317102')->first();
        $coblong = District::where('code', '327301')->first();

        $villages = [
            ['district_id' => $kebayoran?->id ?? 2, 'code' => '3171021001', 'name' => 'SENAYAN', 'postal_code' => '12190'],
            ['district_id' => $kebayoran?->id ?? 2, 'code' => '3171021002', 'name' => 'GUNUNG', 'postal_code' => '12120'],
            ['district_id' => $coblong?->id ?? 3, 'code' => '3273011001', 'name' => 'DAGO', 'postal_code' => '40135'],
        ];

        foreach ($villages as $village) {
            Village::firstOrCreate(['code' => $village['code']], $village);
        }
    }
}
