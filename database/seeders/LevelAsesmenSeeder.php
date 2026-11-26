<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevelAsesmen;

class LevelAsesmenSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'level' => 1,
                'nama' => 'Level 1',
                'deskripsi' => 'Kompetensi dasar dan operasional.',
            ],
            [
                'level' => 2,
                'nama' => 'Level 2',
                'deskripsi' => 'Kompetensi pengawasan dan teknis lanjutan.',
            ],
            [
                'level' => 3,
                'nama' => 'Level 3',
                'deskripsi' => 'Kompetensi administrasi dan manajerial menengah.',
            ],
            [
                'level' => 4,
                'nama' => 'Level 4',
                'deskripsi' => 'Kompetensi kepemimpinan tingkat tinggi.',
            ],
            [
                'level' => 5,
                'nama' => 'Level 5',
                'deskripsi' => 'Kompetensi kepemimpinan strategis.',
            ],
        ];

        foreach ($levels as $item) {
            LevelAsesmen::updateOrCreate(
                ['level' => $item['level']],
                [
                    'nama' => $item['nama'],
                    'deskripsi' => $item['deskripsi'],
                    'is_active' => true,
                ]
            );
        }
    }
}
