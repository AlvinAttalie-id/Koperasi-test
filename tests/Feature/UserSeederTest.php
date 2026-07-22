<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_documented_demo_accounts_are_seeded_with_their_documented_credentials(): void
    {
        app(UserSeeder::class)->run();

        $accounts = [
            ['name' => 'Ahmad Fauzan', 'email' => 'superadmin@koperasi.id', 'role' => UserRole::SuperAdmin],
            ['name' => 'Dimas Saputra', 'email' => 'admin2@koperasi.id', 'role' => UserRole::SuperAdmin],
            ['name' => 'Rini Wati', 'email' => 'fo1@koperasi.id', 'role' => UserRole::Fo],
            ['name' => 'Bagus Pratama', 'email' => 'fo2@koperasi.id', 'role' => UserRole::Fo],
            ['name' => 'Siti Aminah', 'email' => 'member1@koperasi.id', 'role' => UserRole::Member],
            ['name' => 'Budi Santoso', 'email' => 'member2@koperasi.id', 'role' => UserRole::Member],
        ];

        foreach ($accounts as $account) {
            $user = User::where('email', $account['email'])->firstOrFail();

            $this->assertSame($account['name'], $user->name);
            $this->assertSame($account['role'], $user->role);
            $this->assertTrue(Hash::check('password123', $user->password));
        }
    }
}
