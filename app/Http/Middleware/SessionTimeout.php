<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('superadmin')->check()) {
            if (session()->has('expires_at') && session('expires_at') < now()) {
                Auth::guard('superadmin')->logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('login-admin')->with('status_error', 'Session has expired. Please login again.');
            }
        }

        return $next($request);
    }
}
