<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LoginLog>
 */
class LoginLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loginAt = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'user_id' => User::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'login_at' => $loginAt,
            'logout_at' => fake()->optional(0.7)->dateTimeBetween($loginAt, 'now'),
            'created_at' => $loginAt,
        ];
    }
}
