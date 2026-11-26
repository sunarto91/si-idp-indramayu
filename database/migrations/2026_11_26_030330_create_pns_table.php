<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pns', function (Blueprint $table) {
            $table->id();

            // NIP disimpan sebagai teks agar tidak kehilangan digit.
            $table->string('nip', 18)->unique();

            $table->string('nama', 255);

            // Identitas dari sumber data kepegawaian.
            $table->string('pns_id_sumber', 100)
                ->nullable()
                ->unique();

            $table->string('jenis_kelamin', 20)->nullable();

            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_pns')->nullable();

            $table->string('golongan', 30)->nullable();

            $table->string('status_kepegawaian', 100)
                ->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pns');
    }
};
