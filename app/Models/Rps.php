<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    protected $table = 'rps';
    protected $fillable = ['mata_kuliah', 'pertemuan', 'topik', 'aktivitas'];
}
