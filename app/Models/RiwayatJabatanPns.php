<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatJabatanPns extends Model
{
    // Nama tabel di database.
    protected $table = 'riwayat_jabatan_pns';

    // Kolom yang diperbolehkan diisi.
    protected $fillable = [
        'pns_id',
        'jabatan_id',
        'kelompok_jabatan_id',
        'level_asesmen_id',
        'opd_id',
        'tmt_jabatan',
        'tanggal_selesai',
        'nomor_sk',
        'tanggal_sk',
        'jenis_perubahan',
        'sumber_data',
        'tanggal_impor',
        'status_verifikasi',
        'is_current',
        'keterangan',
    ];

    // Konversi tipe data.
    protected function casts(): array
    {
        return [
            'tmt_jabatan' => 'date',
            'tanggal_selesai' => 'date',
            'tanggal_sk' => 'date',
            'tanggal_impor' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    // Riwayat ini milik satu PNS.
    public function pns(): BelongsTo
    {
        return $this->belongsTo(
            Pns::class,
            'pns_id'
        );
    }

    // Jabatan yang pernah diduduki.
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(
            Jabatan::class,
            'jabatan_id'
        );
    }

    // Kelompok jabatan pada periode tersebut.
    public function kelompokJabatan(): BelongsTo
    {
        return $this->belongsTo(
            KelompokJabatan::class,
            'kelompok_jabatan_id'
        );
    }

    // Level asesmen pada periode tersebut.
    public function levelAsesmen(): BelongsTo
    {
        return $this->belongsTo(
            LevelAsesmen::class,
            'level_asesmen_id'
        );
    }

    // OPD tempat PNS bertugas.
    public function opd(): BelongsTo
    {
        return $this->belongsTo(
            Opd::class,
            'opd_id'
        );
    }
}
