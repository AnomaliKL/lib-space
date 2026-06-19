<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLogin()
    {
        // Jika user sudah terlanjur login, lempar langsung sesuai role-nya
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.login');
    }

    // Memproses data kredensial login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Proses autentikasi Laravel (Mencocokkan email & password ter-hash)
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate(); // Pengaman Session Fixation Attack

            $user = Auth::user();

            // Cek jika status user diblokir/Non-Active
            if ($user->status !== 'Active') {
                Auth::logout();

                return redirect()->back()->with('error', 'Maaf, akun Anda saat ini sedang dinonaktifkan oleh Admin.');
            }

            // Alihkan sesuai Hak Akses
            return $this->redirectUserByRole($user);
        }

        // Jika salah email/password
        return redirect()->back()->with('error', 'Email atau password yang Anda masukkan salah!');
    }

    // Memproses logout akun
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem LibSpace.');
    }

    // Helper pembagi jalur redirect role
    private function redirectUserByRole($user)
    {
        if ($user->role === 'Admin') {
            return redirect('/admin')->with('success', 'Selamat datang kembali Admin '.$user->name.'!');
        }

        return redirect()->route('member.dashboard')->with('success', 'Hai '.$user->name.', selamat datang di LibSpace!');
    }
}
