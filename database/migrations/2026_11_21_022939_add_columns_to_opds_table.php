
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->string('kode_opd', 30)->unique();
            $table->string('nama_opd', 255);
            $table->string('singkatan', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropUnique(['kode_opd']);

            $table->dropColumn([
                'kode_opd',
                'nama_opd',
                'singkatan',
                'alamat',
                'is_active',
            ]);
        });
    }
};
