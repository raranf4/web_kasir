<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Jika kasir/admin belum login, tendang ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // 2. Jika role user cocok (admin/user), ijinkan masuk ke halaman
        if (in_array($user->role->nama_role, $roles)) {
            return $next($request);
        }

        // 3. Jika kasir coba-coba masuk ke halaman owner/admin, munculkan error 403
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}