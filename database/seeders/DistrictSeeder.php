<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $cities = DB::table('cities')->get(['id', 'code', 'name']);

        $customDistricts = [
            // Jakarta Selatan (3171)
            '3171' => ['Kebayoran Baru', 'Cilandak', 'Pasar Minggu', 'Jagakarsa', 'Mampang Prapatan'],
            // Jakarta Timur (3172)
            '3172' => ['Jatinegara', 'Duren Sawit', 'Pulogadung', 'Cakung', 'Kramat Jati'],
            // Bandung (3273)
            '3273' => ['Coblong', 'Sukasari', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Bandung Wetan'],
            // Surabaya (3578)
            '3578' => ['Tegalsari', 'Gubeng', 'Genteng', 'Bubutan', 'Simokerto'],
            // Medan (1271)
            '1271' => ['Medan Baru', 'Medan Area', 'Medan Kota', 'Medan Selayang', 'Medan Helvetia'],
            // Denpasar (5171)
            '5171' => ['Denpasar Barat', 'Denpasar Timur', 'Denpasar Utara', 'Denpasar Selatan', 'Denpasar Kota'],
            // Yogyakarta (3471)
            '3471' => ['Gondokusuman', 'Danurejan', 'Kotagede', 'Mantrijeron', 'Umbulharjo'],
        ];

        $insertData = [];
        foreach ($cities as $city) {
            $distNames = $customDistricts[$city->code] ?? [
                $city->name . ' Barat',
                $city->name . ' Timur',
                $city->name . ' Utara',
                $city->name . ' Selatan',
                $city->name . ' Tengah',
            ];

            foreach ($distNames as $index => $name) {
                $suffix = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                $insertData[] = [
                    'city_id' => $city->id,
                    'code' => $city->code . $suffix,
                    'name' => 'Kecamatan ' . $name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('districts')->insert($insertData);
    }
}
