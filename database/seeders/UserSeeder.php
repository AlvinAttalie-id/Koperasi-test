<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing users to avoid conflicts
        User::query()->delete();

        $faker = Faker::create('id_ID');
        $password = Hash::make('password123');
        $now = now();

        $users = [];

        // 1. Super Admin (2)
        $superAdmins = [
            [
                'name' => 'Ahmad Fauzan',
                'email' => 'superadmin@koperasi.id',
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'admin2@koperasi.id',
            ],
        ];

        foreach ($superAdmins as $sa) {
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $sa['name'],
                'email' => $sa['email'],
                'phone' => '0811' . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::SuperAdmin->value,
                'status' => UserStatus::Active->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 2. Front Office (10)
        // Two named demo accounts, followed by six active staff accounts.
        $frontOffices = [
            ['name' => 'Rini Wati', 'email' => 'fo1@koperasi.id'],
            ['name' => 'Bagus Pratama', 'email' => 'fo2@koperasi.id'],
        ];

        foreach ($frontOffices as $index => $frontOffice) {
            $i = $index + 1;
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $frontOffice['name'],
                'email' => $frontOffice['email'],
                'phone' => '0812' . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::Fo->value,
                'status' => UserStatus::Active->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        for ($i = 3; $i <= 8; $i++) {
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $faker->name(),
                'email' => "fo{$i}@koperasi.id",
                'phone' => '0812' . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::Fo->value,
                'status' => UserStatus::Active->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        // 2 Inactive
        for ($i = 9; $i <= 10; $i++) {
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $faker->name(),
                'email' => "fo{$i}@koperasi.id",
                'phone' => '0813' . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::Fo->value,
                'status' => UserStatus::Inactive->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 3. Members (88)
        // Two named demo accounts, followed by generated members.
        $members = [
            ['name' => 'Siti Aminah', 'email' => 'member1@koperasi.id'],
            ['name' => 'Budi Santoso', 'email' => 'member2@koperasi.id'],
        ];

        foreach ($members as $index => $member) {
            $i = $index + 1;
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $member['name'],
                'email' => $member['email'],
                'phone' => $faker->randomElement(['0852', '0853', '0821', '0822', '0878', '0896']) . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::Member->value,
                'status' => UserStatus::Active->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        for ($i = 3; $i <= 88; $i++) {
            $users[] = [
                'uuid' => (string) Str::uuid(),
                'name' => $faker->name(),
                'email' => "member{$i}@koperasi.id",
                'phone' => $faker->randomElement(['0852', '0853', '0821', '0822', '0878', '0896']) . $faker->numerify('########'),
                'password' => $password,
                'role' => UserRole::Member->value,
                'status' => UserStatus::Active->value,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($users);
    }
}
