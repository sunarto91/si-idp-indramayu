<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_jabatan_pns', function (Blueprint $table) {
            $table->id();

            // Relasi PNS.
            $table->foreignId('pns_id')
                ->constrained('pns')
                ->restrictOnDelete();

            // Jabatan pada periode ini.
            $table->foreignId('jabatan_id')
                ->constrained('jabatan')
                ->restrictOnDelete();

            // Kelompok jabatan saat itu.
            $table->foreignId('kelompok_jabatan_id')
                ->constrained('kelompok_jabatan')
                ->restrictOnDelete();

            // Level asesmen yang berlaku saat itu.
            $table->foreignId('level_asesmen_id')
                ->nullable()
                ->constrained('level_asesmen')
                ->restrictOnDelete();

            // OPD pada periode jabatan tersebut.
            $table->foreignId('opd_id')
                ->constrained('opds')
                ->restrictOnDelete();

            // Tanggal periode jabatan.
            $table->date('tmt_jabatan')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // Dasar keputusan pengangkatan.
            $table->string('nomor_sk', 150)->nullable();
            $table->date('tanggal_sk')->nullable();

            // Contoh: impor_awal, promosi, mutasi, rotasi.
            $table->string('jenis_perubahan', 30)
                ->default('impor_awal');

            // Asal data.
            $table->string('sumber_data', 50)
                ->default('import_excel');

            $table->timestamp('tanggal_impor')->nullable();

            // Status pemeriksaan riwayat.
            $table->string('status_verifikasi', 30)
                ->default('belum_diverifikasi');

            // Penanda jabatan utama saat ini.
            $table->boolean('is_current')->default(false);

            // Catatan tambahan.
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Mempercepat pencarian riwayat jabatan PNS.
            $table->index(
                ['pns_id', 'tmt_jabatan'],
                'idx_riwayat_pns_tmt'
            );

            $table->index(
                ['pns_id', 'is_current'],
                'idx_riwayat_pns_current'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan_pns');
    }
};