<?php

/**
 * beasiswa.php (Config)
 * 
 * File konfigurasi untuk modul beasiswa.
 * Menyimpan konstanta yang digunakan dalam aplikasi beasiswa.
 * 
 * Variabel:
 * - default_ipk: Konstanta IPK dari system yang otomatis muncul di form pendaftaran.
 *                 Diambil dari file .env (DEFAULT_IPK).
 *                 Contoh: DEFAULT_IPK=3.4 (IPK >= 3 aktif) atau DEFAULT_IPK=2.9 (IPK < 3 non-aktif)
 * 
 * @author  ProjectBNSP
 * @version 1.0
 */

return [
    // Konstanta IPK dari system (didapat secara otomatis, bukan input user)
    'default_ipk' => env('DEFAULT_IPK', 3.0),
];
