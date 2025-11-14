<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // MEMERIKSA ROLE USER
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // CEK JIKA USER SUDAH LOGIN
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // CEK ROLE USER, JIKA TIDAK SESUAI MAKA ABORT 403
        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
