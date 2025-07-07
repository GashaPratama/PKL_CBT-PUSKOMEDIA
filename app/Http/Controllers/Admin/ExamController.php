<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;

class ExamController extends Controller
{
    /**
     * Menampilkan form tambah ujian.
     */
    public function create()
    {
        return view('admin.ujian.create');
    }

    /**
     * Menyimpan data ujian baru dan soalnya ke database.
     */
    public function store(Request $request)
    {
        // Validasi utama ujian
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'jumlah_peserta' => 'required|integer|min:0',
        ]);

        // Validasi soal hanya jika ada input soal
        if ($request->has('soals')) {
            foreach ($request->soals as $index => $soal) {
                $request->validate([
                    "soals.$index.pertanyaan" => 'required|string',
                    "soals.$index.opsi_a" => 'required|string',
                    "soals.$index.opsi_b" => 'required|string',
                    "soals.$index.opsi_c" => 'required|string',
                    "soals.$index.opsi_d" => 'required|string',
                    "soals.$index.jawaban_benar" => 'required|in:a,b,c,d',
                ]);
            }
        }

        // Simpan data ujian
        $ujian = Ujian::create([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'jumlah_peserta' => $request->jumlah_peserta,
        ]);

        // Simpan soal-soal jika ada
        if ($request->has('soals') && is_array($request->soals)) {
            foreach ($request->soals as $soal) {
                $ujian->soals()->create($soal);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Ujian dan soal berhasil dibuat.');
    }

    /**
     * Menampilkan detail satu ujian.
     */
    public function show($id)
    {
        $exam = Ujian::findOrFail($id);
        return view('admin.ujian.detail', compact('exam'));

        $exam = Ujian::findOrFail($id);
        dd($exam);

    }

    /**
     * Menampilkan form edit ujian.
     */
    public function edit($id)
    {
        $exam = Ujian::findOrFail($id);
        return view('admin.ujian.edit', compact('exam'));
    }

    /**
     * Menyimpan perubahan data ujian.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'jumlah_peserta' => 'required|integer|min:0',
        ]);

        $exam = Ujian::findOrFail($id);
        $exam->update($request->only(['nama', 'tanggal', 'deskripsi', 'jumlah_peserta']));

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil diperbarui');
    }

    /**
     * Menghapus ujian dari database.
     */
    public function destroy($id)
    {
        $exam = Ujian::findOrFail($id);
        $exam->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil dihapus');
    }
}
