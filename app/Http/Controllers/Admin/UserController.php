<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UserExport;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        $users = $query->get();

        return view('admin.user.index', compact('users'));
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|unique:user,email',
            'password'       => 'required|string|min:8',
            'no_telpon'      => 'nullable|string|max:20',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'kelas'          => 'nullable|string|max:50',
            'kelompok'       => 'nullable|string|max:50',
            'role'           => 'required|in:siswa,admin',
        ]);

        User::create([
            'nama_lengkap'   => $request->nama_lengkap,
            'email'          => $request->email,
            'password'       => bcrypt($request->password),
            'no_telpon'      => $request->no_telpon,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'kelas'          => $request->kelas,
            'kelompok'       => $request->kelompok,
            'role'           => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|unique:user,email,' . $id . ',id_user',
            'no_telpon'      => 'nullable|string|max:20',
            'kelas'          => 'nullable|string|max:50',
            'kelompok'       => 'nullable|string|max:50',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'nama_lengkap'   => $request->nama_lengkap,
            'email'          => $request->email,
            'no_telpon'      => $request->no_telpon,
            'kelas'          => $request->kelas,
            'kelompok'       => $request->kelompok,
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

        Excel::import(new \App\Imports\UserImport, $request->file('file'));

        return back()->with('success', 'Data pengguna berhasil diimpor.');
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'data_peserta.xlsx');
    }

    public function exportPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('admin.exports.users-pdf', compact('users'));
        return $pdf->download('data_peserta.pdf');
    }
}
