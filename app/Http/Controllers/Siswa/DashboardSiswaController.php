<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ujian;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $ujians = Ujian::orderBy('tanggal', 'desc')->get();

        return view('siswa.dashboard', compact('ujians'));
    }
}
