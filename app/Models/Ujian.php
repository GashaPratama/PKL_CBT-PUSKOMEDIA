<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujians'; // atau 'ujian' jika itu nama tabel kamu
    protected $primaryKey = 'id'; // atau 'id_ujian' jika pakai custom PK

    protected $fillable = [
        'nama',
        'tanggal',
        'deskripsi',
        'jumlah_peserta',
    ];

    public function soals()
    {
    return $this->hasMany(Soal::class);
    }
}
