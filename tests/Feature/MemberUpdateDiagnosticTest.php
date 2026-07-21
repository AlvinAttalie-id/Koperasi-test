<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MemberProfile;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberUpdateDiagnosticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the MemberService::updateMember method directly.
     */
    public function test_service_update_member_persists_name_change(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $profile = MemberProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        $service = app(MemberService::class);

        $updated = $service->updateMember($profile, [
            'name' => 'Updated Name',
            'phone' => $user->phone,
            'gender' => Gender::Male->value,
            'birth_place' => $profile->birth_place,
            'birth_date' => $profile->birth_date->format('Y-m-d'),
            'address' => 'New Address 123',
            'province_id' => $profile->province_id,
            'city_id' => $profile->city_id,
            'district_id' => $profile->district_id,
            'village_id' => $profile->village_id,
            'occupation' => 'New Occupation',
        ]);

        $freshUser = $user->fresh();
        $this->assertEquals('Updated Name', $freshUser->name, 'User name should be updated in DB');

        $freshProfile = $profile->fresh();
        $this->assertEquals('New Address 123', $freshProfile->address, 'Profile address should be updated in DB');
        $this->assertEquals('New Occupation', $freshProfile->occupation, 'Profile occupation should be updated in DB');
    }

    /**
     * Test the profile self-update HTTP flow with all required fields.
     */
    public function test_profile_self_update_http_flow(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $profile = MemberProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'HTTP Updated Name',
            'phone' => $user->phone,
            'gender' => Gender::Male->value,
            'birth_place' => $profile->birth_place,
            'birth_date' => $profile->birth_date->format('Y-m-d'),
            'address' => 'HTTP New Address',
            'province_id' => $profile->province_id,
            'city_id' => $profile->city_id,
            'district_id' => $profile->district_id,
            'village_id' => $profile->village_id,
            'occupation' => 'HTTP Occupation',
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('success');

        $freshUser = $user->fresh();
        $this->assertEquals('HTTP Updated Name', $freshUser->name, 'User name should be updated via HTTP PUT /profile');

        $freshProfile = $profile->fresh();
        $this->assertEquals('HTTP New Address', $freshProfile->address, 'Profile address should be updated via HTTP PUT /profile');
        $this->assertEquals('HTTP Occupation', $freshProfile->occupation, 'Profile occupation should be updated via HTTP PUT /profile');
    }

    /**
     * BUG REPRODUCTION: This test proves the profile edit form FAILS because
     * gender and birth_place/birth_date fields are missing from the form.
     * The UpdateProfileRequest requires them, so validation silently rejects
     * the submission and redirects back with errors — but the form has no
     * error display for these fields, so it looks like a "successful" no-op.
     */
    public function test_profile_update_fails_without_gender_and_birth_fields(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $profile = MemberProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        // Submit exactly what the current profile edit form submits
        // (NO gender, NO birth_place, NO birth_date — because the form doesn't have them)
        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Should Not Save',
            'phone' => $user->phone,
            'occupation' => 'Should Not Save',
            'address' => 'Should Not Save',
            'province_id' => $profile->province_id,
            'city_id' => $profile->city_id,
            'district_id' => $profile->district_id,
            'village_id' => $profile->village_id,
        ]);

        // The form redirects back (NOT to profile.show) because of validation errors
        $response->assertRedirect();
        $response->assertSessionHasErrors(['gender', 'birth_place', 'birth_date']);

        // Name is NOT updated because the request was rejected
        $freshUser = $user->fresh();
        $this->assertEquals('Original Name', $freshUser->name, 'Name should NOT have changed — validation failed');
    }

    /**
     * Test the member edit HTTP flow (staff editing a member).
     */
    public function test_staff_member_update_http_flow(): void
    {
        $fo = User::factory()->create([
            'role' => UserRole::Fo,
            'status' => UserStatus::Active,
        ]);

        $memberUser = User::factory()->create([
            'name' => 'Member Original',
            'role' => UserRole::Member,
            'status' => UserStatus::Active,
        ]);

        $profile = MemberProfile::factory()->create([
            'user_id' => $memberUser->id,
        ]);

        $response = $this->actingAs($fo)->put("/members/{$profile->uuid}", [
            'name' => 'Staff Updated Name',
            'email' => $memberUser->email,
            'phone' => $memberUser->phone,
            'nik' => $profile->nik,
            'gender' => Gender::Male->value,
            'birth_place' => $profile->birth_place,
            'birth_date' => $profile->birth_date->format('Y-m-d'),
            'address' => 'Staff New Address',
            'province_id' => $profile->province_id,
            'city_id' => $profile->city_id,
            'district_id' => $profile->district_id,
            'village_id' => $profile->village_id,
            'occupation' => 'Staff Occupation',
            'register_date' => $profile->register_date->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('members.index'));
        $response->assertSessionHas('success');

        $freshUser = $memberUser->fresh();
        $this->assertEquals('Staff Updated Name', $freshUser->name, 'User name should be updated via staff edit');

        $freshProfile = $profile->fresh();
        $this->assertEquals('Staff New Address', $freshProfile->address, 'Profile address should be updated via staff edit');
        $this->assertEquals('Staff Occupation', $freshProfile->occupation, 'Profile occupation should be updated via staff edit');
    }
}
