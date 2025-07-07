<?php

namespace App\Imports;

use App\Models\Soal;
use Illuminate\Support\Collection;
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
        if (empty($row['pertanyaan'])) {
            return null;
        }

        return new Soal([
            'ujian_id' => $this->ujian_id,
            'pertanyaan' => $row['pertanyaan'],
            'opsi_a' => $row['opsi_a'],
            'opsi_b' => $row['opsi_b'],
            'opsi_c' => $row['opsi_c'],
            'opsi_d' => $row['opsi_d'],
            'jawaban_benar' => strtolower($row['jawaban_benar']),
        ]);
    }
}
