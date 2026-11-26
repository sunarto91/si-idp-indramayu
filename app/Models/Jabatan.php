<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'kode',
        'nama',
        'kelompok_jabatan_id',
        'level_asesmen_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Jabatan termasuk dalam satu kelompok jabatan.
    public function kelompokJabatan(): BelongsTo
    {
        return $this->belongsTo(
            KelompokJabatan::class,
            'kelompok_jabatan_id'
        );
    }

    // Jabatan mempunyai level asesmen tertentu.
    public function levelAsesmen(): BelongsTo
    {
        return $this->belongsTo(
            LevelAsesmen::class,
            'level_asesmen_id'
        );
    }

    // Jabatan dapat tercatat dalam banyak riwayat PNS.
    public function riwayatJabatan(): HasMany
    {
        return $this->hasMany(
            RiwayatJabatanPns::class,
            'jabatan_id'
        );
    }
}
