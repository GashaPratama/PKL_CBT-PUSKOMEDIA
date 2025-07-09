<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;

class ExamController extends Controller
{
    public function create()
    {
        return view('admin.ujian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'jumlah_peserta' => 'required|integer|min:0',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'jumlah_percobaan' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
        ]);

        Ujian::create([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'jumlah_peserta' => $request->jumlah_peserta,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'jumlah_percobaan' => $request->jumlah_percobaan,
            'durasi' => $request->durasi,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil dibuat.');
    }

    public function show($id)
    {
        $exam = Ujian::with('soals')->findOrFail($id);
        return view('admin.ujian.detail', compact('exam'));
    }

    public function edit($id)
    {
        $exam = Ujian::findOrFail($id);
        return view('admin.ujian.edit', compact('exam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'jumlah_peserta' => 'required|integer|min:0',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'jumlah_percobaan' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
        ]);

        $exam = Ujian::findOrFail($id);
        $exam->update($request->only([
            'nama', 'tanggal', 'deskripsi',
            'jumlah_peserta', 'waktu_mulai',
            'waktu_selesai', 'jumlah_percobaan',
            'durasi'
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $exam = Ujian::findOrFail($id);
        $exam->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil dihapus.');
    }

    public function nilai($id)
    {
    $exam = Ujian::with('hasilUjian.user')->findOrFail($id);

    return view('admin.ujian.nilai', compact('exam'));
    }

    public function simulasi($id)
    {
    $exam = Ujian::with('soals')->findOrFail($id);

    return view('admin.ujian.simulasi', compact('exam'));
    }

    public function submitSimulasi(Request $request, $id)
    {
    $exam = Ujian::with('soals')->findOrFail($id);
    $jawaban = $request->input('jawaban', []);

    $jumlahBenar = 0;
    $totalSoal = $exam->soals->count();
    $hasil = [];

    foreach ($exam->soals as $soal) {
        $idSoal = $soal->id;
        $jawabanUser = $jawaban[$idSoal] ?? null;
        $isCorrect = strtolower($jawabanUser) === strtolower($soal->jawaban_benar);

        if ($isCorrect) {
            $jumlahBenar++;
        }

        $hasil[] = [
            'pertanyaan'     => $soal->pertanyaan,
            'opsi_a'         => $soal->opsi_a,
            'opsi_b'         => $soal->opsi_b,
            'opsi_c'         => $soal->opsi_c,
            'opsi_d'         => $soal->opsi_d,
            'jawaban_benar'  => strtoupper($soal->jawaban_benar),
            'jawaban_user'   => strtoupper($jawabanUser),
            'benar'          => $isCorrect,
        ];
    }

    $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

    return view('admin.ujian.simulasi-hasil', [
        'exam'        => $exam,
        'hasil'       => $hasil,
        'jumlahBenar' => $jumlahBenar,
        'totalSoal'   => $totalSoal,
        'skor'        => $skor,
    ]);
    }
}
