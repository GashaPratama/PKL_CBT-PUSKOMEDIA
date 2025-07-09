<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('nama_lengkap', $request->nama_lengkap)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Arahkan berdasarkan peran
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'nama_lengkap' => 'Nama atau password tidak sesuai.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
