{{--
    index.blade.php
    Halaman Pilihan Beasiswa (Tab 1 - Pilihan Beasiswa)
    
    Menampilkan informasi jenis dan ketentuan beasiswa yang tersedia:
    - Beasiswa Akademik: IPK >= 3.0, Semester 2-8
    - Beasiswa Non-Akademik: IPK >= 3.0 & Prestasi olahraga/seni
    
    @author  ProjectBNSP
    @version 1.0
--}}

@extends('components.app')

@section('content')

  <div class="max-w-screen-xl mx-auto px-6 py-10">
    {{-- Header Section --}}
    <div class="mb-10">
      <span
        class="inline-block bg-[#1a2332] text-white text-xs font-semibold tracking-wider uppercase px-4 py-1.5 rounded-md mb-4">
        PROGRAM BEASISWA 2026
      </span>
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
        Jenis & Ketentuan Beasiswa
      </h1>
      <p class="text-gray-500 text-base max-w-2xl leading-relaxed">
        Pilih jalur beasiswa yang sesuai dengan kualifikasi akademik dan prestasi Anda untuk
        mendukung masa depan pendidikan yang lebih gemilang.
      </p>
    </div>

    {{-- Scholarship Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      {{-- Card 1: Beasiswa Akademik --}}
      <div
        class="bg-white rounded-xl border-t-4 border-t-[#1a2332] border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-300 p-8 flex flex-col justify-between">
        <div>
          {{-- Card Header --}}
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-[#eef1f7] rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#1a2332]" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-900">Beasiswa Akademik</h2>
            </div>
            <span class="bg-[#eef1f7] text-[#1a2332] text-xs font-semibold px-3 py-1 rounded-full">
              Akademik
            </span>
          </div>

          {{-- Kriteria --}}
          <div class="mb-4">
            <div class="flex items-center gap-2 mb-2">
              <svg class="w-5 h-5 text-[#1a2332]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-xs font-semibold tracking-wider uppercase text-[#1a2332]">Kriteria Utama</span>
            </div>
            <p class="text-gray-600 text-sm ml-7">Semester 2-8 dengan IPK Minimal 3.0</p>
          </div>

          {{-- Dokumen --}}
          <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>
              <span class="text-xs font-semibold tracking-wider uppercase text-gray-500">Dokumen</span>
            </div>
            <p class="text-gray-600 text-sm ml-7">Upload transkrip & surat rekomendasi</p>
          </div>
        </div>

        {{-- Button --}}
        <a href="/beasiswa/create"
          class="block w-full text-center bg-[#1a2332] hover:bg-[#2a3a52] text-white font-semibold text-sm py-3.5 rounded-lg transition-colors duration-200">
          Daftar Sekarang →
        </a>
      </div>

      {{-- Card 2: Beasiswa Non-Akademik --}}
      <div
        class="bg-white rounded-xl border-t-4 border-t-[#dc2626] border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-300 p-8 flex flex-col justify-between">
        <div>
          {{-- Card Header --}}
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#dc2626]" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m6.006 0H8.497m7.006 0a3.375 3.375 0 00-3.375-3.375H11.872a3.375 3.375 0 00-3.375 3.375m7.006 0v-.916c0-.828-.405-1.607-1.084-2.082l-.001-.001a3.375 3.375 0 00-3.72 0l-.001.001c-.68.475-1.084 1.254-1.084 2.082v.916" />
                </svg>
              </div>
              <h2 class="text-xl font-bold text-gray-900">Beasiswa Non-Akademik</h2>
            </div>
            <span class="bg-red-50 text-[#dc2626] text-xs font-semibold px-3 py-1 rounded-full">
              Non-Akademik
            </span>
          </div>

          {{-- Kriteria --}}
          <div class="mb-4">
            <div class="flex items-center gap-2 mb-2">
              <svg class="w-5 h-5 text-[#dc2626]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-xs font-semibold tracking-wider uppercase text-[#dc2626]">Kriteria Utama</span>
            </div>
            <p class="text-gray-600 text-sm ml-7">IPK ≥ 3.0 & Prestasi di bidang olahraga/seni</p>
          </div>

          {{-- Dokumen --}}
          <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>
              <span class="text-xs font-semibold tracking-wider uppercase text-gray-500">Dokumen</span>
            </div>
            <p class="text-gray-600 text-sm ml-7">Upload sertifikat prestasi relevan</p>
          </div>
        </div>

        {{-- Button --}}
        <a href="/beasiswa/create"
          class="block w-full text-center bg-[#dc2626] hover:bg-[#b91c1c] text-white font-semibold text-sm py-3.5 rounded-lg transition-colors duration-200">
          Daftar Sekarang →
        </a>
      </div>

    </div>
  </div>

@endsection