<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_cannot_access_front_office_management(): void
    {
        $member = User::factory()->create([
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($member)->get('/front-offices');
        $response->assertStatus(403);
    }

    public function test_fo_cannot_access_front_office_management(): void
    {
        $fo = User::factory()->create([
            'role' => UserRole::Fo,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($fo)->get('/front-offices');
        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_front_office_management(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($admin)->get('/front-offices');
        $response->assertStatus(200);
    }

    public function test_member_cannot_access_members_management(): void
    {
        $member = User::factory()->create([
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($member)->get('/members');
        $response->assertStatus(403);
    }

    public function test_fo_can_access_members_management(): void
    {
        $fo = User::factory()->create([
            'role' => UserRole::Fo,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($fo)->get('/members');
        $response->assertStatus(200);
    }

    public function test_member_cannot_access_activity_logs(): void
    {
        $member = User::factory()->create([
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($member)->get('/activity-logs');
        $response->assertStatus(403);
    }

    public function test_unauthenticated_api_request_is_rejected(): void
    {
        $response = $this->getJson('/api/provinces');
        $response->assertStatus(401);
    }
}
