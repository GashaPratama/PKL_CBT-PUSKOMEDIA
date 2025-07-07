<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        Soal::create($request->all());

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }
}
