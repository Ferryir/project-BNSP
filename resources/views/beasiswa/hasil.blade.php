{{--
    hasil.blade.php
    Halaman Hasil/Status Pendaftaran Beasiswa (Tab 3 - Hasil)

    Halaman ini menampilkan data pendaftaran beasiswa milik user yang sedang login.
    Data difilter berdasarkan email user yang terautentikasi sehingga
    setiap mahasiswa hanya bisa melihat data pendaftarannya sendiri.

    Tampilan menggunakan format card agar mudah dibaca tanpa scroll horizontal.

    @author  ProjectBNSP
    @version 3.0
--}}

@extends('components.app')
@section('content')

<div class="max-w-screen-xl mx-auto px-6 py-10">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Data Pendaftaran Beasiswa</h1>
        <p class="text-gray-500 text-sm">Pantau status pengajuan beasiswa Anda secara real-time.</p>
    </div>

    {{-- Data Cards --}}
    @forelse($pendaftaran as $daftar)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">

        {{-- Card Header: Nama + Status --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-[#f8f9fb]">
            <div class="flex items-center gap-3">
                {{-- Avatar Inisial --}}
                <div class="w-10 h-10 bg-[#1a2332] rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-bold">{{ strtoupper(substr($daftar->nama, 0, 1)) }}</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">{{ $daftar->nama }}</h3>
                    <p class="text-xs text-gray-500">Diajukan {{ $daftar->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Status Badge --}}
            @php
                $statusLower = strtolower($daftar->status ?? 'belum diverifikasi');
            @endphp
            @if(str_contains($statusLower, 'diverifikasi') || str_contains($statusLower, 'belum'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    BELUM DI VERIFIKASI
                </span>
            @elseif(str_contains($statusLower, 'diterima'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    DITERIMA
                </span>
            @elseif(str_contains($statusLower, 'ditolak'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    DITOLAK
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    {{ strtoupper($daftar->status) }}
                </span>
            @endif
        </div>

        {{-- Card Body: Detail Data --}}
        <div class="px-6 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-5 gap-x-6">

                {{-- Email --}}
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-sm text-gray-800">{{ $daftar->email }}</p>
                </div>

                {{-- Nomor HP --}}
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor HP</p>
                    <p class="text-sm text-gray-800">{{ $daftar->nomor_hp }}</p>
                </div>

                {{-- Semester --}}
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Semester</p>
                    <p class="text-sm text-gray-800 font-semibold">{{ $daftar->semester }}</p>
                </div>

                {{-- IPK --}}
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">IPK</p>
                    <p class="text-sm text-gray-800 font-semibold">{{ $daftar->ipk }}</p>
                </div>

                {{-- Jenis Beasiswa --}}
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Jenis Beasiswa</p>
                    @if($daftar->jenis_beasiswa == 'Akademik')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            Akademik
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            {{ $daftar->jenis_beasiswa }}
                        </span>
                    @endif
                </div>

                {{-- Berkas --}}
                <div class="md:col-span-3">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Berkas Persyaratan</p>
                    @if($daftar->file_input)
                        <a href="{{ asset('storage/' . $daftar->file_input) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                            </svg>
                            <span class="truncate max-w-[200px]">{{ basename($daftar->file_input) }}</span>
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @else
                        <span class="text-sm text-gray-400">Tidak ada berkas</span>
                    @endif
                </div>

            </div>
        </div>

    </div>
    @empty
    {{-- Pesan jika belum ada data --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9.75m3 0H9.75m0 0v3.75m0-3.75H6.375c-.621 0-1.125-.504-1.125-1.125V4.125c0-.621.504-1.125 1.125-1.125h4.872M16.5 18.75h2.25"/>
        </svg>
        <p class="text-lg text-gray-600 font-semibold mb-1">Belum ada data pendaftaran</p>
        <p class="text-sm text-gray-400 mb-5">Data akan muncul setelah Anda melakukan pendaftaran beasiswa</p>
        <a href="/beasiswa/create"
           class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-[#1a2332] rounded-lg hover:bg-[#2a3a52] transition-colors duration-200">
            Daftar Sekarang →
        </a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($pendaftaran->hasPages())
    <div class="mt-6">
        {{ $pendaftaran->links() }}
    </div>
    @endif

</div>

@endsection