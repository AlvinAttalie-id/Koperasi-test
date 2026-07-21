<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Village>
 */
class VillageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => District::factory(),
            'code' => (string) fake()->unique()->numerify('##########'),
            'name' => 'Desa ' . fake()->streetName(),
            'postal_code' => fake()->postcode(),
        ];
    }
}
