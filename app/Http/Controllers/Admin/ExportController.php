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
    public function exportExcel($id)
    {
        return Excel::download(new HasilUjianExport($id), 'hasil_ujian.xlsx');
    }

    public function exportPdf($id)
    {
        $ujian = Ujian::with('hasilUjian.user')->findOrFail($id);
        $pdf = PDF::loadView('admin.ujian.export-pdf', compact('ujian'));
        return $pdf->download('hasil_ujian.pdf');
    }
}
