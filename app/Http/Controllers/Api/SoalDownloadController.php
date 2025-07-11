<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ujian;

class SoalDownloadController extends Controller
{
    public function getSoal($id)
    {
    $ujian = Ujian::with('soals')->findOrFail($id);

    return response()->json([
        'ujian' => [
            'id' => $ujian->id,
            'nama' => $ujian->nama,
            'durasi' => $ujian->durasi,
            'jadwal_mulai' => $ujian->waktu_mulai,
        ],
        'soal' => $ujian->soals->map(function($soal) {
            return [
                'id' => $soal->id,
                'pertanyaan' => $soal->pertanyaan,
                'opsi_a' => $soal->opsi_a,
                'opsi_b' => $soal->opsi_b,
                'opsi_c' => $soal->opsi_c,
                'opsi_d' => $soal->opsi_d,
                'jawaban_benar' => $soal->jawaban_benar,
            ];
        }),
    ]);
    }

}
