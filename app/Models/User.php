<?php

/**
 * User.php (Model)
 *
 * Model Eloquent untuk tabel 'users' di database.
 * Mengelola data pengguna aplikasi dengan dukungan dua role:
 * - 'admin'     : Dapat mengakses halaman admin dan mengelola status ajuan beasiswa
 * - 'mahasiswa' : Dapat mendaftar beasiswa dan melihat status ajuan sendiri
 *
 * Model ini mewarisi (extends) class Authenticatable dari Laravel
 * yang menyediakan fitur autentikasi bawaan seperti:
 * - Hashing password otomatis
 * - Session management
 * - Token remember me
 *
 * @author  ProjectBNSP
 * @version 1.0
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Kolom-kolom ini dapat diisi melalui User::create() atau $user->fill().
     *
     * - name     : Nama lengkap pengguna
     * - email    : Alamat email (digunakan untuk login)
     * - password : Kata sandi (disimpan dalam bentuk hash/terenkripsi)
     * - role     : Peran pengguna ('admin' atau 'mahasiswa')
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya saat dikonversi ke JSON).
     * Ini untuk keamanan agar data sensitif tidak terekspos.
     *
     * - password       : Kata sandi tidak boleh ditampilkan
     * - remember_token : Token sesi tidak boleh ditampilkan
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe casting untuk kolom tertentu.
     * Laravel akan otomatis mengkonversi tipe data kolom sesuai yang ditentukan.
     *
     * - email_verified_at : Dikonversi menjadi objek Carbon (datetime)
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mengecek apakah pengguna memiliki role 'admin'.
     * Digunakan di middleware IsAdmin dan navbar untuk kontrol akses.
     *
     * @return bool true jika user adalah admin, false jika bukan
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah pengguna memiliki role 'mahasiswa'.
     * Digunakan untuk membedakan tampilan dan akses fitur.
     *
     * @return bool true jika user adalah mahasiswa, false jika bukan
     */
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}
