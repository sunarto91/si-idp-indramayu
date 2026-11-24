<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel master role SI-IDP.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            // Kode unik peran
            $table->string('kode', 50)->unique();

            // Nama peran
            $table->string('nama', 100);

            // Penjelasan kewenangan
            $table->text('deskripsi')->nullable();

            // Waktu pembuatan dan perubahan
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
