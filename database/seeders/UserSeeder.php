<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@koperasi.test'],
            [
                'name' => 'Super Admin',
                'phone' => '081234567890',
                'password' => 'password',
                'role' => UserRole::SuperAdmin,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'fo@koperasi.test'],
            [
                'name' => 'Front Office Staff',
                'phone' => '081234567891',
                'password' => 'password',
                'role' => UserRole::Fo,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'member@koperasi.test'],
            [
                'name' => 'John Member',
                'phone' => '081234567892',
                'password' => 'password',
                'role' => UserRole::Member,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        User::factory(10)->create();
    }
}
