<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalUjian;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUjian = Ujian::count();
        $totalSiswa = User::where('role', 'siswa')->count();

        $ujians = Ujian::orderBy('nama', 'desc')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jumlah_peserta', 'desc')
            ->get();

        // ✅ Ambil ujian yang dijadwalkan hari ini
        $hariIni = Carbon::today()->toDateString();
        $ujianHariIni = Ujian::whereDate('tanggal', $hariIni)->orderBy('waktu_mulai', 'asc')->get();

        return view('admin.dashboard', compact('totalUjian', 'totalSiswa', 'ujians', 'ujianHariIni'));
    }
}
