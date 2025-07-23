<?php

namespace App\Imports;

use App\Models\Soal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToModel, WithHeadingRow
{
    protected $ujian_id;

    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
    }

    public function model(array $row)
    {
        return new Soal([
            'ujian_id'       => $this->ujian_id,
            'pertanyaan'     => $row['pertanyaan'] ?? '-',
            'opsi_a'         => $row['opsi_a'] ?? null,
            'opsi_b'         => $row['opsi_b'] ?? null,
            'opsi_c'         => $row['opsi_c'] ?? null,
            'opsi_d'         => $row['opsi_d'] ?? null,
            'opsi_e'         => $row['opsi_e'] ?? null,
            'opsi_f'         => $row['opsi_f'] ?? null,
            'jawaban_benar'  => strtolower($row['jawaban_benar'] ?? 'a'),
            'gambar'         => $row['gambar'] ?? null,
        ]);
    }
}
