@extends('layouts.app')

@section('title', 'Dashboard Inventaris')
@section('page-title', 'Dashboard')

@section('content')

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

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">{{ number_format($totalItems ?? 0) }}</div>

            <div class="mt-3 flex items-center gap-1.5">
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022-4.14 4.14a.75.75 0 01-1.06 0L8 8.31 2.56 13.75a.75.75 0 01-1.06-1.06l6-6a.75.75 0 011.06 0l2.75 2.75 3.44-3.44-3.022-.81a.75.75 0 01-.531-.919z" clip-rule="evenodd" />
                    </svg>
                    <span>SKU Aktif</span>
                </span>
                <span class="text-xs text-gray-500">di katalog master</span>
            </div>
        </div>

        {{-- Metric Card 2: Kategori Barang --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Total Kategori</span>
                {{-- Heroicon Outline 24x24: tag --}}
                <div class="p-2 rounded-lg bg-amber-50 ring-1 ring-amber-600/10 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">{{ number_format($totalCategories ?? 0) }}</div>

            <div class="mt-3 flex items-center gap-1.5">
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                    <span>Klasifikasi</span>
                </span>
                <span class="text-xs text-gray-500">grup inventaris</span>
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

            <div class="text-3xl font-bold font-mono tracking-tight text-rose-600 mt-3">{{ number_format($criticalCount ?? 0) }}</div>

            <div class="mt-3 flex items-center gap-1.5">
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                    <svg class="w-3.5 h-3.5 text-rose-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M1.5 6.75a.75.75 0 011.06 0L8 12.19l2.72-2.72a.75.75 0 011.06 0l4.14 4.14.81-3.022a.75.75 0 111.449.387l-1.281 4.78a.75.75 0 01-.919.531l-4.78-1.281a.75.75 0 01.388-1.449l3.022.81-3.44-3.44-2.75 2.75a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" clip-rule="evenodd" />
                    </svg>
                    <span>Perhatian</span>
                </span>
                <span class="text-xs text-gray-500">&le; batas buffer minimum</span>
            </div>
        </div>

        {{-- Metric Card 4: Tipe & Gudang --}}
        <div class="bg-white rounded-xl p-5 sm:p-6 shadow-xs ring-1 ring-gray-950/5 relative overflow-hidden transition duration-150 hover:shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider font-mono">Tipe Barang</span>
                {{-- Heroicon Outline 24x24: square-3-stack-3d --}}
                <div class="p-2 rounded-lg bg-gray-50 ring-1 ring-gray-950/5 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3" />
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold font-mono tracking-tight text-gray-950 mt-3">{{ number_format($totalTypes ?? 0) }}</div>

            <div class="mt-3 flex items-center gap-1.5">
                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>{{ $warehouses->count() }} Gudang</span>
                </span>
                <span class="text-xs text-gray-500">lokasi penyimpanan</span>
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
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5 font-mono">Lokasi Gudang</label>
                    <select class="w-full bg-white border border-gray-300 text-gray-800 text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-2xs">
                        <option value="">Semua Lokasi Gudang</option>
                        @foreach ($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
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
                    @forelse ($items as $item)
                        @php
                            $stock = (float) ($item->total_stock ?? 0);
                            $min = (float) ($item->minimum_stock ?? 0);
                            $unit = $item->unit->symbol ?? ($item->unit->name ?? 'Unit');
                            $isCritical = $stock <= $min;
                            $isZero = $stock <= 0;
                            $whName = $item->stocks->first()->warehouse->name ?? 'Gudang Utama';
                            $ratio = $min > 0 ? min(100, round(($stock / $min) * 100)) : 100;
                        @endphp
                        <tr class="hover:bg-gray-50/60 {{ $isCritical ? 'bg-rose-50/15' : '' }} transition duration-75 group">
                            <td class="py-3.5 pl-6 pr-3 whitespace-nowrap align-middle">
                                <span class="font-mono text-xs font-semibold {{ $isCritical ? 'text-rose-700 bg-rose-50 ring-rose-600/20' : 'text-gray-700 bg-gray-100/90 ring-gray-900/5' }} px-2.5 py-1 rounded-md ring-1 inline-block">
                                    {{ $item->code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 align-middle max-w-xs sm:max-w-sm">
                                <div class="font-semibold text-sm text-gray-950 group-hover:text-amber-600 transition duration-150">
                                    {{ $item->name }}
                                </div>
                                @if($item->description)
                                    <div class="text-xs text-gray-500 truncate mt-0.5">
                                        {{ $item->description }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                                <span class="inline-flex items-center gap-1.5 text-xs text-gray-700 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    {{ $item->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 whitespace-nowrap align-middle">
                                <div class="inline-flex items-center gap-1 text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.776 11.776 0 001.038.573l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $whName }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-3 align-middle">
                                <div class="flex flex-col gap-1 min-w-[140px]">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-mono font-semibold {{ $isCritical ? 'text-rose-600 font-bold' : 'text-gray-900' }}">{{ $stock }} {{ $unit }}</span>
                                        <span class="text-[11px] text-gray-400 font-mono">Min: {{ $min }}</span>
                                    </div>
                                    <div class="w-full {{ $isCritical ? 'bg-rose-100 ring-rose-200' : 'bg-gray-100 ring-gray-200/50' }} rounded-full h-1.5 overflow-hidden ring-1">
                                        <div class="{{ $isCritical ? 'bg-rose-500' : 'bg-emerald-500' }} h-full rounded-full" style="width: {{ $ratio }}%"></div>
                                    </div>
                                    <span class="text-[10px] {{ $isCritical ? 'text-rose-600 font-semibold' : 'text-emerald-600 font-medium' }}">
                                        {{ $isCritical ? 'Di bawah buffer' : 'Stok Aman' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-3 text-center whitespace-nowrap align-middle">
                                @if(!$item->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 ring-1 ring-inset ring-gray-500/20">
                                        Nonaktif
                                    </span>
                                @elseif($isZero)
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Habis
                                    </span>
                                @elseif($isCritical)
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Kritis
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Normal
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap align-middle">
                                <a href="{{ route('items.index') }}" class="inline-flex items-center gap-1 font-semibold text-xs text-gray-700 hover:text-amber-600 transition px-2.5 py-1 rounded-md hover:bg-gray-100 cursor-pointer">
                                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Kelola</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 font-mono text-xs">
                                <p class="font-medium text-gray-600 mb-1">Belum ada data barang di inventaris.</p>
                                <p class="text-[11px] text-gray-400">Jalankan <code class="bg-gray-100 text-amber-700 px-1.5 py-0.5 rounded font-bold">php artisan db:seed</code> untuk memuat data contoh melalui seeder.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TABLE FOOTER BAR --}}
        <div class="px-4 sm:px-6 py-3.5 border-t border-gray-200/70 bg-white flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-semibold text-gray-900">{{ $items->count() }}</span> dari <span class="font-semibold text-gray-900">{{ $totalItems ?? 0 }}</span> total barang katalog
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

