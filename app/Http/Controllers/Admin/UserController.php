<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RombonganBelajar;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\Kelas;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('rombonganBelajar.kelas')->where('role', 'siswa');

        if ($request->filled('kelas')) {
            $query->whereHas('rombonganBelajar.kelas', function ($q) use ($request) {
                $q->where('id', $request->kelas);
            });
        }

        if ($request->filled('kelompok')) {
            $query->whereHas('rombonganBelajar', function ($q) use ($request) {
                $q->where('id', $request->kelompok);
            });
        }

        $users = $query->get();

        $kelasList = \App\Models\Kelas::all();
        $rombelList = \App\Models\RombonganBelajar::with('kelas')->get();

        return view('admin.user.index', compact('users', 'kelasList', 'rombelList'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $rombels = RombonganBelajar::with('kelas')->get();
        return view('admin.user.create', compact('kelas', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'         => 'required|string|max:255',
            'email'                => 'required|email|unique:user,email',
            'password'             => 'required|string|min:8',
            'no_telpon'            => 'nullable|string|max:20',
            'jenis_kelamin'        => 'required|in:Laki-laki,Perempuan',
            'rombongan_belajar_id' => 'required|exists:rombongan_belajar,id',
            'role'                 => 'required|in:siswa,admin',
        ]);

        User::create([
            'nama_lengkap'         => $request->nama_lengkap,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'no_telpon'            => $request->no_telpon,
            'jenis_kelamin'        => $request->jenis_kelamin,
            'rombongan_belajar_id' => $request->rombongan_belajar_id,
            'role'                 => $request->role,
        ]);

        return redirect()->route('admin.user.show')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $rombels = RombonganBelajar::with('kelas')->get();
        return view('admin.user.edit', compact('user', 'rombels'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap'         => 'required|string|max:255',
            'email'                => 'required|email|unique:user,email,' . $id . ',id_user',
            'no_telpon'            => 'nullable|string|max:20',
            'jenis_kelamin'        => 'required|in:Laki-laki,Perempuan',
            'rombongan_belajar_id' => 'required|exists:rombongan_belajar,id',
        ]);

        $user->update([
            'nama_lengkap'         => $request->nama_lengkap,
            'email'                => $request->email,
            'no_telpon'            => $request->no_telpon,
            'jenis_kelamin'        => $request->jenis_kelamin,
            'rombongan_belajar_id' => $request->rombongan_belajar_id,
        ]);

        return redirect()->route('admin.user.show')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password123');
        $user->save();

        return back()->with('success', 'Password berhasil direset ke "password123".');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return back()->with('success', 'Data pengguna berhasil diimpor.');
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'data_peserta.xlsx');
    }

    public function exportPdf()
    {
        $users = User::with('rombonganBelajar.kelas')->where('role', 'siswa')->get();
        $pdf = Pdf::loadView('admin.exports.users-pdf', compact('users'));
        return $pdf->download('data_peserta.pdf');
    }
}
