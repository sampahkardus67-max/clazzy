<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('mata_kuliah');
            $table->decimal('nilai', 5, 2)->nullable(); // Total score compatible
            $table->decimal('nilai_presensi', 5, 2)->nullable();
            $table->decimal('nilai_keaktifan', 5, 2)->nullable();
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('total_nilai', 5, 2)->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
