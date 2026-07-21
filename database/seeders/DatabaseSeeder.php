<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,
            UserSeeder::class,
            MemberProfileSeeder::class,
            LoginLogSeeder::class,
            ActivityLogSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
