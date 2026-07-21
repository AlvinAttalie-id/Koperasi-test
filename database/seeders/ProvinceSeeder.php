<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['code' => '31', 'name' => 'DKI JAKARTA'],
            ['code' => '32', 'name' => 'JAWA BARAT'],
            ['code' => '33', 'name' => 'JAWA TENGAH'],
            ['code' => '35', 'name' => 'JAWA TIMUR'],
            ['code' => '51', 'name' => 'BALI'],
        ];

        foreach ($provinces as $province) {
            Province::firstOrCreate(['code' => $province['code']], $province);
        }
    }
}
