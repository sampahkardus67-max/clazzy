<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $fillable = ['user_id', 'mata_kuliah', 'pertemuan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
