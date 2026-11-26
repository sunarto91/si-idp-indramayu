<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PangkatGolongan;

class PangkatGolonganSeeder extends Seeder
{
    public function run(): void
    {
        $pangkat = [
            ['I/a', 'Juru Muda'],
            ['I/b', 'Juru Muda Tingkat I'],
            ['I/c', 'Juru'],
            ['I/d', 'Juru Tingkat I'],

            ['II/a', 'Pengatur Muda'],
            ['II/b', 'Pengatur Muda Tingkat I'],
            ['II/c', 'Pengatur'],
            ['II/d', 'Pengatur Tingkat I'],

            ['III/a', 'Penata Muda'],
            ['III/b', 'Penata Muda Tingkat I'],
            ['III/c', 'Penata'],
            ['III/d', 'Penata Tingkat I'],

            ['IV/a', 'Pembina'],
            ['IV/b', 'Pembina Tingkat I'],
            ['IV/c', 'Pembina Utama Muda'],
            ['IV/d', 'Pembina Utama Madya'],
            ['IV/e', 'Pembina Utama'],
        ];

        foreach ($pangkat as $index => $item) {

            PangkatGolongan::updateOrCreate(
                [
                    'kode_golongan' => $item[0],
                ],
                [
                    'nama_pangkat' => $item[1],
                    'urutan' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
