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
    Schema::create('tugas_dosen', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('penjelasan');
        $table->string('mata_kuliah');
        $table->datetime('deadline');
        $table->string('file_path')->nullable(); // file tugas dari dosen (opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_dosen');
    }
};
