<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class UserImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift(); // Skip header

        foreach ($rows as $row) {
         if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[4]) && !empty($row[5])) {
        User::create([
            'nama_lengkap' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'no_telpon' => $row[3] ?? null,
            'jenis_kelamin' => $row[4],
            'role' => $row[5],
        ]);
    }
}

    }
}
