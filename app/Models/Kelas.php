<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = ['nama_kelas'];

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
}
