<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session('role') !== $role) {
            if (session('role') === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
            }
            if (session('role') === 'siswa') {
                return redirect()->route('siswa.dashboard')->with('error', 'Akses ditolak.');
            }
            return redirect()->route('login')->with('error', 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
