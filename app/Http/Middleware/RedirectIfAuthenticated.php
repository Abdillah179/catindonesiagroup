<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $user = Auth::user();

                if ($user->role === 1) {
                    return redirect(RouteServiceProvider::ADMIN);
                } elseif ($user->role === 2) {
                    return redirect(RouteServiceProvider::PPICPLANT1);
                } elseif ($user->role === 3) {
                    return redirect(RouteServiceProvider::PPICPLANT2);
                } elseif ($user->role === 4) {
                    return redirect(RouteServiceProvider::PPICPLANT3);
                }
            }
        }

        return $next($request);
    }
}
