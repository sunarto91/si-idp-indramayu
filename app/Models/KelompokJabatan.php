<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokJabatan extends Model
{
    // Nama tabel menggunakan bentuk tunggal.
    protected $table = 'kelompok_jabatan';

    // Kolom yang diperbolehkan diisi.
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active',
    ];

    // Konversi tipe data.
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Satu kelompok dapat memiliki banyak jabatan.
    public function jabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class);
    }

    // Satu kelompok dapat muncul dalam banyak riwayat.
    public function riwayatJabatan(): HasMany
    {
        return $this->hasMany(RiwayatJabatanPns::class);
    }

    // Pemetaan kelompok dengan level asesmen.
    public function pemetaanLevel(): HasMany
    {
        return $this->hasMany(PemetaanLevelAsesmen::class);
    }
}
