<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function create()
    {
        return view('admin.user.create');
    }

    public function index()
    {
        // Ambil semua user yang role-nya "siswa"
        $users = User::where('role', 'siswa')->get();
        return view('admin.user.index', compact('users'));
    }

    public function import(Request $request)
    {
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls'
    ]);

    Excel::import(new \App\Imports\UserImport, $request->file('file'));

    return back()->with('success', 'Data pengguna berhasil diimpor.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8',
            'no_telpon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'role' => 'required|in:siswa,admin',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telpon' => $request->no_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }

    public function resetPassword($id)
    {
    $user = User::findOrFail($id);
    $user->password = Hash::make('password123'); // default baru
    $user->save();

    return back()->with('success', 'Password berhasil direset ke "password123".');

    
    }      

    public function destroy($id)
    {
    $user = User::findOrFail($id);
    $user->delete();

    return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    
    
}
