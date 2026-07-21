<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LoginLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing logs to get exact count
        LoginLog::query()->delete();

        $faker = Faker::create();
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            return;
        }

        $logs = [];

        for ($i = 0; $i < 300; $i++) {
            $loginAt = $faker->dateTimeBetween('-1 month', 'now');
            
            // 70% chance of logout
            $logoutAt = $faker->boolean(70) 
                ? (clone $loginAt)->modify('+' . rand(5, 480) . ' minutes') 
                : null;

            $logs[] = [
                'user_id' => $faker->randomElement($userIds),
                'ip_address' => $faker->ipv4(),
                'user_agent' => $faker->userAgent(),
                'login_at' => $loginAt->format('Y-m-d H:i:s'),
                'logout_at' => $logoutAt ? $logoutAt->format('Y-m-d H:i:s') : null,
                'created_at' => $loginAt->format('Y-m-d H:i:s'),
            ];
        }

        LoginLog::insert($logs);
    }
}
