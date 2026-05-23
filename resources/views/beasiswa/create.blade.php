{{--
    create.blade.php
    Halaman Form Pendaftaran/Registrasi Beasiswa (Tab 2 - Daftar)

    Halaman ini menampilkan form pendaftaran beasiswa yang terdiri dari 3 bagian:
    1. Data Diri      : Nama Lengkap, Alamat Email, Nomor HP
    2. Data Akademik  : Semester (1-8), IPK (readonly dari system)
    3. Pengajuan      : Jenis Beasiswa, Upload Berkas Persyaratan

    Logika Validasi:
    - IPK didapat dari system secara otomatis sebagai konstanta (dari file .env)
    - Jika IPK >= 3 : Form pengajuan AKTIF, mahasiswa bisa mendaftar
    - Jika IPK < 3  : Form pengajuan NON-AKTIF, tombol daftar disabled
    - Auto-focus ke pilihan beasiswa jika IPK >= 3

    Setelah submit berhasil:
    - Data disimpan ke database dengan status "Belum Diverifikasi"
    - User diarahkan ke halaman Hasil (/hasil)

    @author  ProjectBNSP
    @version 1.0
--}}

@extends('components.app')

@section('content')

<div class="max-w-screen-lg mx-auto px-6 py-10">

    {{-- Judul Halaman --}}
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Registrasi Beasiswa</h1>

    {{-- Pesan Sukses: ditampilkan setelah pendaftaran berhasil disimpan --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan Error Validasi: ditampilkan jika ada kesalahan input dari user --}}
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-700 text-sm font-semibold mb-2">Terdapat kesalahan pada input:</p>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                {{-- Menampilkan semua pesan error dari validasi Laravel --}}
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card Form Pendaftaran --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 md:p-10">

        {{--
            Form Pendaftaran Beasiswa
            - action="/beasiswa" : Mengirim data ke route POST /beasiswa
            - method="POST"      : Menggunakan method POST untuk mengirim data
            - enctype="multipart/form-data" : Diperlukan untuk upload file
        --}}
        <form action="/beasiswa" method="POST" enctype="multipart/form-data" id="beasiswaForm">
            @csrf {{-- Token CSRF untuk proteksi keamanan dari serangan CSRF --}}

            {{-- ================================================ --}}
            {{-- BAGIAN 1: DATA DIRI                              --}}
            {{-- ================================================ --}}
            <div class="mb-10">
                {{-- Header Bagian dengan Ikon --}}
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-gray-900">Data Diri</h2>
                </div>

                <div class="space-y-5">
                    {{-- Input Nama Lengkap --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="nama" class="text-sm font-semibold text-[#1a2332]">Nama Lengkap</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama" id="nama"
                                   class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] px-4 py-3 transition-colors"
                                   placeholder="Masukkan nama lengkap sesuai identitas" required>
                        </div>
                    </div>

                    {{-- Input Alamat Email (type=email untuk validasi format otomatis oleh browser) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="email" class="text-sm font-semibold text-[#1a2332]">Alamat Email</label>
                        <div class="md:col-span-2 relative">
                            {{-- Ikon email di sisi kiri input --}}
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>
                            {{-- pattern = validasi regex untuk format email yang benar --}}
                            <input type="email" name="email" id="email"
                                   class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] pl-10 pr-4 py-3 transition-colors"
                                   placeholder="user@email.com" required
                                   pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                                   title="Masukkan format email yang valid, contoh: user@email.com">
                        </div>
                    </div>

                    {{-- Input Nomor HP (hanya menerima angka) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="nomor_hp" class="text-sm font-semibold text-[#1a2332]">Nomor HP</label>
                        <div class="md:col-span-2 relative">
                            {{-- Ikon telepon di sisi kiri input --}}
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                            </div>
                            {{-- oninput = menghapus karakter non-angka secara real-time saat user mengetik --}}
                            <input type="tel" name="nomor_hp" id="nomor_hp"
                                   class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] pl-10 pr-4 py-3 transition-colors"
                                   placeholder="08xxxxxxxxxxx" required
                                   pattern="[0-9]+"
                                   title="Nomor HP hanya boleh berisi angka"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Garis Pemisah antar Bagian --}}
            <hr class="border-gray-200 mb-10">

            {{-- ================================================ --}}
            {{-- BAGIAN 2: DATA AKADEMIK                          --}}
            {{-- ================================================ --}}
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/>
                    </svg>
                    <h2 class="text-lg font-bold text-gray-900">Data Akademik</h2>
                </div>

                <div class="space-y-5">
                    {{-- Dropdown Pilihan Semester (1-8 untuk program S1) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <div>
                            <label for="semester" class="text-sm font-semibold text-[#1a2332]">Semester Saat Ini</label>
                            <p class="text-xs text-blue-600 mt-0.5">Semester 1-8</p>
                        </div>
                        <div class="md:col-span-2">
                            <select id="semester" name="semester"
                                    class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] px-4 py-3 transition-colors">
                                <option selected disabled>Pilih Semester</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>

                    {{--
                        Input IPK Terakhir (bisa diinput manual oleh mahasiswa)
                        Logika: Jika IPK >= 3 maka form pengajuan beasiswa di bawahnya AKTIF
                                Jika IPK < 3 maka form pengajuan beasiswa di-DISABLE
                        Pengecekan dilakukan secara real-time saat user mengetik (oninput)
                    --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="ipk" class="text-sm font-semibold text-[#1a2332]">IPK Terakhir</label>
                        <div class="md:col-span-2">
                            <input type="number" name="ipk" id="ipk" step="0.01" min="0" max="4"
                                   class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] px-4 py-3 transition-colors"
                                   placeholder="Masukkan IPK (contoh: 3.50)" required
                                   oninput="checkIPK()">
                            <p id="ipkWarning" class="mt-1 text-xs text-red-600 hidden">IPK harus minimal 3.00 untuk mengajukan beasiswa.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Garis Pemisah --}}
            <hr class="border-gray-200 mb-10">

            {{-- ================================================ --}}
            {{-- BAGIAN 3: PENGAJUAN BEASISWA                     --}}
            {{-- ================================================ --}}
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-gray-900">Pengajuan Beasiswa</h2>
                </div>

                <div class="space-y-5">
                    {{-- Dropdown Jenis Beasiswa: Akademik atau Non-Akademik --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="jenis_beasiswa" class="text-sm font-semibold text-[#1a2332]">Jenis Beasiswa</label>
                        <div class="md:col-span-2">
                            <select id="jenis_beasiswa" name="jenis_beasiswa"
                                    class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] px-4 py-3 transition-colors">
                                <option selected disabled>Pilih Program Beasiswa</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Non-Akademik">Non-Akademik</option>
                            </select>
                        </div>
                    </div>

                    {{-- Upload Berkas Persyaratan (format: PDF, JPG, ZIP) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <div>
                            <label for="file_input" class="text-sm font-semibold text-[#1a2332]">Berkas Persyaratan</label>
                            <p class="text-xs text-blue-600 mt-0.5">Format: PDF, JPG, ZIP</p>
                        </div>
                        <div class="md:col-span-2">
                            {{-- accept = membatasi jenis file yang bisa dipilih di dialog file --}}
                            <input type="file" name="file_input" id="file_input"
                                   accept=".pdf,.jpg,.jpeg,.zip"
                                   class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none px-4 py-2.5 file:mr-4 file:py-1 file:px-3 file:rounded file:border file:border-gray-300 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================ --}}
            {{-- TOMBOL AKSI FORM                                 --}}
            {{-- ================================================ --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                {{-- Tombol Batal: kembali ke halaman pilihan beasiswa --}}
                <a href="/beasiswa"
                   class="px-8 py-2.5 text-sm font-semibold text-[#1a2332] bg-white border border-[#1a2332] rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                {{-- Tombol Submit: akan di-disable jika IPK < 3 --}}
                <button type="submit" id="buttonSubmit"
                        class="px-8 py-2.5 text-sm font-semibold text-white bg-[#1a2332] rounded-lg hover:bg-[#2a3a52] transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Daftar Sekarang
                </button>
            </div>

        </form>
    </div>
</div>

{{--
    ================================================
    SCRIPT JAVASCRIPT: VALIDASI IPK
    ================================================
    Mengecek nilai IPK dari system dan menentukan apakah
    form pengajuan beasiswa bisa diakses atau tidak.
--}}
<script>
    /**
     * Fungsi untuk mengecek kelayakan IPK secara real-time.
     * Dipanggil setiap kali user mengetik di input IPK (oninput).
     * - Jika IPK >= 3 : Semua elemen form pengajuan AKTIF
     * - Jika IPK < 3  : Semua elemen form pengajuan di-DISABLE
     */
    function checkIPK() {
        var ipkValue = parseFloat(document.getElementById('ipk').value) || 0;
        var isEligible = ipkValue >= 3;

        // Mengaktifkan atau menonaktifkan elemen form pengajuan berdasarkan IPK
        document.getElementById('jenis_beasiswa').disabled = !isEligible;
        document.getElementById('file_input').disabled = !isEligible;
        document.getElementById('buttonSubmit').disabled = !isEligible;

        // Tampilkan pesan peringatan jika IPK < 3
        var warning = document.getElementById('ipkWarning');
        if (ipkValue > 0 && !isEligible) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }

        // Jika IPK >= 3, otomatis kursor berada di dropdown pilihan beasiswa
        if (isEligible) {
            document.getElementById('jenis_beasiswa').focus();
        }
    }

    // Menjalankan fungsi checkIPK saat halaman selesai dimuat
    // Awalnya semua form pengajuan di-disable sampai user memasukkan IPK >= 3
    document.addEventListener('DOMContentLoaded', function() {
        checkIPK();
    });
</script>

{{--
    ================================================
    SCRIPT JAVASCRIPT: KONFIRMASI SUBMIT (SweetAlert2)
    ================================================
    Menampilkan dialog konfirmasi sebelum data pendaftaran dikirim.
    Menggunakan library SweetAlert2 untuk tampilan dialog yang menarik.
--}}
<script>
    document.getElementById('beasiswaForm').addEventListener('submit', function(e) {
        // Mencegah form terkirim langsung (menunggu konfirmasi user)
        e.preventDefault();

        // Menampilkan dialog konfirmasi menggunakan SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Periksa kembali data yang Anda masukkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1a2332',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, submit!'
        }).then((result) => {
            // Jika user menekan tombol "Ya, submit!", form akan dikirim
            if (result.isConfirmed) {
                this.submit();
            }
        })
    });
</script>

@endsection