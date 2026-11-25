<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'kode' => 'super_admin',
                'nama' => 'Super Admin',
                'deskripsi' => 'Mengelola akun, peran, konfigurasi, dan audit sistem.',
            ],
            [
                'kode' => 'operator',
                'nama' => 'Operator SI-IDP',
                'deskripsi' => 'Mengelola data master, impor data, dan administrasi SI-IDP.',
            ],
            [
                'kode' => 'pns',
                'nama' => 'PNS',
                'deskripsi' => 'Melihat data diri dan menyusun IDP masing-masing.',
            ],
            [
                'kode' => 'atasan_langsung',
                'nama' => 'Atasan Langsung',
                'deskripsi' => 'Melakukan reviu IDP bawahan sesuai kewenangan.',
            ],
            [
                'kode' => 'kepala_bidang',
                'nama' => 'Kepala Bidang Pengembangan Kompetensi Aparatur',
                'deskripsi' => 'Melakukan verifikasi dan konsolidasi kebutuhan pengembangan kompetensi.',
            ],
            [
                'kode' => 'kepala_bkpsdm',
                'nama' => 'Kepala BKPSDM',
                'deskripsi' => 'Memantau dan menyetujui dokumen sesuai kewenangan yang ditetapkan.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['kode' => $role['kode']],
                [
                    'nama' => $role['nama'],
                    'deskripsi' => $role['deskripsi'],
                ]
            );
        }
    }
}
