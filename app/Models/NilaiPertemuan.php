<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiPertemuan extends Model
{
    protected $table = 'nilai_pertemuan';
    protected $fillable = ['user_id', 'mata_kuliah', 'pertemuan', 'nilai_keaktifan', 'nilai_tugas'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
