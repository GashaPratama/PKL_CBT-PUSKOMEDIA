<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RombonganBelajar;
use App\Models\Kelas;

class RombelController extends Controller
{
    public function index()
    {
        $rombels = RombonganBelajar::with('kelas')->get();
        $kelas = Kelas::all();
        return view('admin.rombel.index', compact('rombels', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_kelompok' => 'required|string|max:10',
        ]);

        RombonganBelajar::create([
            'kelas_id' => $request->kelas_id,
            'nama_kelompok' => $request->nama_kelompok,
        ]);

        return redirect()->back()->with('success', 'Kelompok belajar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        RombonganBelajar::destroy($id);
        return redirect()->back()->with('success', 'Kelompok belajar berhasil dihapus.');
    }
}
