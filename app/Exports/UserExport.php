<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    public function collection()
    {
        return User::select('nama_lengkap', 'email', 'no_telpon', 'jenis_kelamin')->get();
    }
}
