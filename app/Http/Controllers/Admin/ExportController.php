<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Exports\HasilUjianExport;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPdf($id)
{
    $ujian = Ujian::with('hasilUjian.user')->findOrFail($id);

    // Ambil daftar user dari hasil ujian
    $users = $ujian->hasilUjian->map(function ($hasil) {
        return $hasil->user;
    });

    $pdf = PDF::loadView('admin.ujian.export-pdf', compact('users'));

    return $pdf->download('hasil_ujian.pdf');
}

}
