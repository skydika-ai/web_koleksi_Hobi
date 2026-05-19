<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN punya role admin
        if (!$request->user() || !$request->user()->isAdmin()) {
            // Kalau bukan admin → tolak dan kembalikan ke dashboard
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
            // ↑ abort(403) = HTTP Forbidden, user akan lihat halaman error
        }

        return $next($request);
        // ↑ kalau admin → lanjutkan request ke controller
    }
}