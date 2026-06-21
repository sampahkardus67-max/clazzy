<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasDosen extends Model
{
    protected $table = 'tugas_dosen';
    protected $fillable = ['judul', 'penjelasan', 'mata_kuliah', 'deadline', 'file_path'];
    protected $casts = ['deadline' => 'datetime'];
}