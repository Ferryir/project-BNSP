<?php

/**
 * AuthController.php
 * 
 * Controller untuk autentikasi pengguna (Login, Register, Logout).
 * Mendukung 2 role: Mahasiswa dan Admin.
 * 
 * - Mahasiswa: bisa register dan login
 * - Admin: hanya login (akun dibuat via seeder)
 * 
 * @author  ProjectBNSP
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login. Redirect sesuai role:
     * - Admin → /admin
     * - Mahasiswa → /beasiswa
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai role
            if (Auth::user()->isAdmin()) {
                return redirect('/admin');
            }

            return redirect('/beasiswa');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman register (untuk mahasiswa).
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register akun mahasiswa baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
