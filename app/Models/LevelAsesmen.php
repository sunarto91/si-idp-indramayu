<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelAsesmen extends Model
{
    // Nama tabel di MySQL.
    protected $table = 'level_asesmen';

    // Kolom yang dapat diisi.
    protected $fillable = [
        'level',
        'nama',
        'deskripsi',
        'is_active',
    ];

    // Konversi tipe data.
    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Satu level dapat digunakan oleh banyak jabatan.
    public function jabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class);
    }

    // Satu level memiliki banyak pemetaan kelompok.
    public function pemetaanKelompok(): HasMany
    {
        return $this->hasMany(PemetaanLevelAsesmen::class);
    }

    // Satu level dapat tercatat pada banyak riwayat jabatan.
    public function riwayatJabatan(): HasMany
    {
        return $this->hasMany(RiwayatJabatanPns::class);
    }
}
