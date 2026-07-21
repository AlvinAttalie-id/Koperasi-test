<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CityType;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'province_id' => Province::factory(),
            'code' => (string) fake()->unique()->numerify('####'),
            'name' => fake()->city(),
            'type' => fake()->randomElement(CityType::cases()),
        ];
    }
}
