<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujians'; // ✅ pakai nama tabel yang sesuai database
    protected $primaryKey = 'id'; // atau sesuaikan jika nama kolom PK lain

    protected $fillable = [
        'nama',
        'tanggal',
        'deskripsi',
        'jumlah_peserta',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function soals()
    {
        return $this->hasMany(Soal::class, 'ujian_id', 'id'); // pastikan foreign key cocok
    }

    public function hasilUjian()
    {
    return $this->hasMany(HasilUjian::class, 'ujian_id');
    }
    

}
