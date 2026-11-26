<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelompokJabatan;
use App\Models\LevelAsesmen;
use App\Models\PemetaanLevelAsesmen;

class PemetaanLevelAsesmenSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar level untuk setiap kelompok jabatan.
        $pemetaan = [
            'PELAKSANA'     => [1],
            'PENGAWAS'      => [2],
            'ADMINISTRATOR' => [3],
            'JPT'           => [4, 5],
            'JF_TERAMPIL'   => [1],
            'JF_MAHIR'      => [1, 2],
            'JF_PENYELIA'   => [2],
            'JF_PERTAMA'    => [2],
            'JF_MUDA'       => [3],
            'JF_MADYA'      => [4],
            'JF_UTAMA'      => [5],
        ];

        foreach ($pemetaan as $kode => $levels) {

            // Cari kelompok berdasarkan kode unik.
            // Jika tidak ada, hentikan Seeder.
            $kelompok = KelompokJabatan::where(
                'kode',
                $kode
            )->firstOrFail();

            foreach ($levels as $nomorLevel) {

                // Cari level asesmen berdasarkan angka.
                $level = LevelAsesmen::where(
                    'level',
                    $nomorLevel
                )->firstOrFail();

                // Simpan atau perbarui pasangan kelompok-level.
                PemetaanLevelAsesmen::updateOrCreate(
                    [
                        'kelompok_jabatan_id' => $kelompok->id,
                        'level_asesmen_id' => $level->id,
                    ],
                    [
                        'keterangan' =>
                            'Pemetaan awal berdasarkan rancangan SI-IDP.',
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
