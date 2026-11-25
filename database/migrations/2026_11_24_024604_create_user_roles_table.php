<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();

            // Relasi ke akun pengguna Laravel
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Relasi ke master role
            $table->foreignId('role_id')
                ->constrained('roles')
                ->restrictOnDelete();

            // Mencegah role yang sama diberikan dua kali
            $table->unique(['user_id', 'role_id']);

            // Waktu role diberikan kepada pengguna
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
