<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah'; // ← wajib karena nama tabelnya tidak standar
    protected $fillable = ['nama', 'kode', 'sks', 'dosen'];
}