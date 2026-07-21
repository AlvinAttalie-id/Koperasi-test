<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Models\City;
use App\Models\District;
use App\Models\MemberProfile;
use App\Models\Province;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;

class MemberProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::where('role', UserRole::Fo->value)->first() ?? User::first();
        $province = Province::first();
        $city = City::first();
        $district = District::first();
        $village = Village::first();

        if (! $province || ! $city || ! $district || ! $village || ! $creator) {
            return;
        }

        $memberUsers = User::where('role', UserRole::Member->value)->get();

        foreach ($memberUsers as $index => $user) {
            MemberProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'member_number' => 'MBR-' . str_pad((string) ($index + 1), 6, '0', STR_PAD_LEFT),
                    'nik' => '3515' . str_pad((string) ($index + 1), 12, '0', STR_PAD_LEFT),
                    'gender' => $index % 2 === 0 ? Gender::Male : Gender::Female,
                    'birth_place' => 'Jakarta',
                    'birth_date' => '1995-05-15',
                    'address' => 'Jl. Merdeka No. ' . ($index + 1),
                    'province_id' => $province->id,
                    'city_id' => $city->id,
                    'district_id' => $district->id,
                    'village_id' => $village->id,
                    'occupation' => 'Wiraswasta',
                    'register_date' => now()->format('Y-m-d'),
                    'created_by' => $creator->id,
                ]
            );
        }
    }
}
