{{--
    admin.blade.php
    Halaman Admin Panel untuk memantau dan mengelola status ajuan beasiswa.

    Halaman ini hanya bisa diakses oleh user dengan role 'admin'.
    Dilindungi oleh middleware 'auth' dan 'isAdmin'.

    Fitur:
    - Menampilkan statistik ringkasan (Total, Menunggu, Diterima, Ditolak)
    - Melihat semua data pendaftaran beasiswa dalam bentuk tabel
    - Mengubah status ajuan: Belum Diverifikasi → Diterima / Ditolak
    - Download/lihat berkas persyaratan yang diunggah pendaftar
    - Pagination (10 data per halaman)

    Logika Tombol Aksi:
    - Status "Belum Diverifikasi" : Tampil tombol "Terima" dan "Tolak"
    - Status "Diterima"           : Tampil badge hijau saja (tombol hilang)
    - Status "Ditolak"            : Tampil badge merah saja (tombol hilang)

    @author  ProjectBNSP
    @version 2.0
--}}

@extends('components.app')
@section('content')

<div class="max-w-screen-xl mx-auto px-6 py-10">
    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-[#1a2332] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                <p class="text-gray-500 text-sm">Kelola dan verifikasi status ajuan beasiswa pendaftar.</p>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{--
        Kartu Statistik Ringkasan
        Menghitung jumlah pendaftar berdasarkan status untuk ditampilkan
        di bagian atas halaman sebagai ringkasan cepat bagi admin.
    --}}
    @php
        $totalPendaftar = $pendaftaran->total();  // Total semua pendaftar
        $totalDiterima = \App\Models\beasiswa::where('status', 'Diterima')->count();          // Jumlah yang diterima
        $totalDitolak = \App\Models\beasiswa::where('status', 'Ditolak')->count();            // Jumlah yang ditolak
        $totalBelum = \App\Models\beasiswa::where('status', 'Belum Diverifikasi')->count();   // Jumlah yang belum diverifikasi
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Pendaftar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalPendaftar }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-200 p-5">
            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider mb-1">Menunggu</p>
            <p class="text-2xl font-bold text-amber-700">{{ $totalBelum }}</p>
        </div>
        <div class="bg-white rounded-xl border border-green-200 p-5">
            <p class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">Diterima</p>
            <p class="text-2xl font-bold text-green-700">{{ $totalDiterima }}</p>
        </div>
        <div class="bg-white rounded-xl border border-red-200 p-5">
            <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-700">{{ $totalDitolak }}</p>
        </div>
    </div>

    {{-- Tabel Data Pendaftaran Beasiswa --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-8 pt-6 pb-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Daftar Ajuan Beasiswa</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-[#f8f9fb]">
                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">SMT</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">IPK</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Berkas</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftaran as $index => $daftar)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        {{-- No --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $daftar->nama }}</div>
                            <div class="text-xs text-gray-400">{{ $daftar->nomor_hp }}</div>
                        </td>

                        {{-- Email --}}
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $daftar->email }}
                        </td>

                        {{-- Semester --}}
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                            {{ $daftar->semester }}
                        </td>

                        {{-- IPK --}}
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                            {{ $daftar->ipk }}
                        </td>

                        {{-- Jenis Beasiswa --}}
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @if($daftar->jenis_beasiswa == 'Akademik')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    Akademik
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $daftar->jenis_beasiswa }}
                                </span>
                            @endif
                        </td>

                        {{-- Berkas --}}
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @if($daftar->file_input)
                                <a href="{{ asset('storage/' . $daftar->file_input) }}" target="_blank"
                                   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                    </svg>
                                    Lihat
                                </a>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @php
                                $statusLower = strtolower($daftar->status ?? 'belum diverifikasi');
                            @endphp
                            @if(str_contains($statusLower, 'diterima'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Diterima
                                </span>
                            @elseif(str_contains($statusLower, 'ditolak'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @if(strtolower($daftar->status) == 'diterima')
                                {{-- Sudah diterima: tampilkan badge saja --}}
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    Diterima
                                </span>
                            @elseif(strtolower($daftar->status) == 'ditolak')
                                {{-- Sudah ditolak: tampilkan badge saja --}}
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-800">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Ditolak
                                </span>
                            @else
                                {{-- Belum diverifikasi: tampilkan kedua tombol --}}
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ url('/admin/' . $daftar->id . '/status') }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Diterima">
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-green-700 border border-green-300 hover:bg-green-50 transition-colors duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Terima
                                        </button>
                                    </form>
                                    <form action="{{ url('/admin/' . $daftar->id . '/status') }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-red-700 border border-red-300 hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Belum ada data pendaftaran</p>
                                <p class="text-xs text-gray-400 mt-1">Data akan muncul setelah ada pendaftar beasiswa</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pendaftaran->hasPages())
        <div class="px-8 py-4 border-t border-gray-200">
            {{ $pendaftaran->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
