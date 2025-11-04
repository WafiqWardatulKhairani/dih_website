<?php

namespace App\Services;

use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;

class KolaborasiService
{
    /**
     * Cek jumlah anggota aktif dan aktifkan kolaborasi jika >= 3
     */
    public function checkAndActivate(KolaborasiIde $kolaborasi)
    {
        $activeCount = $kolaborasi->members()->where('status', 'active')->count();

        if (!$kolaborasi->is_active && $activeCount >= 3) {
            $kolaborasi->update([
                'is_active' => true,
                'status' => 'active',
            ]);

            // return message untuk flash / log
            return [
                'activated' => true,
                'message' => 'Kolaborasi kini aktif. Semua fitur tugas, progress, dokumen telah dibuka.'
            ];
        }

        return [
            'activated' => false,
            'message' => null
        ];
    }
}
