<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemetaan_level_asesmen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelompok_jabatan_id')
                ->constrained('kelompok_jabatan')
                ->restrictOnDelete();

            $table->foreignId('level_asesmen_id')
                ->constrained('level_asesmen')
                ->restrictOnDelete();

            $table->text('keterangan')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Mencegah pasangan kelompok dan level yang sama
            // dicatat lebih dari sekali.
            $table->unique(
                ['kelompok_jabatan_id', 'level_asesmen_id'],
                'unique_kelompok_level_asesmen'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemetaan_level_asesmen');
    }
};
