<?php

namespace App\Exports;

use App\Models\HasilUjian;
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
                    'Nama'   => $item->user?->nama_lengkap ?? '-',
                    'Email'  => $item->user?->email ?? '-',
                    'Nilai'  => $item->nilai ?? '-',
                    'Waktu'  => optional($item->created_at)->format('Y-m-d H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Lengkap', 'Email', 'Nilai', 'Waktu'];
    }
}
