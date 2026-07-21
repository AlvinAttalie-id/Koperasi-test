<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $provinces = DB::table('provinces')->pluck('id', 'code')->toArray();

        $citiesData = [
            // Aceh
            '11' => [
                ['code' => '1171', 'name' => 'Banda Aceh', 'type' => CityType::Kota->value],
                ['code' => '1172', 'name' => 'Lhokseumawe', 'type' => CityType::Kota->value],
            ],
            // Sumatera Utara
            '12' => [
                ['code' => '1271', 'name' => 'Medan', 'type' => CityType::Kota->value],
                ['code' => '1207', 'name' => 'Deli Serdang', 'type' => CityType::Kabupaten->value],
            ],
            // Sumatera Barat
            '13' => [
                ['code' => '1371', 'name' => 'Padang', 'type' => CityType::Kota->value],
            ],
            // Riau
            '14' => [
                ['code' => '1471', 'name' => 'Pekanbaru', 'type' => CityType::Kota->value],
            ],
            // Jambi
            '15' => [
                ['code' => '1571', 'name' => 'Jambi', 'type' => CityType::Kota->value],
            ],
            // Sumatera Selatan
            '16' => [
                ['code' => '1671', 'name' => 'Palembang', 'type' => CityType::Kota->value],
            ],
            // Bengkulu
            '17' => [
                ['code' => '1771', 'name' => 'Bengkulu', 'type' => CityType::Kota->value],
            ],
            // Lampung
            '18' => [
                ['code' => '1871', 'name' => 'Bandar Lampung', 'type' => CityType::Kota->value],
            ],
            // Bangka Belitung
            '19' => [
                ['code' => '1971', 'name' => 'Pangkalpinang', 'type' => CityType::Kota->value],
            ],
            // Kepulauan Riau
            '21' => [
                ['code' => '2171', 'name' => 'Batam', 'type' => CityType::Kota->value],
            ],
            // DKI Jakarta
            '31' => [
                ['code' => '3171', 'name' => 'Jakarta Selatan', 'type' => CityType::Kota->value],
                ['code' => '3172', 'name' => 'Jakarta Timur', 'type' => CityType::Kota->value],
            ],
            // Jawa Barat
            '32' => [
                ['code' => '3273', 'name' => 'Bandung', 'type' => CityType::Kota->value],
                ['code' => '3275', 'name' => 'Bekasi', 'type' => CityType::Kota->value],
            ],
            // Jawa Tengah
            '33' => [
                ['code' => '3374', 'name' => 'Semarang', 'type' => CityType::Kota->value],
                ['code' => '3372', 'name' => 'Surakarta', 'type' => CityType::Kota->value],
            ],
            // DI Yogyakarta
            '34' => [
                ['code' => '3471', 'name' => 'Yogyakarta', 'type' => CityType::Kota->value],
                ['code' => '3404', 'name' => 'Sleman', 'type' => CityType::Kabupaten->value],
            ],
            // Jawa Timur
            '35' => [
                ['code' => '3578', 'name' => 'Surabaya', 'type' => CityType::Kota->value],
                ['code' => '3573', 'name' => 'Malang', 'type' => CityType::Kota->value],
            ],
            // Banten
            '36' => [
                ['code' => '3674', 'name' => 'Tangerang Selatan', 'type' => CityType::Kota->value],
            ],
            // Bali
            '51' => [
                ['code' => '5171', 'name' => 'Denpasar', 'type' => CityType::Kota->value],
            ],
            // Nusa Tenggara Barat
            '52' => [
                ['code' => '5271', 'name' => 'Mataram', 'type' => CityType::Kota->value],
            ],
            // Nusa Tenggara Timur
            '53' => [
                ['code' => '5371', 'name' => 'Kupang', 'type' => CityType::Kota->value],
            ],
            // Kalimantan Barat
            '61' => [
                ['code' => '6171', 'name' => 'Pontianak', 'type' => CityType::Kota->value],
            ],
            // Kalimantan Tengah
            '62' => [
                ['code' => '6271', 'name' => 'Palangkaraya', 'type' => CityType::Kota->value],
            ],
            // Kalimantan Selatan
            '63' => [
                ['code' => '6372', 'name' => 'Banjarbaru', 'type' => CityType::Kota->value],
                ['code' => '6371', 'name' => 'Banjarmasin', 'type' => CityType::Kota->value],
                ['code' => '6303', 'name' => 'Banjar', 'type' => CityType::Kabupaten->value],
            ],
            // Kalimantan Timur
            '64' => [
                ['code' => '6472', 'name' => 'Samarinda', 'type' => CityType::Kota->value],
            ],
            // Kalimantan Utara
            '65' => [
                ['code' => '6571', 'name' => 'Tarakan', 'type' => CityType::Kota->value],
            ],
            // Sulawesi Utara
            '71' => [
                ['code' => '7171', 'name' => 'Manado', 'type' => CityType::Kota->value],
            ],
            // Sulawesi Tengah
            '72' => [
                ['code' => '7271', 'name' => 'Palu', 'type' => CityType::Kota->value],
            ],
            // Sulawesi Selatan
            '73' => [
                ['code' => '7371', 'name' => 'Makassar', 'type' => CityType::Kota->value],
            ],
            // Sulawesi Tenggara
            '74' => [
                ['code' => '7471', 'name' => 'Kendari', 'type' => CityType::Kota->value],
            ],
            // Gorontalo
            '75' => [
                ['code' => '7571', 'name' => 'Gorontalo', 'type' => CityType::Kota->value],
            ],
            // Sulawesi Barat
            '76' => [
                ['code' => '7602', 'name' => 'Mamuju', 'type' => CityType::Kabupaten->value],
            ],
            // Maluku
            '81' => [
                ['code' => '8171', 'name' => 'Ambon', 'type' => CityType::Kota->value],
            ],
            // Maluku Utara
            '82' => [
                ['code' => '8271', 'name' => 'Ternate', 'type' => CityType::Kota->value],
            ],
            // Papua
            '91' => [
                ['code' => '9171', 'name' => 'Jayapura', 'type' => CityType::Kota->value],
            ],
            // Papua Barat
            '92' => [
                ['code' => '9202', 'name' => 'Manokwari', 'type' => CityType::Kabupaten->value],
            ],
            // Papua Selatan
            '93' => [
                ['code' => '9302', 'name' => 'Merauke', 'type' => CityType::Kabupaten->value],
            ],
            // Papua Tengah
            '94' => [
                ['code' => '9401', 'name' => 'Nabire', 'type' => CityType::Kabupaten->value],
            ],
            // Papua Pegunungan
            '95' => [
                ['code' => '9501', 'name' => 'Jayawijaya', 'type' => CityType::Kabupaten->value],
            ],
            // Papua Barat Daya
            '96' => [
                ['code' => '9671', 'name' => 'Sorong', 'type' => CityType::Kota->value],
            ],
        ];

        $insertData = [];
        foreach ($citiesData as $provCode => $cities) {
            if (! isset($provinces[$provCode])) {
                continue;
            }
            $provId = $provinces[$provCode];
            foreach ($cities as $city) {
                $insertData[] = [
                    'province_id' => $provId,
                    'code' => $city['code'],
                    'name' => $city['name'],
                    'type' => $city['type'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('cities')->insert($insertData);
    }
}
