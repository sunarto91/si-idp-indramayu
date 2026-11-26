<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel kelompok jabatan.
     */
    public function up(): void
    {
        Schema::create('kelompok_jabatan', function (Blueprint $table) {

            $table->id();

            // Kode unik kelompok jabatan.
            $table->string('kode', 30)->unique();

            // Nama kelompok jabatan.
            $table->string('nama', 100);

            // Informasi tambahan.
            $table->text('deskripsi')->nullable();

            // Status kelompok jabatan.
            $table->boolean('is_active')->default(true);

            // Waktu pembuatan dan pembaruan.
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel ketika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_jabatan');
    }
};
