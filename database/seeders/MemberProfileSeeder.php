<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MemberProfile;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MemberProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing member profiles to avoid duplicate keys/NIKs
        MemberProfile::query()->delete();

        $faker = Faker::create('id_ID');
        
        $activeFoIds = User::where('role', UserRole::Fo)
            ->where('status', UserStatus::Active)
            ->pluck('id')
            ->toArray();

        // Fallback to Super Admin or first user if no active FO found
        if (empty($activeFoIds)) {
            $activeFoIds = User::pluck('id')->toArray();
        }

        $memberUsers = User::where('role', UserRole::Member)->get();
        $memberProfiles = [];
        $now = now();

        foreach ($memberUsers as $index => $user) {
            // Get a random village with its complete hierarchy loaded
            $village = Village::with('district.city.province')->inRandomOrder()->first();
            if (!$village) {
                continue;
            }

            $district = $village->district;
            $city = $district->city;
            $province = $city->province;

            $gender = $faker->randomElement([Gender::Male, Gender::Female]);
            $birthPlace = str_replace(['Kota ', 'Kabupaten '], '', $city->name);
            
            // Random birthdate between 18 and 60 years ago
            $birthDateObj = $faker->dateTimeBetween('-60 years', '-18 years');
            $birthDate = $birthDateObj->format('Y-m-d');

            // Format DDMMYY for NIK
            $day = (int) $birthDateObj->format('d');
            if ($gender === Gender::Female) {
                $day += 40;
            }
            $dobPart = sprintf('%02d%s', $day, $birthDateObj->format('my'));

            // Build NIK: 6 digits district code + 6 digits birthdate + 4 digits sequence
            $nikRegCode = $district->code; // e.g. 327301
            $nikSeq = sprintf('%04d', $index + 1); // Sequence to guarantee uniqueness
            $nik = $nikRegCode . $dobPart . $nikSeq;

            $memberProfiles[] = [
                'uuid' => (string) Str::uuid(),
                'user_id' => $user->id,
                'member_number' => 'AG' . str_pad((string) ($index + 1), 6, '0', STR_PAD_LEFT),
                'nik' => $nik,
                'avatar' => null,
                'gender' => $gender->value,
                'birth_place' => $birthPlace,
                'birth_date' => $birthDate,
                'address' => $faker->streetAddress(),
                'province_id' => $province->id,
                'city_id' => $city->id,
                'district_id' => $district->id,
                'village_id' => $village->id,
                'occupation' => $faker->randomElement(['PNS', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Ibu Rumah Tangga', 'Guru', 'Pedagang', 'Buruh']),
                'register_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'created_by' => $faker->randomElement($activeFoIds),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        MemberProfile::insert($memberProfiles);
    }
}
