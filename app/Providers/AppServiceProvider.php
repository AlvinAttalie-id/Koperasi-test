<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\MemberProfile;
use App\Models\User;
use App\Policies\FrontOfficePolicy;
use App\Policies\MemberPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Explicitly register policies
        Gate::policy(MemberProfile::class, MemberPolicy::class);
        Gate::policy(User::class, FrontOfficePolicy::class);

        // Super Admin bypasses all policy checks
        Gate::before(function ($user, $ability) {
            if ($user->role === UserRole::SuperAdmin) {
                return true;
            }
        });
    }
}
