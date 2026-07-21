<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * Accepts one or more role values (e.g., 'super_admin', 'fo', 'member').
     * Aborts with 403 if the authenticated user's role is not in the allowed list.
     *
     * Usage in routes: ->middleware('role:super_admin') or ->middleware('role:super_admin,fo')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Unauthorized.');
        }

        $userRoleValue = $user->role instanceof \UnitEnum ? $user->role->value : (string) $user->role;

        if (! in_array($userRoleValue, $roles, true)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
