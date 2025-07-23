<?php

namespace App\Imports;

use App\Models\User;
use App\Models\RombonganBelajar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Cari rombel berdasarkan nama kelas dan kelompok
            $rombel = RombonganBelajar::whereHas('kelas', function ($q) use ($row) {
                $q->where('nama_kelas', $row['kelas']);
            })->where('nama_kelompok', $row['kelompok'])->first();

            if ($rombel) {
                User::create([
                    'nama_lengkap'         => $row['nama_lengkap'],
                    'email'                => $row['email'],
                    'password'             => Hash::make($row['password']),
                    'no_telpon'            => $row['no_telpon'],
                    'jenis_kelamin'        => $row['jenis_kelamin'],
                    'rombongan_belajar_id' => $rombel->id,
                    'role'                 => $row['role'] ?? 'siswa',
                ]);
            }
        }
    }
}
