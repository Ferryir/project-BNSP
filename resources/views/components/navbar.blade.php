{{--
    navbar.blade.php
    Komponen navigasi utama aplikasi pendaftaran beasiswa.

    Logika Navigasi berdasarkan Role:
    - Admin    : Hanya menampilkan tab "Dashboard Admin"
    - Mahasiswa: Menampilkan tab "Pilihan Beasiswa", "Daftar", dan "Hasil"
    - Guest    : Hanya menampilkan tab "Pilihan Beasiswa" + tombol Login

    Fitur:
    - Indikator tab aktif menggunakan garis bawah berwarna emas (#d4a843)
    - Menampilkan nama user dan role di sisi kanan
    - Tombol Logout untuk user yang sudah login
    - Tombol Login untuk pengunjung (guest)

    @author  ProjectBNSP
    @version 2.0
--}}

{{-- Elemen navigasi utama dengan warna latar gelap (#1a2332) --}}
<nav class="bg-[#1a2332] shadow-lg">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center justify-between">

            {{-- Bagian Kiri: Tab Navigasi --}}
            <div class="flex items-center">

                {{-- Cek apakah pengguna sudah login --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        {{--
                            ADMIN: Hanya menampilkan satu tab "Dashboard Admin"
                            karena admin tidak perlu akses halaman beasiswa mahasiswa.
                            request()->is('admin') digunakan untuk mengecek apakah
                            halaman saat ini adalah /admin untuk memberi indikator aktif.
                        --}}
                        <a href="/admin"
                           class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                                  {{ request()->is('admin') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                            Dashboard Admin
                            {{-- Garis bawah emas sebagai indikator tab aktif --}}
                            @if(request()->is('admin'))
                                <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                            @endif
                        </a>
                    @else
                        {{--
                            MAHASISWA: Menampilkan 3 tab navigasi utama.
                            Setiap tab memiliki pengecekan URL untuk menandai tab yang aktif.
                        --}}

                        {{-- Tab 1: Pilihan Beasiswa (halaman informasi beasiswa) --}}
                        <a href="/beasiswa"
                           class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                                  {{ request()->is('beasiswa') && !request()->is('beasiswa/create') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                            Pilihan Beasiswa
                            @if(request()->is('beasiswa') && !request()->is('beasiswa/create'))
                                <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                            @endif
                        </a>

                        {{-- Tab 2: Daftar (form pendaftaran beasiswa) --}}
                        <a href="/beasiswa/create"
                           class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                                  {{ request()->is('beasiswa/create') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                            Daftar
                            @if(request()->is('beasiswa/create'))
                                <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                            @endif
                        </a>

                        {{-- Tab 3: Hasil (status ajuan beasiswa milik user) --}}
                        <a href="/hasil"
                           class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                                  {{ request()->is('hasil') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                            Hasil
                            @if(request()->is('hasil'))
                                <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                            @endif
                        </a>
                    @endif
                @else
                    {{--
                        GUEST (Belum Login): Hanya menampilkan tab "Pilihan Beasiswa"
                        karena pengunjung belum memiliki akun untuk mendaftar beasiswa.
                    --}}
                    <a href="/beasiswa"
                       class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                              {{ request()->is('beasiswa') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                        Pilihan Beasiswa
                        @if(request()->is('beasiswa'))
                            <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                        @endif
                    </a>
                @endauth
            </div>

            {{-- Bagian Kanan: Informasi User dan Tombol Login/Logout --}}
            <div class="flex items-center gap-3 pr-4">
                @auth
                    {{-- Menampilkan nama user dan role (Admin/Mahasiswa) --}}
                    <span class="text-sm text-gray-400">
                        {{ auth()->user()->name }}
                        <span class="text-xs text-gray-500">({{ ucfirst(auth()->user()->role) }})</span>
                    </span>

                    {{-- Form Logout: menggunakan method POST untuk keamanan --}}
                    <form action="/logout" method="POST" class="inline">
                        @csrf {{-- Token CSRF untuk proteksi dari serangan Cross-Site Request Forgery --}}
                        <button type="submit"
                                class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- Tombol Login untuk pengunjung yang belum login --}}
                    <a href="/login"
                       class="px-5 py-1.5 text-xs font-semibold text-white bg-[#d4a843] hover:bg-[#c49a3a] rounded-lg transition-colors duration-200">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>