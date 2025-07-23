<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // nama tabel (jika bukan 'users')
    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telpon',
        'jenis_kelamin',
        'role',
        'rombongan_belajar_id', 
    ];

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class, 'rombongan_belajar_id');
    }
}
