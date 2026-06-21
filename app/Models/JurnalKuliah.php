<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalKuliah extends Model
{
    protected $table = 'jurnal_kuliah';
    protected $fillable = ['dosen_id', 'mata_kuliah', 'pertemuan', 'tanggal', 'materi_realisasi', 'catatan', 'status'];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
