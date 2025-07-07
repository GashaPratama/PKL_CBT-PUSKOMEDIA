<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{

    

    $totalUjian = Ujian::count();
    $totalSiswa = User::where('role', 'siswa')->count();
  

    $ujians = Ujian::orderBy('nama', 'desc')->orderBy('tanggal', 'desc')->orderBy('jumlah_peserta', 'desc')->get();

    return view('admin.dashboard', compact('totalUjian', 'totalSiswa', 'ujians'));
}

}
