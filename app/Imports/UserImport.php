<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Kelas;
use App\Models\RombonganBelajar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift(); // skip header

        foreach ($rows as $row) {
            // Kolom: [0] nama, [1] email, [2] password, [3] no telpon, [4] jenis kelamin, [5] role, [6] kelas, [7] kelompok

            if (
                !empty($row[0]) && !empty($row[1]) && !empty($row[2]) &&
                !empty($row[4]) && !empty($row[5]) &&
                !empty($row[6]) && !empty($row[7])
            ) {
                // Cari kelas
                $kelas = Kelas::where('nama', $row[6])->first();

                // Cari rombongan belajar dari kelas + kelompok
                $rombel = null;
                if ($kelas) {
                    $rombel = RombonganBelajar::where('kelas_id', $kelas->id)
                                ->where('nama_kelompok', $row[7])
                                ->first();
                }

                if ($rombel) {
                    User::create([
                        'nama_lengkap'         => $row[0],
                        'email'                => $row[1],
                        'password'             => Hash::make($row[2]),
                        'no_telpon'            => $row[3] ?? null,
                        'jenis_kelamin'        => $row[4],
                        'role'                 => $row[5],
                        'rombongan_belajar_id' => $rombel->id,
                    ]);
                }
            }
        }
    }
}
