<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            if (session('role') === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (session('role') === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && ($user->password === $request->password || Hash::check($request->password, $user->password))) {
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            }

            return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang di BI Kantin, ' . $user->username . '!');
        }

        return back()->with('error', 'Username atau password tidak sesuai!')->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil keluar dari akun.');
    }
}
