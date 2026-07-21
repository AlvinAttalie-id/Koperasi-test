<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'activity' => fake()->randomElement(['login', 'update_profile', 'view_dashboard', 'logout', 'change_password']),
            'description' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
