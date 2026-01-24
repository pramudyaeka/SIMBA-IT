<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user SUDAH login?
        if (!Auth::check()) {
            // Kalau BELUM, tendang ke login dengan pesan 'failed'
            return redirect()->route('login')->with('failed', 'Eits! Anda harus login dulu untuk mengakses halaman tersebut.');
        }

        // Kalau SUDAH, silakan lanjut
        return $next($request);
    }
}
