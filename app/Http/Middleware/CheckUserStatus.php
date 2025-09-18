<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Jika status pending, logout dan redirect dengan pesan
            if ($user->status === 'pending') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda sedang menunggu verifikasi admin. Silahkan tunggu hingga akun Anda diverifikasi.');
            }
            
            // Jika status rejected, logout dan redirect dengan pesan
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda ditolak. Silahkan hubungi administrator untuk informasi lebih lanjut.');
            }
            
            // Jika status bukan 'approved', logout
            if ($user->status !== 'verified') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Status akun tidak valid. Silahkan hubungi administrator.');
            }
        }

        return $next($request);
    }
}