<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\MemberProfile;
use App\Models\User;

class MemberPolicy
{
    /**
     * Determine whether the user can view any member profiles.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Fo], true);
    }

    /**
     * Determine whether the user can view the member profile.
     */
    public function view(User $user, MemberProfile $memberProfile): bool
    {
        if (in_array($user->role, [UserRole::SuperAdmin, UserRole::Fo], true)) {
            return true;
        }

        return $user->id === $memberProfile->user_id;
    }

    /**
     * Determine whether the user can create member profiles.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Fo], true);
    }

    /**
     * Determine whether the user can update the member profile.
     */
    public function update(User $user, MemberProfile $memberProfile): bool
    {
        if (in_array($user->role, [UserRole::SuperAdmin, UserRole::Fo], true)) {
            return true;
        }

        return $user->id === $memberProfile->user_id;
    }

    /**
     * Determine whether the user can delete the member profile.
     */
    public function delete(User $user, MemberProfile $memberProfile): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Fo], true);
    }
}
