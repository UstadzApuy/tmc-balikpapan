<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect ke /admin hanya jika mencoba akses halaman login/register
                if ($request->is('login') || $request->is('register')) {
                    return redirect('/admin');
                }
                // Jika di halaman lain (misalnya /), biarkan saja
                return $next($request);
            }
        }

        return $next($request);
    }
}