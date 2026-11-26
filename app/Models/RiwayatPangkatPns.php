<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPangkatPns extends Model
{
    // Nama tabel di database.
    protected $table = 'riwayat_pangkat_pns';

    // Kolom yang boleh diisi melalui Eloquent.
    protected $fillable = [
        'pns_id',
        'pangkat_golongan_id',
        'tmt_pangkat',
        'tanggal_selesai',
        'nomor_sk',
        'tanggal_sk',
        'jenis_kenaikan',
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
            'tmt_pangkat' => 'date',
            'tanggal_selesai' => 'date',
            'tanggal_sk' => 'date',
            'tanggal_impor' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    // Setiap riwayat pangkat milik satu PNS.
    public function pns(): BelongsTo
    {
        return $this->belongsTo(
            Pns::class,
            'pns_id'
        );
    }

    // Setiap riwayat menggunakan satu pangkat/golongan.
    public function pangkatGolongan(): BelongsTo
    {
        return $this->belongsTo(
            PangkatGolongan::class,
            'pangkat_golongan_id'
        );
    }
}
