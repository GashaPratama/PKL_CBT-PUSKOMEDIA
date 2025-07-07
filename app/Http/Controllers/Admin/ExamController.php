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
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'jumlah_peserta' => 'required|integer|min:0',
            'soals.*.pertanyaan' => 'required|string',
            'soals.*.opsi_a' => 'required|string',
            'soals.*.opsi_b' => 'required|string',
            'soals.*.opsi_c' => 'required|string',
            'soals.*.opsi_d' => 'required|string',
            'soals.*.jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        // Simpan ujian
        $ujian = Ujian::create([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'jumlah_peserta' => $request->jumlah_peserta,
        ]);

        // Simpan soal-soal
        foreach ($request->soals as $soal) {
            $ujian->soals()->create($soal);
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
