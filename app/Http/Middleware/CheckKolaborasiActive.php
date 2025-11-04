<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\KolaborasiIde;
use Illuminate\Http\Request;

class CheckKolaborasiActive
{
    public function handle(Request $request, Closure $next)
    {
        $kolaborasiId = $request->route('kolaborasi_id') ?? $request->route('id') ?? $request->route('kolaborasi');

        if (!$kolaborasiId) {
            return abort(404, 'Kolaborasi not found.');
        }

        $kolaborasi = KolaborasiIde::find($kolaborasiId);

        if (!$kolaborasi) {
            return abort(404, 'Kolaborasi tidak ditemukan.');
        }

        if (!$kolaborasi->is_active) {
            return redirect()->route('kolaborasi.ide.show', $kolaborasi->id)
                ->with('error', 'Kolaborasi belum aktif. Tunggu sampai tim mencapai minimal anggota.');
        }

        // attach kolaborasi to request for controllers that might need it
        $request->attributes->set('kolaborasi', $kolaborasi);

        return $next($request);
    }
}
