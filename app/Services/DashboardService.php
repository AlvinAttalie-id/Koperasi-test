<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityLog;
use App\Models\MemberProfile;
use App\Models\User;

class DashboardService
{
    /**
     * Get statistics based on the user's role.
     *
     * @return array<string, mixed>
     */
    public function getStatsForUser(User $user): array
    {
        return match ($user->role) {
            UserRole::SuperAdmin => $this->getSuperAdminStats(),
            UserRole::Fo => $this->getFrontOfficeStats(),
            UserRole::Member => $this->getMemberStats($user),
        };
    }

    /**
     * Get statistics for Super Admin.
     *
     * @return array<string, mixed>
     */
    private function getSuperAdminStats(): array
    {
        return [
            'total_fo' => User::where('role', UserRole::Fo)->count(),
            'total_members' => User::where('role', UserRole::Member)->count(),
            'active_members' => User::where('role', UserRole::Member)->where('status', UserStatus::Active)->count(),
            'inactive_members' => User::where('role', UserRole::Member)->where('status', UserStatus::Inactive)->count(),
            'recent_activities' => ActivityLog::with('user')->latest()->take(5)->get(),
            'recent_front_offices' => User::where('role', UserRole::Fo)->latest()->take(5)->get(),
        ];
    }

    /**
     * Get statistics for Front Office.
     *
     * @return array<string, mixed>
     */
    private function getFrontOfficeStats(): array
    {
        return [
            'total_registered_members' => MemberProfile::count(),
            'latest_members' => MemberProfile::with(['user', 'province', 'city', 'district', 'village'])
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

    /**
     * Get profile summary for Member.
     *
     * @return array<string, mixed>
     */
    private function getMemberStats(User $user): array
    {
        $user->load(['memberProfile.province', 'memberProfile.city', 'memberProfile.district', 'memberProfile.village']);

        return [
            'user' => $user,
            'member_profile' => $user->memberProfile,
        ];
    }
}
