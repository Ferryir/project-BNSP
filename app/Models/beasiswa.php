<?php

/**
 * Model Beasiswa
 * 
 * Model Eloquent untuk tabel 'beasiswa' di database.
 * Menyimpan data pendaftaran beasiswa mahasiswa meliputi:
 * nama, email, nomor_hp, semester, ipk, jenis_beasiswa, file_input, dan status.
 * 
 * Menggunakan $guarded untuk proteksi mass assignment (hanya kolom 'id' yang dilindungi).
 * 
 * @author  ProjectBNSP
 * @version 1.0
 * @date    2026-05-23
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beasiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * 
     * @var string
     */
    protected $table = 'beasiswa';

    /**
     * Kolom yang dilindungi dari mass assignment.
     * Hanya kolom 'id' yang tidak bisa diisi secara massal.
     * Kolom lainnya (nama, email, nomor_hp, semester, ipk,
     * jenis_beasiswa, file_input, status) dapat diisi melalui create/update.
     * 
     * @var array
     */
    protected $guarded = ['id'];
}
