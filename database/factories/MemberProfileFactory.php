<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\City;
use App\Models\District;
use App\Models\MemberProfile;
use App\Models\Province;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MemberProfile>
 */
class MemberProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $province = Province::factory();
        $city = City::factory(['province_id' => $province]);
        $district = District::factory(['city_id' => $city]);
        $village = Village::factory(['district_id' => $district]);

        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'member_number' => 'MBR-' . fake()->unique()->numerify('######'),
            'nik' => fake()->unique()->numerify('35##############'),
            'avatar' => null,
            'gender' => fake()->randomElement(Gender::cases()),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '-20 years'),
            'address' => fake()->address(),
            'province_id' => $province,
            'city_id' => $city,
            'district_id' => $district,
            'village_id' => $village,
            'occupation' => fake()->jobTitle(),
            'register_date' => fake()->date('Y-m-d', 'now'),
            'created_by' => User::factory(),
        ];
    }
}
