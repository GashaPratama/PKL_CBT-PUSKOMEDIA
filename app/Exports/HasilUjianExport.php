<?php


namespace App\Exports;

use App\Models\HasilUjian;
use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilUjianExport implements FromCollection, WithHeadings
{
    protected $ujian_id;

    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
    }

    public function collection()
    {
        return HasilUjian::where('ujian_id', $this->ujian_id)
            ->with('user')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->user->nama_lengkap,
                    'Skor' => $item->skor,
                    'Benar' => $item->jawaban_benar,
                    'Salah' => $item->jawaban_salah,
                    'Tanggal' => $item->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Skor', 'Jawaban Benar', 'Jawaban Salah', 'Tanggal'];
    }
}
