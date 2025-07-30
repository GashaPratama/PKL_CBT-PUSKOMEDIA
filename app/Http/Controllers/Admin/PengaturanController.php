<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function uploadLogoLogin(Request $request)
    {
        $request->validate([
            'logo_login' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Simpan file ke public storage
        $path = $request->file('logo_login')->store('logos', 'public');

        // Simpan ke tabel settings
        DB::table('settings')->updateOrInsert(
            ['nama_konfigurasi' => 'logo_login'],
            ['nilai' => $path]
        );

        return back()->with('success', 'Logo berhasil diunggah.');
    }
}
