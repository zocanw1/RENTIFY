<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware untuk semua role staff (admin, ketua_tjkt, ketua_sija, wali_kelas)
class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isStaff()) {
            abort(403, 'Halaman ini hanya untuk staf sekolah.');
        }
        return $next($request);
    }
}
