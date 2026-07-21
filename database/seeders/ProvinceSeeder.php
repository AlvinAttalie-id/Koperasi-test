<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $provinces = [
            ['code' => '11', 'name' => 'Aceh', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '12', 'name' => 'Sumatera Utara', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '13', 'name' => 'Sumatera Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '14', 'name' => 'Riau', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '15', 'name' => 'Jambi', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '16', 'name' => 'Sumatera Selatan', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '17', 'name' => 'Bengkulu', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '18', 'name' => 'Lampung', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '19', 'name' => 'Bangka Belitung', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '21', 'name' => 'Kepulauan Riau', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '31', 'name' => 'DKI Jakarta', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '32', 'name' => 'Jawa Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '33', 'name' => 'Jawa Tengah', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '34', 'name' => 'DI Yogyakarta', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '35', 'name' => 'Jawa Timur', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '36', 'name' => 'Banten', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '51', 'name' => 'Bali', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '52', 'name' => 'Nusa Tenggara Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '53', 'name' => 'Nusa Tenggara Timur', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '61', 'name' => 'Kalimantan Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '62', 'name' => 'Kalimantan Tengah', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '63', 'name' => 'Kalimantan Selatan', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '64', 'name' => 'Kalimantan Timur', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '65', 'name' => 'Kalimantan Utara', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '71', 'name' => 'Sulawesi Utara', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '72', 'name' => 'Sulawesi Tengah', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '73', 'name' => 'Sulawesi Selatan', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '74', 'name' => 'Sulawesi Tenggara', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '75', 'name' => 'Gorontalo', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '76', 'name' => 'Sulawesi Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '81', 'name' => 'Maluku', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '82', 'name' => 'Maluku Utara', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '91', 'name' => 'Papua', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '92', 'name' => 'Papua Barat', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '93', 'name' => 'Papua Selatan', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '94', 'name' => 'Papua Tengah', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '95', 'name' => 'Papua Pegunungan', 'created_at' => $now, 'updated_at' => $now],
            ['code' => '96', 'name' => 'Papua Barat Daya', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('provinces')->insert($provinces);
    }
}
