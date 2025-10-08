<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEngineering
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            return redirect('/');
        }

        $user = auth()->user();

        if($user->departemen != 'Engineering') {
            return abort(403, 'Maaf Anda Tidak Memiliki Akses Ke Portal Ini');
        }

        if($user->role != 2) {
            return abort(403, 'Maaf Anda Tidak Memiliki Akses Ke Portal Ini');
        }
        return $next($request);
    }
}
