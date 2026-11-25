<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Relasi ke master PNS (dibuat pada tahap berikutnya)
            $table->unsignedBigInteger('pns_id')
                ->nullable();

            // Setiap PNS hanya boleh memiliki satu akun
            $table->unique('pns_id');

            // Status akun pengguna
            $table->boolean('is_active')
                ->default(true);

            // Waktu login terakhir
            $table->timestamp('last_login_at')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropUnique(['pns_id']);

            $table->dropColumn([
                'pns_id',
                'is_active',
                'last_login_at',
            ]);

        });
    }
};
