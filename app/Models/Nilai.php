<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai'; 
    protected $fillable = [
        'user_id', 
        'mata_kuliah', 
        'nilai', 
        'nilai_presensi', 
        'nilai_keaktifan', 
        'nilai_tugas', 
        'nilai_uts', 
        'nilai_uas', 
        'total_nilai', 
        'akreditasi', 
        'grade'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}