<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GatePPICPlant2
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

        if ($user->role !== 3) {

            Auth::logout();
            return abort(403, 'Maaf anda tidak memiliki akses ke portal ini');
        }

        if ($user->email_verified_at === null) {
            return abort('403', 'Maaf akun anda belum diverifikasi, silahkan lakukan verifikasi terlebih dahulu');
        }

        if ($user->departemen !== 'PPIC') {

            Auth::logout();
            return abort(403, 'Maaf anda tidak memiliki akses ke portal ini');
        }

        if ($user->plant !== 'Plant 2') {

            Auth::logout();
            return abort(403, 'Maaf anda tidak memiliki akses ke portal ini');
        }

        return $next($request);
    }
}
