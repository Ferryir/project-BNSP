{{--
    login.blade.php
    Halaman Login untuk Mahasiswa dan Admin.

    Halaman ini menampilkan form login dengan input:
    - Email    : Alamat email yang sudah terdaftar
    - Password : Kata sandi (dengan fitur show/hide password)

    Alur setelah login berhasil:
    - Jika role 'admin'     → Diarahkan ke halaman /admin
    - Jika role 'mahasiswa' → Diarahkan ke halaman /beasiswa

    @author  ProjectBNSP
    @version 1.2
--}}

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Program Beasiswa BNSP 2026">
    <title>Login - ProjectBNSP</title>
    {{-- Memuat CSS Flowbite untuk komponen UI --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    {{-- Memuat font Inter dari Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Memuat CSS dari Vite (Tailwind CSS) --}}
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-[#f8f9fb]" style="font-family: 'Inter', sans-serif;">

    <div class="w-full max-w-md px-6">

        {{-- Logo dan Judul Halaman --}}
        <div class="text-center mb-8">
            {{-- Ikon topi wisuda sebagai logo --}}
            <div class="inline-flex items-center justify-center w-14 h-14 bg-[#1a2332] rounded-xl mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h1>
            <p class="text-gray-500 text-sm mt-1">Program Beasiswa BNSP 2026</p>
        </div>

        {{-- Pesan Sukses: ditampilkan setelah registrasi berhasil --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card Form Login --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            {{-- Form Login: mengirim data ke POST /login --}}
            <form action="/login" method="POST" class="space-y-5">
                @csrf {{-- Token CSRF untuk proteksi keamanan --}}

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#1a2332] mb-2">Email</label>
                    <div class="relative">
                        {{-- Ikon email di sisi kiri input --}}
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        {{-- old('email') = menampilkan kembali email yang diinput jika terjadi error --}}
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] pl-10 pr-4 py-3 transition-colors @error('email') border-red-500 @enderror"
                               placeholder="user@email.com" required>
                    </div>
                    {{-- Menampilkan pesan error validasi email --}}
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Password (dengan fitur show/hide) --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#1a2332] mb-2">Password</label>
                    <div class="relative">
                        {{-- Ikon gembok di sisi kiri input --}}
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" id="password"
                               class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#1a2332] focus:border-[#1a2332] pl-10 pr-12 py-3 transition-colors"
                               placeholder="Masukkan password" required>
                        {{-- Tombol Toggle Show/Hide Password --}}
                        <button type="button" onclick="togglePassword('password', 'eyeIcon', 'eyeOffIcon')"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 transition-colors">
                            {{-- Ikon Mata Terbuka (password tersembunyi) --}}
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{-- Ikon Mata Tertutup (password terlihat) --}}
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tombol Submit Login --}}
                <button type="submit"
                        class="w-full bg-[#1a2332] hover:bg-[#2a3a52] text-white font-semibold text-sm py-3 rounded-lg transition-colors duration-200">
                    Masuk
                </button>
            </form>
        </div>

        {{-- Link ke halaman Registrasi --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="/register" class="font-semibold text-[#1a2332] hover:text-[#2a3a52] transition-colors">Daftar Sekarang</a>
        </p>
    </div>

    {{--
        Script JavaScript: Fungsi Toggle Show/Hide Password
        Mengubah tipe input antara 'password' (tersembunyi) dan 'text' (terlihat)
        serta mengganti ikon mata sesuai kondisi.
    --}}
    <script>
        /**
         * Fungsi untuk menampilkan/menyembunyikan password.
         * @param {string} inputId     - ID elemen input password
         * @param {string} eyeIconId   - ID ikon mata terbuka
         * @param {string} eyeOffIconId - ID ikon mata tertutup
         */
        function togglePassword(inputId, eyeIconId, eyeOffIconId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const eyeOffIcon = document.getElementById(eyeOffIconId);

            // Jika tipe input adalah 'password', ubah ke 'text' (tampilkan password)
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                // Jika tipe input adalah 'text', ubah ke 'password' (sembunyikan password)
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
