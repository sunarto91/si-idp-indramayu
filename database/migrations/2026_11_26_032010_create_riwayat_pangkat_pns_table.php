<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pangkat_pns', function (Blueprint $table) {
            $table->id();

            // Relasi ke Master PNS.
            $table->foreignId('pns_id')
                ->constrained('pns')
                ->restrictOnDelete();

            // Referensi pangkat dan golongan.
            $table->foreignId('pangkat_golongan_id')
                ->constrained('pangkat_golongan')
                ->restrictOnDelete();

            // Periode kepangkatan.
            $table->date('tmt_pangkat')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // Dasar keputusan pangkat.
            $table->string('nomor_sk', 150)->nullable();
            $table->date('tanggal_sk')->nullable();

            // Jenis kenaikan atau perubahan pangkat.
            $table->string('jenis_kenaikan', 50)
                ->nullable();

            // Asal data kepangkatan.
            $table->string('sumber_data', 50)
                ->default('import_excel');

            // Waktu data masuk ke SI-IDP.
            $table->timestamp('tanggal_impor')->nullable();

            // Pemeriksaan keabsahan data.
            $table->string('status_verifikasi', 30)
                ->default('belum_diverifikasi');

            // Penanda pangkat/golongan saat ini.
            $table->boolean('is_current')
                ->default(false);

            // Catatan tambahan.
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Indeks pencarian riwayat.
            $table->index(
                ['pns_id', 'tmt_pangkat'],
                'idx_riwayat_pangkat_tmt'
            );

            $table->index(
                ['pns_id', 'is_current'],
                'idx_riwayat_pangkat_current'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pangkat_pns');
    }
};
