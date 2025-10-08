<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsMarketing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = auth()->user();

        if ($user->departemen != 'Marketing') {
            return abort(403, 'Maaf Anda tidak memiliki hak untuk akses portal ini');
        }

        if ($user->role != 5) {
            return abort(403, 'Maaf Anda tidak memiliki hak untuk akses portal ini');
        }

        return $next($request);
    }
}
