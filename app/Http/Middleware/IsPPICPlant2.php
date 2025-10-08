<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsPPICPlant2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {

            return back('/');
        }

        $user = auth()->user();

        if ($user->role !== 3) {

            return abort(403, 'Maaf anda tidak memiliki akses ke portal ini');
        }

        if ($user->email_verified_at === null) {
            return abort('403', 'Maaf akun anda belum diverifikasi, silahkan lakukan verifikasi terlebih dahulu');
        }

        if ($user->departemen !== 'PPIC') {
            return abort(403, 'Maaf anda tidak memiliki akses ke portal ini');
        }

        return $next($request);
    }
}
