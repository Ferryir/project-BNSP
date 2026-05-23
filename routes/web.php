<?php

/**
 * web.php
 * 
 * File definisi route web untuk aplikasi pendaftaran beasiswa.
 * Mengatur URL dan mapping ke controller/view yang sesuai.
 * 
 * Route yang tersedia:
 * - GET  /              → Redirect ke halaman Pilihan Beasiswa
 * - GET  /beasiswa      → Halaman Pilihan Beasiswa (Tab 1)
 * - GET  /beasiswa/create → Form Pendaftaran Beasiswa (Tab 2)
 * - POST /beasiswa      → Simpan data pendaftaran
 * - GET  /hasil         → Halaman Hasil/Status Ajuan (Tab 3)
 * 
 * @author  ProjectBNSP
 * @version 1.0
 */

use App\Models\beasiswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route utama: redirect ke halaman Pilihan Beasiswa
Route::get('/', function () {
    return redirect('/beasiswa');
});

// Resource route untuk BeasiswaController (CRUD: index, create, store, show, edit, update, destroy)
Route::resource('/beasiswa', BeasiswaController::class);

// Route halaman Hasil: menampilkan semua data pendaftaran dengan pagination
Route::get('/hasil', function () {
    return view('beasiswa.hasil', [
        'pendaftaran' => beasiswa::latest()->paginate(10),
    ]);
});
