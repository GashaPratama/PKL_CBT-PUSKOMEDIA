<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;

class SoalImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new SoalImport($request->ujian_id), $request->file('file'));

        return back()->with('success', 'Soal berhasil diimport dari Excel.');
    }
}
