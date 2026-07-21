<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'code' => (string) fake()->unique()->numerify('######'),
            'name' => 'Kecamatan ' . fake()->citySuffix(),
        ];
    }
}
