<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarController extends Controller
{
    public function formUpload()
    {
        return view('admin.ujian.gambar');
    }

    public function uploadGambar(Request $request)
    {
        $request->validate([
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        foreach ($request->file('gambar') as $file) {
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('img/soal'), $namaFile);
        }

        return back()->with('success', 'Berhasil upload gambar!');
    }

}
