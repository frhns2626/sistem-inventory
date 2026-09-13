@extends('layouts.app')

{{-- 1. Judul Halaman di Tab Browser --}}
@section('title', 'Starter Template')

{{-- 2. Breadcrumb / Judul di Header Navbar Atas --}}
{{-- Opsi A (Default: Dashboard / Nama Halaman) --}}
@section('page-title', 'Starter Template')
{{-- Opsi B (Dengan Grup Modul: Dashboard / Master Data / Data Barang) --}}
{{-- @section('page-group', 'Master Data') --}}
{{-- Opsi C (Manual Kustom Multi-Level): @section('breadcrumb') ... @endsection --}}

{{-- 3. Konten Utama --}}
@section('content')

    {{-- HEADER MODUL: Judul, Deskripsi & Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-base font-semibold text-zinc-900 tracking-tight">Nama Modul Fitur</h2>
            <p class="text-xs text-zinc-500 font-mono mt-0.5">Kelola dan atur data transaksi atau master inventaris.</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <button type="button" class="px-3 py-1.5 bg-white border border-zinc-300 hover:bg-zinc-50 text-zinc-700 font-medium rounded transition">
                Ekspor Data
            </button>
            <button type="button" class="px-3 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white font-medium rounded transition">
                + Tambah Data
            </button>
        </div>
    </div>

    {{-- KANVAS KONTEN: Card Utama --}}
    <div class="bg-white border border-zinc-200 rounded p-5 shadow-xs">
        
        {{-- Area Eksekusi Kode Anda --}}
        <div class="border border-dashed border-zinc-300 rounded p-12 text-center text-zinc-500 text-xs">
            <p class="font-mono text-zinc-700 font-medium mb-1">Kanvas Siap Pakai</p>
            <p class="text-zinc-400 max-w-md mx-auto">
                Silakan ganti area ini dengan tabel data Eloquent, form input, query pencarian, atau modul bisnis SIMBA yang sedang Anda buat.
            </p>
        </div>

    </div>

@endsection
