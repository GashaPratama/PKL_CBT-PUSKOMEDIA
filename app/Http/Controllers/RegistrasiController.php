<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'no_telpon' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        DB::beginTransaction();

        try {
            // Insert data baru ke tabel pendaftaran_akun
            $akun = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telpon' => $request->no_telpon,
                'password' => Hash::make($request->password), // Hash password
                'tanggal_lahir' => $request->tanggal_lahir, // Pastikan ini disertakan
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            DB::commit();

            // Redirect ke halaman login setelah registrasi berhasil
            return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }
}
