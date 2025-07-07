<?php

// app/Models/Admin.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins'; // atau sesuaikan jika nama tabelnya berbeda
    protected $fillable = ['nama', 'email', 'foto'];
}

