<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberFilteringTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_sort_members_by_newest_first(): void
    {
        $fo = User::factory()->create([
            'role' => UserRole::Fo,
            'status' => UserStatus::Active,
        ]);

        $m1 = MemberProfile::factory()->create(['created_at' => now()->subDays(2)]);
        $m2 = MemberProfile::factory()->create(['created_at' => now()->subDay()]);
        $m3 = MemberProfile::factory()->create(['created_at' => now()]);

        $response = $this->actingAs($fo)->get('/members?sort=newest');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $m3->user->name,
            $m2->user->name,
            $m1->user->name,
        ]);
    }

    public function test_staff_can_sort_members_by_oldest_first(): void
    {
        $fo = User::factory()->create([
            'role' => UserRole::Fo,
            'status' => UserStatus::Active,
        ]);

        $m1 = MemberProfile::factory()->create(['created_at' => now()->subDays(2)]);
        $m2 = MemberProfile::factory()->create(['created_at' => now()->subDay()]);
        $m3 = MemberProfile::factory()->create(['created_at' => now()]);

        $response = $this->actingAs($fo)->get('/members?sort=oldest');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $m1->user->name,
            $m2->user->name,
            $m3->user->name,
        ]);
    }
}
