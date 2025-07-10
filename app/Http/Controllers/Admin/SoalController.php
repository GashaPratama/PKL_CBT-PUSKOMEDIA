<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function bulkDelete(Request $request)
    {
    $request->validate([
        'soal_ids' => 'required|array',
    ]);

    \App\Models\Soal::whereIn('id', $request->soal_ids)->delete();

    return back()->with('success', 'Soal yang dipilih berhasil dihapus.');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
        'ujian_id' => 'required|exists:ujians,id'
    ]);

    Excel::import(new SoalImport($request->ujian_id), $request->file('file'));

    return redirect()->back()->with('success', 'Soal berhasil diimpor.');
}

}
