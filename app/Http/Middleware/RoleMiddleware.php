<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memastikan pengguna memiliki salah satu role
     * yang diizinkan untuk mengakses halaman.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        // Pengguna harus sudah login.
        if (!$request->user()) {
            abort(401, 'Pengguna belum login.');
        }

        // Akun nonaktif tidak diperbolehkan mengakses fitur.
        if (!$request->user()->is_active) {
            abort(403, 'Akun pengguna tidak aktif.');
        }

        // Jika tidak ada role yang ditentukan,
        // akses ditolak demi keamanan.
        if (empty($roles)) {
            abort(403, 'Role akses belum dikonfigurasi.');
        }

        // Periksa apakah pengguna memiliki
        // setidaknya satu role yang diizinkan.
        $hasPermission = $request->user()
            ->roles()
            ->whereIn('kode', $roles)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        return $next($request);
    }
}
