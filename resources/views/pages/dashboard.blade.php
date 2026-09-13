@extends('layouts.app')

@section('title', 'Dashboard Inventaris')
@section('page-title', 'Dashboard')

@section('content')

    {{-- BREADCRUMBS (DIBAWAH HEADER, DIATAS TITLE DASHBOARD INVENTARIS) --}}
    <nav aria-label="Breadcrumbs" class="mb-3 flex items-center text-xs sm:text-sm font-medium select-none">
        <ol class="flex items-center gap-2">
            <li>
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-gray-700 transition flex items-center gap-1.5">
                    {{-- Heroicon Mini 20x20: home --}}
                    <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                    </svg>
                    <span>SIMBA</span>
                </a>
            </li>
            <li class="text-gray-300">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </li>
            <li class="text-gray-900 font-semibold">
                Dashboard
            </li>
        </ol>
    </nav>

    {{-- PAGE HEADER WITH ACTIONS --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl font-sans">Dashboard Inventaris</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Ringkasan ketersediaan stok barang, metrik pemesanan, dan monitoring batas buffer minimum.</p>
        </div>

        <div class="flex items-center gap-2.5">
            {{-- Secondary Action --}}
            <button type="button" 
                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 shadow-2xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition cursor-pointer">
                {{-- Heroicon Mini 20x20: arrow-down-tray --}}
                <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                </svg>
                <span>Unduh Laporan</span>
            </button>

            {{-- Primary Action: Classic Filament Amber Button --}}
            <a href="{{ url('/purchase-requests/create') }}" 
               class="inline-flex items-center gap-1.5 rounded-lg bg-amber-600 px-3.5 py-2 text-xs font-semibold text-white shadow-xs hover:bg-amber-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition cursor-pointer">
                {{-- Heroicon Mini 20x20: plus --}}
                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <span>Buat Pengadaan</span>
            </a>
        </div>
    </div>

    {{-- STATS OVERVIEW CARDS (4 GRID) - FILAMENT v3 STATS OVERVIEW WIDGET --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        
        {{-- Metric Card 1: Total Item Katalog --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Total Item Katalog</span>
                {{-- Heroicon Outline 24x24: cube --}}
                <div class="p-2 rounded-lg bg-gray-50 ring-1 ring-gray-950/5 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">1,248</div>

            <div class="mt-3 flex items-center gap-1.5">
                {{-- Green Pill for Positive Trend --}}
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    {{-- Heroicon Mini 20x20: arrow-trending-up --}}
                    <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022-4.14 4.14a.75.75 0 01-1.06 0L8 8.31 2.56 13.75a.75.75 0 01-1.06-1.06l6-6a.75.75 0 011.06 0l2.75 2.75 3.44-3.44-3.022-.81a.75.75 0 01-.531-.919z" clip-rule="evenodd" />
                    </svg>
                    <span>+18 SKU</span>
                </span>
                <span class="text-xs text-gray-500">bulan ini</span>
            </div>
        </div>

        {{-- Metric Card 2: Pengadaan Pending --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Pengadaan Pending</span>
                {{-- Heroicon Outline 24x24: shopping-cart --}}
                <div class="p-2 rounded-lg bg-amber-50 ring-1 ring-amber-600/10 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">14</div>

            <div class="mt-3 flex items-center gap-1.5">
                {{-- Amber Pill for Pending Action --}}
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                    {{-- Heroicon Mini 20x20: clock --}}
                    <svg class="w-3.5 h-3.5 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                    </svg>
                    <span>6 PR / 8 PO</span>
                </span>
                <span class="text-xs text-gray-500">butuh approval</span>
            </div>
        </div>

        {{-- Metric Card 3: Item Stok Kritis --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Item Stok Kritis</span>
                {{-- Heroicon Outline 24x24: exclamation-triangle --}}
                <div class="p-2 rounded-lg bg-rose-50 ring-1 ring-rose-600/10 text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-rose-600 mt-3">8</div>

            <div class="mt-3 flex items-center gap-1.5">
                {{-- Rose Pill for Critical Alert --}}
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                    {{-- Heroicon Mini 20x20: arrow-trending-down --}}
                    <svg class="w-3.5 h-3.5 text-rose-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M1.5 6.75a.75.75 0 011.06 0L8 12.19l2.72-2.72a.75.75 0 011.06 0l4.14 4.14.81-3.022a.75.75 0 111.449.387l-1.281 4.78a.75.75 0 01-.919.531l-4.78-1.281a.75.75 0 01.388-1.449l3.022.81-3.44-3.44-2.75 2.75a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" clip-rule="evenodd" />
                    </svg>
                    <span>Alert</span>
                </span>
                <span class="text-xs text-gray-500">Di bawah batas buffer</span>
            </div>
        </div>

        {{-- Metric Card 4: Valuasi Inventaris --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Valuasi Inventaris</span>
                {{-- Heroicon Outline 24x24: banknotes --}}
                <div class="p-2 rounded-lg bg-gray-50 ring-1 ring-gray-950/5 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">Rp 482,5 M</div>

            <div class="mt-3 flex items-center gap-1.5">
                {{-- Neutral/Gray Pill --}}
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>3 Gudang Aktif</span>
                </span>
                <span class="text-xs text-gray-500">total valuasi buku</span>
            </div>
        </div>

    </div>

    {{-- MAIN FILAMENT TABLE CONTAINER --}}
    <div class="bg-white rounded-xl shadow-xs ring-1 ring-gray-950/5 overflow-hidden mb-8">
        
        {{-- TABLE HEADER & TOOLBAR --}}
        <div class="p-4 sm:p-6 border-b border-gray-200/70 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-gray-950">Daftar Status Stok Barang</h2>
                <p class="text-xs text-gray-500 mt-0.5">Monitoring ketersediaan unit fisik, batas buffer minimum, dan status pemesanan secara real-time.</p>
            </div>

            <div class="flex items-center gap-2 sm:gap-2.5 flex-wrap sm:flex-nowrap shrink-0">
                {{-- Integrated Table Search Input --}}
                <div class="relative w-full sm:w-48 lg:w-56">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        {{-- Heroicon Mini 20x20: magnifying-glass --}}
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           id="table-search-input"
                           placeholder="Cari SKU, nama barang..." 
                           class="w-full bg-gray-50/80 border border-gray-200 text-gray-900 text-xs rounded-lg pl-9 pr-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 focus:bg-white transition duration-150 font-sans shadow-2xs">
                </div>

                {{-- Filter Popover Trigger Button --}}
                <button type="button" 
                        id="table-filter-toggle-btn"
                        class="shrink-0 inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-2xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition cursor-pointer">
                    {{-- Heroicon Mini 20x20: funnel --}}
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.972.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                    </svg>
                    <span>Filter</span>
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">2</span>
                </button>

                {{-- Export CSV Action --}}
                <button type="button" 
                        class="shrink-0 inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-2xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition cursor-pointer"
                        title="Ekspor Data (.csv)">
                    {{-- Heroicon Mini 20x20: arrow-down-tray --}}
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                    <span>Ekspor</span>
                </button>

                {{-- Primary Action: + Item Baru --}}
                <a href="{{ url('/items/create') }}" 
                   class="shrink-0 inline-flex items-center gap-1.5 rounded-lg bg-amber-600 px-3.5 py-2 text-xs font-semibold text-white shadow-xs hover:bg-amber-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition cursor-pointer">
                    {{-- Heroicon Mini 20x20: plus --}}
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span>Item Baru</span>
                </a>
            </div>
        </div>

        {{-- COLLAPSIBLE FILTER POPOVER / BAR --}}
        <div id="table-filter-drawer" class="bg-gray-50/80 border-b border-gray-200/70 p-4 transition-all duration-200">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5 font-mono">Kategori Barang</label>
                    <select class="w-full bg-white border border-gray-300 text-gray-800 text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-2xs">
                        <option value="">Semua Kategori</option>
                        <option value="hardware" selected>Hardware &amp; IT</option>
                        <option value="atk">ATK &amp; Kantor</option>
                        <option value="aksesoris">Aksesoris IT</option>
                        <option value="jaringan">Jaringan &amp; Kabel</option>
                        <option value="sparepart">Sparepart Operasional</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5 font-mono">Lokasi Gudang</label>
                    <select class="w-full bg-white border border-gray-300 text-gray-800 text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-2xs">
                        <option value="">Semua Lokasi Gudang</option>
                        <option value="wh1" selected>Gudang Utama (Jakarta)</option>
                        <option value="wh2">Gudang Logistik (Cikarang)</option>
                        <option value="wh3">Gudang Transit (Surabaya)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5 font-mono">Status Stok</label>
                    <div class="flex items-center gap-2">
                        <select class="flex-1 bg-white border border-gray-300 text-gray-800 text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-2xs">
                            <option value="">Semua Status</option>
                            <option value="normal">Normal (Aman)</option>
                            <option value="menipis">Menipis (Buffer Terlampaui)</option>
                            <option value="kritis">Kritis (Alert Kebutuhan)</option>
                        </select>
                        <button type="button" class="text-xs text-amber-700 hover:text-amber-800 font-medium px-2 py-1.5 rounded hover:bg-amber-50 transition cursor-pointer">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE VIEW --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                
                {{-- Table Head --}}
                <thead class="bg-gray-50/75 border-b border-gray-200/70 text-xs font-semibold text-gray-600 uppercase tracking-wider font-sans select-none">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 font-semibold">SKU</th>
                        <th scope="col" class="py-3.5 px-3 font-semibold">Nama Barang &amp; Deskripsi</th>
                        <th scope="col" class="py-3.5 px-3 font-semibold">Kategori</th>
                        <th scope="col" class="py-3.5 px-3 font-semibold">Lokasi Gudang</th>
                        <th scope="col" class="py-3.5 px-3 font-semibold">Stok Fisik &amp; Min. Buffer</th>
                        <th scope="col" class="py-3.5 px-3 font-semibold text-center">Status</th>
                        <th scope="col" class="py-3.5 pl-3 pr-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-gray-200/60 font-sans">
                    
                    {{-- Row 1: Normal Status --}}
                    <tr class="hover:bg-gray-50/60 transition duration-75 group">
                        <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                            <span class="font-mono text-xs font-semibold text-gray-700 bg-gray-100/90 px-2.5 py-1 rounded-md ring-1 ring-gray-900/5 inline-block">
                                ITM-2026-001
                            </span>
                        </td>
                        <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                            <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                Laptop Dell Latitude 3420 14"
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                Intel Core i5-1135G7, 16GB DDR4, 512GB NVMe SSD
                            </div>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Hardware &amp; IT
                            </span>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                {{-- Heroicon Mini 20x20: map-pin --}}
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Gudang Utama (Rak A-02)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 align-middle">
                            {{-- Stok Fisik & Buffer Ratio Indicator --}}
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-mono font-semibold text-gray-900">24 Unit</span>
                                    <span class="text-[11px] text-gray-400 font-mono">Min: 5</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden ring-1 ring-gray-200/50">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: 82%"></div>
                                </div>
                                <span class="text-[10px] text-emerald-600 font-medium">Stok Aman (4.8x Buffer)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                            {{-- Filament Soft Pill: Normal --}}
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Normal
                            </span>
                        </td>
                        <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 justify-end">
                                <a href="#" class="inline-flex items-center gap-1 font-semibold text-xs text-gray-700 hover:text-amber-600 transition px-2 py-1 rounded-md hover:bg-gray-100 cursor-pointer">
                                    {{-- Heroicon Mini 20x20: eye --}}
                                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Lihat</span>
                                </a>
                                <button type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none cursor-pointer" title="Opsi Lainnya">
                                    {{-- Heroicon Mini 20x20: ellipsis-vertical --}}
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 14a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2: Kritis Status --}}
                    <tr class="hover:bg-rose-50/30 bg-rose-50/15 transition duration-75 group">
                        <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                            <span class="font-mono text-xs font-semibold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-md ring-1 ring-rose-600/20 inline-block">
                                ITM-2026-042
                            </span>
                        </td>
                        <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                            <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                Kertas HVS A4 80gr PaperOne
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                Dus isi 5 Rim (Box), Putih Bersih 98% Brightness
                            </div>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                ATK &amp; Kantor
                            </span>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Gudang Utama (Rak C-05)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 align-middle">
                            {{-- Critical Buffer Ratio --}}
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-mono font-bold text-rose-600">2 Dus</span>
                                    <span class="text-[11px] text-rose-400 font-mono font-medium">Min: 10</span>
                                </div>
                                <div class="w-full bg-rose-100 rounded-full h-1.5 overflow-hidden ring-1 ring-rose-200">
                                    <div class="bg-rose-500 h-full rounded-full" style="width: 20%"></div>
                                </div>
                                <span class="text-[10px] text-rose-600 font-semibold">Defisit 8 Dus (Segera Restock)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                            {{-- Filament Soft Pill: Kritis --}}
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Kritis
                            </span>
                        </td>
                        <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 justify-end">
                                <a href="{{ url('/purchase-requests/create?item_id=ITM-2026-042') }}" 
                                   class="inline-flex items-center gap-1 font-semibold text-xs text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 transition px-2.5 py-1 rounded-md ring-1 ring-inset ring-rose-600/20 cursor-pointer">
                                    <span>+ Buat PR</span>
                                </a>
                                <button type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none cursor-pointer" title="Opsi Lainnya">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 14a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3: Normal Status --}}
                    <tr class="hover:bg-gray-50/60 transition duration-75 group">
                        <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                            <span class="font-mono text-xs font-semibold text-gray-700 bg-gray-100/90 px-2.5 py-1 rounded-md ring-1 ring-gray-900/5 inline-block">
                                ITM-2026-088
                            </span>
                        </td>
                        <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                            <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                Mouse Wireless Logitech M220 Silent
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                Warna Charcoal Grey, 2.4GHz Nano Receiver
                            </div>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                Aksesoris IT
                            </span>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Gudang Logistik (Rak B-01)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 align-middle">
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-mono font-semibold text-gray-900">18 Unit</span>
                                    <span class="text-[11px] text-gray-400 font-mono">Min: 5</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden ring-1 ring-gray-200/50">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: 76%"></div>
                                </div>
                                <span class="text-[10px] text-emerald-600 font-medium">Stok Aman (3.6x Buffer)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Normal
                            </span>
                        </td>
                        <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 justify-end">
                                <a href="#" class="inline-flex items-center gap-1 font-semibold text-xs text-gray-700 hover:text-amber-600 transition px-2 py-1 rounded-md hover:bg-gray-100 cursor-pointer">
                                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Lihat</span>
                                </a>
                                <button type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none cursor-pointer" title="Opsi Lainnya">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 14a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4: Menipis Status --}}
                    <tr class="hover:bg-amber-50/30 bg-amber-50/15 transition duration-75 group">
                        <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                            <span class="font-mono text-xs font-semibold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md ring-1 ring-amber-600/20 inline-block">
                                ITM-2026-104
                            </span>
                        </td>
                        <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                            <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                Kabel UTP Cat6 Belden 305m
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                Roll original blue jacket, UTP 4-Pair 23 AWG
                            </div>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                Jaringan &amp; Kabel
                            </span>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Gudang Logistik (Rak D-02)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 align-middle">
                            {{-- Warning Buffer Ratio --}}
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-mono font-bold text-amber-700">1 Roll</span>
                                    <span class="text-[11px] text-amber-600/80 font-mono font-medium">Min: 3</span>
                                </div>
                                <div class="w-full bg-amber-100 rounded-full h-1.5 overflow-hidden ring-1 ring-amber-200">
                                    <div class="bg-amber-500 h-full rounded-full" style="width: 33%"></div>
                                </div>
                                <span class="text-[10px] text-amber-700 font-medium">Di Bawah Batas Buffer</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                            {{-- Filament Soft Pill: Menipis --}}
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Menipis
                            </span>
                        </td>
                        <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 justify-end">
                                <a href="#" class="inline-flex items-center gap-1 font-semibold text-xs text-amber-700 hover:text-amber-900 transition px-2 py-1 rounded-md hover:bg-amber-100/60 cursor-pointer">
                                    <svg class="w-4 h-4 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Lihat</span>
                                </a>
                                <button type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none cursor-pointer" title="Opsi Lainnya">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 14a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 5: Menipis Status --}}
                    <tr class="hover:bg-amber-50/30 bg-amber-50/15 transition duration-75 group">
                        <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                            <span class="font-mono text-xs font-semibold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md ring-1 ring-amber-600/20 inline-block">
                                ITM-2026-155
                            </span>
                        </td>
                        <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                            <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                Toner HP LaserJet 85A (CE285A)
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                Black Monochrome Cartridge, yield ~1,600 lembar
                            </div>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                ATK &amp; Kantor
                            </span>
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Gudang Utama (Rak C-02)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 align-middle">
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-mono font-bold text-amber-700">3 Box</span>
                                    <span class="text-[11px] text-amber-600/80 font-mono font-medium">Min: 8</span>
                                </div>
                                <div class="w-full bg-amber-100 rounded-full h-1.5 overflow-hidden ring-1 ring-amber-200">
                                    <div class="bg-amber-500 h-full rounded-full" style="width: 37%"></div>
                                </div>
                                <span class="text-[10px] text-amber-700 font-medium">Buffer Rendah (0.37x)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Menipis
                            </span>
                        </td>
                        <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-1 justify-end">
                                <a href="#" class="inline-flex items-center gap-1 font-semibold text-xs text-amber-700 hover:text-amber-900 transition px-2 py-1 rounded-md hover:bg-amber-100/60 cursor-pointer">
                                    <svg class="w-4 h-4 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Lihat</span>
                                </a>
                                <button type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none cursor-pointer" title="Opsi Lainnya">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 14a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- TABLE PAGINATION BAR (FILAMENT v3 MINIMALIST PAGINATION) --}}
        <div class="px-4 sm:px-6 py-3.5 border-t border-gray-200/70 bg-white flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-semibold text-gray-900">1</span> sampai <span class="font-semibold text-gray-900">5</span> dari <span class="font-semibold text-gray-900">1,248</span> hasil
            </div>

            <div class="flex items-center gap-4">
                {{-- Per-page selector --}}
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 text-xs hidden md:inline">Per halaman:</span>
                    <select class="bg-gray-50 border border-gray-200 text-gray-700 text-xs rounded-lg px-2.5 py-1 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition cursor-pointer">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                {{-- Pagination controls --}}
                <div class="inline-flex items-center gap-1">
                    {{-- Previous Page --}}
                    <button type="button" 
                            class="p-1.5 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition" 
                            disabled 
                            aria-label="Halaman Sebelumnya">
                        {{-- Heroicon Mini 20x20: chevron-left --}}
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 010 1.06L8.06 10l3.72 3.72a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Page 1 (Active) --}}
                    <button type="button" class="px-3 py-1 rounded-lg bg-amber-50 text-amber-700 font-semibold ring-1 ring-inset ring-amber-600/20 text-xs">
                        1
                    </button>

                    {{-- Page 2 --}}
                    <button type="button" class="px-3 py-1 rounded-lg text-gray-700 hover:bg-gray-100 font-medium text-xs transition">
                        2
                    </button>

                    {{-- Page 3 --}}
                    <button type="button" class="px-3 py-1 rounded-lg text-gray-700 hover:bg-gray-100 font-medium text-xs transition">
                        3
                    </button>

                    <span class="px-1 text-gray-400 font-mono">&hellip;</span>

                    {{-- Next Page --}}
                    <button type="button" 
                            class="p-1.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition cursor-pointer" 
                            aria-label="Halaman Selanjutnya">
                        {{-- Heroicon Mini 20x20: chevron-right --}}
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 010-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // Filter Drawer Toggle Interaction
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtn = document.getElementById('table-filter-toggle-btn');
        const filterDrawer = document.getElementById('table-filter-drawer');

        if (filterBtn && filterDrawer) {
            filterBtn.addEventListener('click', function () {
                filterDrawer.classList.toggle('hidden');
            });
        }
    });
</script>
@endpush

