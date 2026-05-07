<?php

namespace Nova\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        $allowed = [];
        foreach ($roles as $role) {
            foreach (explode('|', $role) as $r) {
                $allowed[] = trim($r);
            }
        }

        if (!$user || !in_array($user->role, $allowed)) {
            abort(403);
        }

        return $next($request);
    }
}