<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel referensi pangkat dan golongan.
     */
    public function up(): void
    {
        Schema::create('pangkat_golongan', function (Blueprint $table) {

            // Primary key.
            $table->id();

            // Kode golongan ruang, contoh III/a.
            // Tidak boleh ada kode yang sama.
            $table->string('kode_golongan', 10)->unique();

            // Nama pangkat, contoh Penata Muda.
            $table->string('nama_pangkat', 100);

            // Urutan jenjang pangkat/golongan.
            $table->unsignedSmallInteger('urutan')->unique();

            // Status aktif referensi.
            $table->boolean('is_active')->default(true);

            // Waktu pencatatan data.
            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangkat_golongan');
    }
};
