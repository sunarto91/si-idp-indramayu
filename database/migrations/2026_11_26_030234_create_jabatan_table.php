
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 100)->unique();
            $table->string('nama', 255);

            $table->foreignId('kelompok_jabatan_id')
                ->nullable()
                ->constrained('kelompok_jabatan')
                ->restrictOnDelete();

            $table->foreignId('level_asesmen_id')
                ->nullable()
                ->constrained('level_asesmen')
                ->restrictOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
