<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;

class UjianController extends Controller
{
    public function index($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        return view('siswa.ujian.index', compact('ujian'));
    }
}

