<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Cek apakah role user ada di dalam daftar role yang diperbolehkan
        // $roles adalah array argument dari route, misal: ['admin', 'dokter']
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, return 403 Forbidden atau redirect
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}