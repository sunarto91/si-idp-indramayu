<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelompokJabatan;

class KelompokJabatanSeeder extends Seeder
{
    public function run(): void
    {
        $kelompok = [
            [
                'kode' => 'PELAKSANA',
                'nama' => 'Jabatan Pelaksana',
                'deskripsi' => 'Kelompok jabatan pelaksana.',
            ],
            [
                'kode' => 'PENGAWAS',
                'nama' => 'Jabatan Pengawas',
                'deskripsi' => 'Kelompok jabatan pengawas.',
            ],
            [
                'kode' => 'ADMINISTRATOR',
                'nama' => 'Jabatan Administrator',
                'deskripsi' => 'Kelompok jabatan administrator.',
            ],
            [
                'kode' => 'JPT',
                'nama' => 'Jabatan Pimpinan Tinggi',
                'deskripsi' => 'Meliputi JPT Pratama, Madya, dan Utama.',
            ],
            [
                'kode' => 'JF_TERAMPIL',
                'nama' => 'JF Terampil',
                'deskripsi' => 'Jabatan Fungsional Keterampilan jenjang Terampil.',
            ],
            [
                'kode' => 'JF_MAHIR',
                'nama' => 'JF Mahir',
                'deskripsi' => 'Jabatan Fungsional Keterampilan jenjang Mahir.',
            ],
            [
                'kode' => 'JF_PENYELIA',
                'nama' => 'JF Penyelia',
                'deskripsi' => 'Jabatan Fungsional Keterampilan jenjang Penyelia.',
            ],
            [
                'kode' => 'JF_PERTAMA',
                'nama' => 'JF Ahli Pertama',
                'deskripsi' => 'Jabatan Fungsional Keahlian jenjang Ahli Pertama.',
            ],
            [
                'kode' => 'JF_MUDA',
                'nama' => 'JF Ahli Muda',
                'deskripsi' => 'Jabatan Fungsional Keahlian jenjang Ahli Muda.',
            ],
            [
                'kode' => 'JF_MADYA',
                'nama' => 'JF Ahli Madya',
                'deskripsi' => 'Jabatan Fungsional Keahlian jenjang Ahli Madya.',
            ],
            [
                'kode' => 'JF_UTAMA',
                'nama' => 'JF Ahli Utama',
                'deskripsi' => 'Jabatan Fungsional Keahlian jenjang Ahli Utama.',
            ],
        ];

        foreach ($kelompok as $item) {
            KelompokJabatan::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'deskripsi' => $item['deskripsi'],
                    'is_active' => true,
                ]
            );
        }
    }
}
