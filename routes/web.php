<?php

/**
 * web.php - File Definisi Route (Rute URL)
 *
 * File ini mengatur semua URL yang dapat diakses di aplikasi
 * beserta mapping ke Controller atau View yang menanganinya.
 *
 * Konsep Route di Laravel:
 * - Route menghubungkan URL dengan fungsi/controller yang memprosesnya
 * - Middleware digunakan untuk membatasi akses (contoh: harus login, harus admin)
 * - Method HTTP: GET (ambil data), POST (kirim data), PATCH (update sebagian data)
 *
 * Daftar Route yang tersedia:
 * ┌──────────────────────────────────┬────────┬──────────────────────────────────┐
 * │ URL                              │ Method │ Keterangan                       │
 * ├──────────────────────────────────┼────────┼──────────────────────────────────┤
 * │ /                                │ GET    │ Redirect ke /beasiswa            │
 * │ /login                           │ GET    │ Halaman Login                    │
 * │ /login                           │ POST   │ Proses Login                     │
 * │ /register                        │ GET    │ Halaman Register Mahasiswa       │
 * │ /register                        │ POST   │ Proses Register                  │
 * │ /logout                          │ POST   │ Proses Logout                    │
 * │ /beasiswa                        │ GET    │ Halaman Pilihan Beasiswa (publik)│
 * │ /beasiswa/create                 │ GET    │ Form Pendaftaran (harus login)   │
 * │ /beasiswa                        │ POST   │ Simpan Pendaftaran (harus login) │
 * │ /hasil                           │ GET    │ Status Ajuan (harus login)       │
 * │ /admin                           │ GET    │ Admin Panel (harus admin)        │
 * │ /admin/{id}/status               │ PATCH  │ Update Status Ajuan (harus admin)│
 * └──────────────────────────────────┴────────┴──────────────────────────────────┘
 *
 * @author  ProjectBNSP
 * @version 2.0
 */

use App\Models\beasiswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Rute Halaman Web
|--------------------------------------------------------------------------
|
| Di sinilah semua rute web didefinisikan. Rute-rute ini dimuat oleh
| RouteServiceProvider dalam grup yang menggunakan middleware "web".
|
*/

// ============================================
// ROUTE UTAMA
// ============================================
// Ketika user mengakses halaman utama (/), otomatis diarahkan ke /beasiswa
Route::get('/', function () {
    return redirect('/beasiswa');
});

// ============================================
// ROUTE AUTENTIKASI (Khusus Guest / Belum Login)
// ============================================
// Middleware 'guest' memastikan route ini hanya bisa diakses
// oleh pengguna yang BELUM login. Jika sudah login, akan di-redirect.
Route::middleware('guest')->group(function () {
    // Menampilkan halaman login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Memproses data login (email + password)
    Route::post('/login', [AuthController::class, 'login']);

    // Menampilkan halaman registrasi akun mahasiswa baru
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    // Memproses data registrasi (nama, email, password)
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Logout: harus sudah login (middleware 'auth')
// Menggunakan method POST untuk keamanan (mencegah logout via URL langsung)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ============================================
// ROUTE PUBLIK (Bisa diakses tanpa login)
// ============================================
// Halaman Pilihan Beasiswa (Tab 1 - Landing Page)
// Menampilkan informasi jenis beasiswa yang tersedia
Route::get('/beasiswa', [BeasiswaController::class, 'index']);

// ============================================
// ROUTE MAHASISWA (Harus Login)
// ============================================
// Middleware 'auth' memastikan hanya pengguna yang sudah login
// yang bisa mengakses route di dalam grup ini.
Route::middleware('auth')->group(function () {

    // Halaman Form Pendaftaran Beasiswa (Tab 2 - Daftar)
    // Menampilkan form untuk mengisi data diri, data akademik, dan upload berkas
    Route::get('/beasiswa/create', [BeasiswaController::class, 'create']);

    // Proses Penyimpanan Data Pendaftaran
    // Menerima data dari form pendaftaran dan menyimpan ke database
    Route::post('/beasiswa', [BeasiswaController::class, 'store']);

    // Halaman Hasil/Status Ajuan Beasiswa (Tab 3 - Hasil)
    // Menampilkan data pendaftaran HANYA milik user yang sedang login
    // Filter berdasarkan email user yang terautentikasi
    Route::get('/hasil', function () {
        return view('beasiswa.hasil', [
            // Query: ambil data beasiswa yang email-nya sama dengan email user login
            // latest() = urutkan dari yang terbaru
            // paginate(10) = batasi 10 data per halaman
            'pendaftaran' => beasiswa::where('email', auth()->user()->email)
                ->latest()
                ->paginate(10),
        ]);
    });
});

// ============================================
// ROUTE ADMIN (Harus Login + Role Admin)
// ============================================
// Middleware 'auth' = harus sudah login
// Middleware 'isAdmin' = harus memiliki role 'admin'
// Jika bukan admin, akan di-redirect ke /beasiswa dengan pesan error
Route::middleware(['auth', 'isAdmin'])->group(function () {

    // Halaman Admin Panel: menampilkan semua data pendaftaran beasiswa
    Route::get('/admin', [AdminController::class, 'index']);

    // Proses Update Status Ajuan Beasiswa
    // {id} = parameter dinamis (ID data beasiswa yang akan diupdate)
    // Method PATCH = mengupdate sebagian data (hanya kolom status)
    Route::patch('/admin/{id}/status', [AdminController::class, 'updateStatus']);
});
