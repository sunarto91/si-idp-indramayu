<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemetaanLevelAsesmen extends Model
{
    // Nama tabel pemetaan.
    protected $table = 'pemetaan_level_asesmen';

    // Kolom yang dapat diisi.
    protected $fillable = [
        'kelompok_jabatan_id',
        'level_asesmen_id',
        'keterangan',
        'is_active',
    ];

    // Konversi tipe data.
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Setiap pemetaan milik satu kelompok jabatan.
    public function kelompokJabatan(): BelongsTo
    {
        return $this->belongsTo(
            KelompokJabatan::class,
            'kelompok_jabatan_id'
        );
    }

    // Setiap pemetaan mengarah pada satu level asesmen.
    public function levelAsesmen(): BelongsTo
    {
        return $this->belongsTo(
            LevelAsesmen::class,
            'level_asesmen_id'
        );
    }
}
