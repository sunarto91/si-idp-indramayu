<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PangkatGolongan extends Model
{
    // Nama tabel dalam database.
    protected $table = 'pangkat_golongan';

    // Kolom yang boleh diisi melalui Eloquent.
    protected $fillable = [
        'kode_golongan',
        'nama_pangkat',
        'urutan',
        'is_active',
    ];

    // Konversi tipe data.
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Satu pangkat/golongan dapat dimiliki banyak
    // catatan riwayat kepangkatan PNS.
    public function riwayatPangkat(): HasMany
    {
        return $this->hasMany(
            RiwayatPangkatPns::class,
            'pangkat_golongan_id'
        );
    }
}
