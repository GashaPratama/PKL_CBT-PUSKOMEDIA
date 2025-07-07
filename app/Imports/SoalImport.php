<?php
namespace App\Imports;

use App\Models\Soal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SoalImport implements ToCollection
{
    protected $ujianId;

    public function __construct($ujianId)
    {
        $this->ujianId = $ujianId;
    }

    public function collection(Collection $rows)
    {
        // Lewati baris header
        $rows->shift();

        foreach ($rows as $row) {
            Soal::create([
                'ujian_id'       => $this->ujianId,
                'pertanyaan'     => $row[0],
                'opsi_a'         => $row[1],
                'opsi_b'         => $row[2],
                'opsi_c'         => $row[3],
                'opsi_d'         => $row[4],
                'jawaban_benar'  => strtolower($row[5]),
            ]);
        }
    }
}
