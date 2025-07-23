<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'ujian_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'opsi_f',
        'jawaban_benar',
        'gambar', 
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
