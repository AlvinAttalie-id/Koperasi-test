<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class FrontOfficePolicy
{
    /**
     * Determine whether the user can view any FO users.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }

    /**
     * Determine whether the user can view a specific FO user.
     */
    public function view(User $user, User $foUser): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }

    /**
     * Determine whether the user can create FO users.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }

    /**
     * Determine whether the user can update the FO user.
     */
    public function update(User $user, User $foUser): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }

    /**
     * Determine whether the user can delete the FO user.
     */
    public function delete(User $user, User $foUser): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}
