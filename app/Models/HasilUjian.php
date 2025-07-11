<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    protected $table = 'hasil_ujian';

    protected $fillable = [
        'ujian_id',
        'user_id',
        'nilai',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id_user');
}
}
