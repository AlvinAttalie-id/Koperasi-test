<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $districts = DB::table('districts')->get(['id', 'code', 'name']);

        $insertData = [];
        foreach ($districts as $district) {
            $provCode = substr($district->code, 0, 2);

            // Determine postal code first digit based on Indonesian regions
            if (in_array($provCode, ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21'], true)) {
                $postalPrefix = 2; // Sumatra
            } elseif ($provCode === '31') {
                $postalPrefix = 1; // DKI Jakarta
            } elseif (in_array($provCode, ['32', '36'], true)) {
                $postalPrefix = 4; // Jawa Barat & Banten
            } elseif (in_array($provCode, ['33', '34'], true)) {
                $postalPrefix = 5; // Jawa Tengah & Yogyakarta
            } elseif ($provCode === '35') {
                $postalPrefix = 6; // Jawa Timur
            } elseif (in_array($provCode, ['61', '62', '63', '64', '65'], true)) {
                $postalPrefix = 7; // Kalimantan
            } elseif (in_array($provCode, ['51', '52', '53'], true)) {
                $postalPrefix = 8; // Bali & Nusa Tenggara
            } else {
                $postalPrefix = 9; // Sulawesi, Maluku, Papua
            }

            // Extract base name from Kecamatan
            $baseName = str_replace('Kecamatan ', '', $district->name);

            // Generate exactly 3 villages per district
            for ($i = 1; $i <= 3; $i++) {
                $suffix = str_pad((string) $i, 4, '0', STR_PAD_LEFT);
                $villageCode = $district->code . $suffix;
                
                // Construct a 5-digit postal code (1 prefix digit + 2 middle digits from city/district + 2 index digits)
                $middleDigits = substr($district->code, 2, 2);
                $postalCode = sprintf('%d%s%02d', $postalPrefix, $middleDigits, $i);

                $villageNames = [
                    1 => 'Satu',
                    2 => 'Dua',
                    3 => 'Tiga',
                ];

                $insertData[] = [
                    'district_id' => $district->id,
                    'code' => $villageCode,
                    'name' => 'Kelurahan ' . $baseName . ' ' . $villageNames[$i],
                    'postal_code' => $postalCode,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Chunk insert to prevent database placeholder limits
        foreach (array_chunk($insertData, 500) as $chunk) {
            DB::table('villages')->insert($chunk);
        }
    }
}
