<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pns extends Model
{
    protected $table = 'pns';

    protected $fillable = [
        'nip',
        'nama',
        'pns_id_sumber',
        'jenis_kelamin',
        'tmt_cpns',
        'tmt_pns',
        'golongan',
        'status_kepegawaian',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tmt_cpns' => 'date',
            'tmt_pns' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Seluruh riwayat jabatan seorang PNS.
    public function riwayatJabatan(): HasMany
    {
        return $this->hasMany(
            RiwayatJabatanPns::class,
            'pns_id'
        );
    }

    // Riwayat jabatan yang ditandai aktif.
    public function jabatanAktif(): HasMany
    {
        return $this->riwayatJabatan()
            ->where('is_current', true);
    }

    // Seluruh riwayat pangkat seorang PNS.
    public function riwayatPangkat(): HasMany
    {
        return $this->hasMany(
            RiwayatPangkatPns::class,
            'pns_id'
        );
    }

    // Riwayat pangkat yang ditandai aktif.
    public function pangkatAktif(): HasMany
    {
        return $this->riwayatPangkat()
            ->where('is_current', true);
    }
}
