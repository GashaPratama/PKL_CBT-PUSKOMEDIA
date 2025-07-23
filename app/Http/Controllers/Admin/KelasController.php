<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::all();
        return view('admin.kelas.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas, 
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan.');
    }



    public function destroy($id)
    {
        Kelas::destroy($id);
        return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
    }
}
