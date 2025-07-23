<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RombonganBelajar extends Model
{
    use HasFactory;

    protected $table = 'rombongan_belajar';

    protected $fillable = ['kelas_id', 'nama_kelompok'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
