# ProjectBNSP - Sistem Pendaftaran Beasiswa

## Deskripsi Proyek
Aplikasi web pendaftaran beasiswa berbasis Laravel (PHP) untuk mengelola proses registrasi, 
pengecekan kelayakan, dan pemantauan status ajuan beasiswa mahasiswa.

**Fitur Utama:**
- Halaman informasi jenis beasiswa (Akademik & Non-Akademik)
- Form pendaftaran dengan validasi lengkap
- IPK otomatis dari system (konstanta)
- Pengecekan kelayakan IPK >= 3.0
- Upload berkas persyaratan (PDF, JPG, ZIP)
- Halaman hasil/monitoring status ajuan

## Teknologi yang Digunakan
| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| PHP | 8.x | Bahasa pemrograman utama |
| Laravel | 9.x | Framework PHP (MVC) |
| MySQL | 8.x | Database |
| TailwindCSS | 3.x | Framework CSS untuk styling |
| Flowbite | 2.2.0 | UI Component Library |
| SweetAlert2 | 11.x | Library untuk alert/dialog |
| Vite | 4.x | Build tool frontend |

## Struktur Folder Proyek

```
project-BNSP/
│
├── app/                            # Logika aplikasi utama
│   ├── Console/                    # Command artisan custom
│   ├── Exceptions/                 # Handler error/exception
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php      # Base controller
│   │   │   └── BeasiswaController.php  # Controller untuk CRUD beasiswa
│   │   ├── Kernel.php              # HTTP Kernel (middleware)
│   │   └── Middleware/             # Middleware custom
│   ├── Models/
│   │   ├── User.php                # Model User (default Laravel)
│   │   └── beasiswa.php            # Model Beasiswa (tabel beasiswa)
│   └── Providers/                  # Service Provider
│
├── bootstrap/                      # Bootstrap framework
│
├── config/                         # File konfigurasi aplikasi
│   └── beasiswa.php                # Config konstanta IPK (DEFAULT_IPK)
│
├── database/
│   ├── factories/                  # Factory untuk testing
│   ├── migrations/
│   │   ├── 2023_12_19_043048_create_beasiswa_table.php  # Migrasi tabel beasiswa
│   │   └── 2023_12_19_120633_add_status_to_beasiswa_table.php  # Tambah kolom status
│   └── seeders/                    # Seeder untuk data awal
│
├── lang/                           # File bahasa/lokalisasi
│
├── public/                         # File publik (entry point)
│   └── build/                      # Hasil build Vite (CSS/JS)
│
├── resources/                      # Sumber daya frontend
│   ├── css/
│   │   └── app.css                 # CSS utama (Tailwind directives)
│   ├── js/
│   │   ├── app.js                  # JavaScript utama
│   │   └── bootstrap.js            # Bootstrap dependencies
│   └── views/
│       ├── beasiswa/
│       │   ├── index.blade.php     # Halaman Pilihan Beasiswa (Tab 1)
│       │   ├── create.blade.php    # Form Pendaftaran Beasiswa (Tab 2)
│       │   ├── hasil.blade.php     # Halaman Hasil/Status Ajuan (Tab 3)
│       │   └── show.blade.php      # Detail data beasiswa
│       ├── components/
│       │   ├── app.blade.php       # Layout utama (template induk)
│       │   ├── navbar.blade.php    # Komponen navigasi (tab menu)
│       │   └── footer.blade.php    # Komponen footer
│       └── welcome.blade.php       # Halaman welcome (default)
│
├── routes/
│   └── web.php                     # Definisi route web aplikasi
│
├── storage/                        # File storage (upload, log, cache)
│   └── app/public/file/            # Lokasi penyimpanan berkas upload
│
├── .env                            # Environment variables (termasuk DEFAULT_IPK)
├── composer.json                   # Dependency PHP
├── package.json                    # Dependency Node.js
├── tailwind.config.js              # Konfigurasi TailwindCSS
├── vite.config.js                  # Konfigurasi Vite (build tool)
└── README.md                       # Dokumentasi proyek (file ini)
```

## Alur Program (Flow)

```
[Pilihan Beasiswa] → [Daftar/Registrasi] → [Hasil/Status]
     (Tab 1)              (Tab 2)             (Tab 3)
```

### Tab 1 - Pilihan Beasiswa (`/beasiswa`)
- Menampilkan 2 kartu jenis beasiswa: **Akademik** dan **Non-Akademik**
- Menampilkan kriteria dan dokumen yang diperlukan
- Tombol "Daftar Sekarang" menuju form pendaftaran

### Tab 2 - Daftar/Registrasi (`/beasiswa/create`)
- **Data Diri**: Nama, Email (validasi format), Nomor HP (angka saja)
- **Data Akademik**: Semester (pilih 1-8), IPK (readonly, dari system/konstanta)
- **Pengajuan**: Jenis Beasiswa (dropdown), Upload Berkas (PDF/JPG/ZIP)
- Jika IPK < 3: Pilihan beasiswa, upload, dan tombol daftar **non-aktif**
- Jika IPK >= 3: Kursor otomatis ke pilihan beasiswa
- Klik "Daftar Sekarang" → konfirmasi SweetAlert → simpan ke database

### Tab 3 - Hasil (`/hasil`)
- Menampilkan tabel semua data pendaftaran
- Kolom: Nama, Email, No. HP, Semester, IPK, Jenis Beasiswa, Berkas, Status Ajuan
- Status default: **"Belum Di Verifikasi"**

## Cara Menjalankan

1. Clone repository
2. Install dependency:
   ```bash
   composer install
   npm install
   ```
3. Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi database
4. Set konstanta IPK di `.env`:
   ```
   DEFAULT_IPK=3.4
   ```
5. Generate app key:
   ```bash
   php artisan key:generate
   ```
6. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
7. Buat symbolic link untuk storage:
   ```bash
   php artisan storage:link
   ```
8. Build asset frontend:
   ```bash
   npm run build
   ```
9. Jalankan server:
   ```bash
   php artisan serve
   ```

## Konfigurasi IPK

IPK disimpan sebagai konstanta di file `.env`:
```
DEFAULT_IPK=3.4   # IPK >= 3: form aktif
DEFAULT_IPK=2.9   # IPK < 3: form non-aktif (untuk testing)
```

Setelah mengubah nilai, jalankan: `php artisan config:clear`

## Struktur Database (Tabel Beasiswa)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Primary key, auto increment |
| nama | string | Nama lengkap mahasiswa |
| email | string | Alamat email (format valid) |
| nomor_hp | string | Nomor HP (angka saja) |
| semester | integer | Semester saat ini (1-8) |
| ipk | float | IPK terakhir (dari system) |
| status | string | Status ajuan (default: "Belum Diverifikasi") |
| jenis_beasiswa | string | Jenis beasiswa (Akademik/Non-Akademik) |
| file_input | string | Path file berkas yang diupload |
| created_at | timestamp | Waktu data dibuat |
| updated_at | timestamp | Waktu data terakhir diupdate |
