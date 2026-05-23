<?php

/**
 * BeasiswaController.php
 * 
 * Controller untuk mengelola proses pendaftaran beasiswa.
 * Menghandle CRUD (Create, Read, Update, Delete) data beasiswa.
 * 
 * @author  ProjectBNSP
 * @version 1.0
 * @date    2026-05-23
 */

namespace App\Http\Controllers;

use App\Models\beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    /**
     * Menampilkan halaman Pilihan Beasiswa (landing page).
     * Halaman ini berisi informasi jenis beasiswa yang tersedia
     * yaitu Beasiswa Akademik dan Beasiswa Non-Akademik.
     *
     * @return \Illuminate\Http\Response - View halaman pilihan beasiswa
     */
    public function index()
    {
        // Menampilkan halaman Pilihan Beasiswa (landing page)
        return view('beasiswa.index');
    }

    /**
     * Menampilkan form registrasi/pendaftaran beasiswa.
     * IPK didapat dari system secara otomatis sebagai konstanta
     * yang disimpan di file config (.env).
     * Jika IPK >= 3 maka form aktif, jika IPK < 3 maka form non-aktif.
     *
     * @return \Illuminate\Http\Response - View form pendaftaran beasiswa
     */
    public function create()
    {
        // IPK didapat dari system secara otomatis (konstanta dari config/env)
        // Contoh: DEFAULT_IPK=3.4 (bisa diubah di file .env)
        $defaultIPK = config('beasiswa.default_ipk');

        // Menampilkan view create dengan membawa data IPK dari system
        return view('beasiswa.create', compact('defaultIPK'));
    }

    /**
     * Menyimpan data pendaftaran beasiswa ke database.
     * Melakukan validasi input dari form pendaftaran:
     * - nama: wajib diisi, string, maksimal 255 karakter
     * - email: wajib diisi, harus format email yang valid
     * - nomor_hp: wajib diisi, hanya angka (numeric)
     * - semester: wajib diisi, angka 1-8 (S1 hanya 8 semester)
     * - ipk: wajib diisi, angka (dari system/konstanta)
     * - jenis_beasiswa: wajib diisi (Akademik/Non-Akademik)
     * - file_input: wajib diisi, format PDF/JPG/ZIP
     * Status ajuan otomatis diset "Belum Diverifikasi".
     *
     * @param  \Illuminate\Http\Request  $request - Data input dari form
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman hasil
     */
    public function store(Request $request)
    {
        // Validasi input dari form pendaftaran
        $validateData = $request->validate([
            'nama'            => 'required|string|max:255',      // Nama lengkap
            'email'           => 'required|email',                // Email dengan validasi format
            'nomor_hp'        => 'required|numeric',              // Nomor HP hanya angka
            'semester'        => 'required|integer|between:1,8',  // Semester 1-8 untuk S1
            'ipk'             => 'required|numeric',              // IPK dari system (konstanta)
            'jenis_beasiswa'  => 'required|string',               // Jenis beasiswa
            'file_input'      => 'required|file|mimes:pdf,jpg,jpeg,zip', // Berkas syarat
        ]);

        // Set status ajuan otomatis "Belum Diverifikasi" saat pendaftaran
        $validateData['status'] = 'Belum Diverifikasi';

        // Memeriksa dan menyimpan file yang diunggah ke storage/public/file
        if ($request->file('file_input')) {
            $validateData['file_input'] = $request->file('file_input')->store('file', 'public');
        }

        // Menyimpan data pendaftaran ke database melalui model Beasiswa
        beasiswa::create($validateData);

        // Redirect ke halaman hasil dengan pesan sukses
        return redirect('hasil')->with('success', 'Pendaftaran beasiswa berhasil disimpan!');
    }

    /**
     * Menampilkan detail data beasiswa berdasarkan ID.
     *
     * @param  int  $id - ID data beasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Menampilkan form edit data beasiswa berdasarkan ID.
     *
     * @param  int  $id - ID data beasiswa yang akan diedit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Mengupdate data beasiswa di database berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request - Data input dari form edit
     * @param  int  $id - ID data beasiswa yang akan diupdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Menghapus data beasiswa dari database berdasarkan ID.
     *
     * @param  int  $id - ID data beasiswa yang akan dihapus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
