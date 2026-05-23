<?php

/**
 * IsAdmin Middleware
 * 
 * Middleware untuk membatasi akses hanya ke user dengan role 'admin'.
 * Jika bukan admin, redirect ke /beasiswa dengan pesan error.
 * 
 * @author  ProjectBNSP
 * @version 1.0
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Cek apakah user yang login memiliki role admin.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/beasiswa')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
