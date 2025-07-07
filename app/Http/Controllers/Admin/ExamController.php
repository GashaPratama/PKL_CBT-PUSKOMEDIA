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

}
