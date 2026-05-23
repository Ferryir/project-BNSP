<?php

/**
 * AdminController.php
 * 
 * Controller untuk halaman Admin yang memantau dan mengelola
 * status ajuan beasiswa dari pendaftar.
 * 
 * Fitur:
 * - Melihat semua data pendaftaran beasiswa
 * - Mengubah status ajuan: Belum Diverifikasi → Diterima / Ditolak
 * 
 * @author  ProjectBNSP
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Models\beasiswa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman admin dengan semua data pendaftaran beasiswa.
     * Data ditampilkan dengan pagination (10 data per halaman).
     *
     * @return \Illuminate\Http\Response - View halaman admin
     */
    public function index()
    {
        $pendaftaran = beasiswa::latest()->paginate(10);
        return view('beasiswa.admin', compact('pendaftaran'));
    }

    /**
     * Mengupdate status ajuan beasiswa berdasarkan ID.
     * Status yang valid: Diterima, Ditolak, Belum Diverifikasi
     *
     * @param  \Illuminate\Http\Request  $request - Data input (status baru)
     * @param  int  $id - ID data beasiswa yang akan diupdate
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman admin
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak,Belum Diverifikasi',
        ]);

        // Cari data beasiswa berdasarkan ID
        $beasiswa = beasiswa::findOrFail($id);

        // Update status
        $beasiswa->update([
            'status' => $request->status,
        ]);

        return redirect('/admin')->with('success', 'Status ajuan berhasil diperbarui menjadi "' . $request->status . '".');
    }
}
