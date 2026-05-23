{{--
    hasil.blade.php
    Halaman Hasil/Status Pendaftaran Beasiswa (Tab 3 - Hasil)
    
    Menampilkan tabel data pendaftaran beasiswa dengan kolom:
    Nama Lengkap, Email, No. HP, Semester, IPK, Jenis Beasiswa, Berkas, Status Ajuan
    
    Status default: "Belum Di Verifikasi"
    Data ditampilkan sesuai dengan yang diinput pada halaman pendaftaran.
    
    @author  ProjectBNSP
    @version 1.0
--}}

@extends('components.app')
@section('content')

<div class="max-w-screen-xl mx-auto px-6 py-10">
    {{-- Page Header --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-8 pt-8 pb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Data Pendaftaran Beasiswa</h1>
            <p class="text-gray-500 text-sm">Pantau status pengajuan beasiswa Anda secara real-time.</p>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-t border-b border-gray-200 bg-[#f8f9fb]">
                        <th class="px-8 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider">No. HP</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">SMT</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">IPK</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Jenis Beasiswa</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Berkas</th>
                        <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Status Ajuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftaran as $daftar)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ $daftar->nama }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $daftar->email }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $daftar->nomor_hp }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                            {{ $daftar->semester }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                            {{ $daftar->ipk }}
                        </td>
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
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @if($daftar->file_input)
                                <a href="{{ asset('storage/' . $daftar->file_input) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.894 13.5a48.972 48.972 0 00-2.168.519l.086-.326c.037-.142.08-.283.127-.422C7.48 17.658 8.114 17 8.5 17c.386 0 1.02.658 1.311 1.426.047.14.09.28.127.422l.086.326a48.972 48.972 0 00-2.168-.519M14.25 8.25H5.625c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125z"/>
                                    </svg>
                                    {{ basename($daftar->file_input) }}
                                    <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @php
                                $statusLower = strtolower($daftar->status ?? 'belum diverifikasi');
                            @endphp
                            @if(str_contains($statusLower, 'diverifikasi') || str_contains($statusLower, 'belum'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    BELUM DI VERIFIKASI
                                </span>
                            @elseif(str_contains($statusLower, 'diterima') || str_contains($statusLower, 'lolos'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    DITERIMA
                                </span>
                            @elseif(str_contains($statusLower, 'ditolak') || str_contains($statusLower, 'gagal'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    DITOLAK
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    {{ strtoupper($daftar->status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9.75m3 0H9.75m0 0v3.75m0-3.75H6.375c-.621 0-1.125-.504-1.125-1.125V4.125c0-.621.504-1.125 1.125-1.125h4.872M16.5 18.75h2.25"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Belum ada data pendaftaran</p>
                                <p class="text-xs text-gray-400 mt-1">Data akan muncul setelah Anda melakukan pendaftaran beasiswa</p>
                                <a href="/beasiswa/create" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[#1a2332] hover:text-[#2a3a52] transition-colors">
                                    Daftar Sekarang →
                                </a>
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