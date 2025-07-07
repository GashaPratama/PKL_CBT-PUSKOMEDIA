<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // nama tabel (jika bukan 'users')
    protected $primaryKey = 'id_user'; // ini yang penting

    public $timestamps = false; // karena kolom created_at & updated_at NULL

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telpon',
        'jenis_kelamin',
        'role',
    ];
}
