<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminPlant3
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

        if ($user->role !== 1) {
            return abort(403, 'Maaf Anda Tidak Memiliki Akses Ke Portal Ini');
        }

        if ($user->departemen !== 'Admin') {
            return abort(403, 'Maaf Anda Tidak Memiliki Akses Ke Portal Ini');
        }

        if ($user->email_verified_at === null) {
            return abort('403', 'Maaf akun anda belum diverifikasi, silahkan lakukan verifikasi terlebih dahulu');
        }

        if ($user->plant !== 'Plant 3') {
            return abort(403, 'Maaf Anda Tidak Memiliki Akses Ke Portal Ini');
        }

        return $next($request);
    }
}
