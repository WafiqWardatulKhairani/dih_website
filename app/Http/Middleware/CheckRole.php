<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('landing-page')
                             ->with('error', 'Akses ditolak! Anda tidak memiliki role yang sesuai.');
        }

        return $next($request);
    }
}
