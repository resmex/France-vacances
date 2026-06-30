<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Usage in routes: ->middleware('role:owner')
     *                  ->middleware('role:owner,admin')
     *
     * Admins always pass through regardless of the declared roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Admins have universal access
        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->hasRole(...$roles)) {
            return $next($request);
        }

        return redirect()->route($user->dashboardRoute())
            ->with('error', 'You do not have permission to access that area.');
    }
}
