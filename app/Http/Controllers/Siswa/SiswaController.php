<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjian;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
   public function submitHasil(Request $request)
{
    try {
        $request->validate([
            'ujian_id' => 'required|integer|exists:ujians,id',
            'nilai' => 'required|integer|min:0|max:100',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date'
        ]);

        HasilUjian::create([
            'ujian_id' => $request->ujian_id,
            'user_id' => Auth::id(),
            'nilai' => $request->nilai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return response()->json(['status' => 'success']);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

}
