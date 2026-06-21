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
        Schema::create('jurnal_kuliah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('mata_kuliah');
            $table->integer('pertemuan');
            $table->date('tanggal')->nullable();
            $table->text('materi_realisasi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('tunda'); // terlaksana, batal, tunda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_kuliah');
    }
};
