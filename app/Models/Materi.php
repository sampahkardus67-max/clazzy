<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    protected $fillable = ['judul', 'mata_kuliah', 'pertemuan', 'deskripsi', 'file_path'];
}
