<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing logs
        ActivityLog::query()->delete();

        $faker = Faker::create('id_ID');
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            return;
        }

        $activities = [
            'login' => 'User logged into the system.',
            'logout' => 'User logged out of the system.',
            'created_member' => 'Created a new cooperative member profile.',
            'updated_member' => 'Updated member profile information.',
            'deleted_member' => 'Soft deleted member account.',
            'changed_password' => 'Changed user account password.',
            'updated_profile' => 'Updated personal profile details.',
            'view_dashboard' => 'Accessed main application dashboard.',
        ];

        $activityKeys = array_keys($activities);
        $logs = [];

        for ($i = 0; $i < 500; $i++) {
            $actKey = $faker->randomElement($activityKeys);
            $createdAt = $faker->dateTimeBetween('-1 month', 'now');

            $logs[] = [
                'user_id' => $faker->randomElement($userIds),
                'activity' => $actKey,
                'description' => $activities[$actKey],
                'created_at' => $createdAt->format('Y-m-d H:i:s'),
            ];
        }

        foreach (array_chunk($logs, 250) as $chunk) {
            ActivityLog::insert($chunk);
        }
    }
}
