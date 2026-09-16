@extends('layouts.app')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')
@section('page-group', 'Master Data')

@push('styles')
    {{-- DataTables Core CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* Custom Styling agar DataTables selaras dengan Utilitarian Design SIMBA & Filament v3 */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            font-size: 0.75rem; /* 12px */
            margin: 0 !important;
        }
        table.dataTable thead th {
            background-color: #f9fafb !important;
            color: #475569 !important;
            font-weight: 600 !important;
            border-top: 1px solid #e5e7eb !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 11px 16px !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 0.04em !important;
            white-space: nowrap !important;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        table.dataTable thead th.text-center,
        table.dataTable tbody td.text-center {
            text-align: center !important;
        }
        table.dataTable thead th.text-right,
        table.dataTable tbody td.text-right {
            text-align: right !important;
        }
        table.dataTable tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #1e293b;
            vertical-align: middle;
        }
        table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }
        .dataTables_wrapper {
            padding: 0;
            position: relative;
            clear: both;
        }
        .dataTables_wrapper .dt-top,
        .dataTables_wrapper .dt-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 12px 16px;
            width: 100%;
            background-color: #ffffff;
            box-sizing: border-box;
        }
        .dataTables_wrapper .dt-top {
            border-bottom: 1px solid #f1f5f9;
        }
        .dataTables_wrapper .dt-bottom {
            border-top: 1px solid #f1f5f9;
        }
        .dataTables_wrapper .dt-top .dataTables_length,
        .dataTables_wrapper .dt-top .dataTables_filter,
        .dataTables_wrapper .dt-bottom .dataTables_info,
        .dataTables_wrapper .dt-bottom .dataTables_paginate {
            padding: 0 !important;
            float: none !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .dataTables_length {
            padding: 14px 16px;
            font-size: 12px;
            color: #64748b;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 4px 8px;
            margin: 0 4px;
            font-size: 12px;
            outline: none;
            background-color: #ffffff;
            color: #334155;
            transition: border-color 0.15s ease;
        }
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #f59e0b;
        }
        .dataTables_wrapper .dataTables_filter {
            padding: 12px 16px;
        }
        .dataTables_wrapper .dataTables_filter label {
            display: inline-flex;
            align-items: center;
            position: relative;
            margin: 0;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: #ffffff !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z' /%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 10px center !important;
            background-size: 14px 14px !important;
            padding: 6px 12px 6px 32px !important;
            margin-left: 0 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            color: #1e293b !important;
            width: 220px !important;
            outline: none !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.15s ease !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.15) !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 11px;
            color: #64748b;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            padding: 14px 16px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding: 12px 16px !important;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #475569 !important;
            height: 28px !important;
            min-width: 28px !important;
            padding: 0 8px !important;
            margin: 0 1px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
            background: #f8fafc !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #f59e0b !important;
            color: #ffffff !important;
            border-color: #d97706 !important;
            font-weight: 600 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #ffffff !important;
            color: #cbd5e1 !important;
            border-color: #f1f5f9 !important;
            cursor: not-allowed !important;
            opacity: 0.5 !important;
        }
        .dataTables_wrapper .dataTables_processing {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            color: #0f172a !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 12px 24px !important;
        }
    </style>
@endpush

@section('content')

    {{-- HEADER MODUL --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div>
            <h1 class="text-base font-bold text-zinc-900 tracking-tight flex items-center gap-2">
                <span>Master Data Barang</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Katalog Inventaris
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola seluruh data aset, bahan baku, dan barang operasional inventaris SIMBA.</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <button type="button" onclick="openCreateModal()" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white font-medium rounded-lg transition flex items-center gap-1.5 shadow-xs ring-1 ring-amber-700/20 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Barang Baru</span>
            </button>
        </div>
    </div>

    {{-- TOOLBAR FILTER (TERPISAH DI ATAS DATATABLES) --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs p-3.5 mb-4">
        <div class="flex flex-wrap items-center gap-2 text-xs">
            {{-- Filter Kategori --}}
            <select id="filter-category" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs transition">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            {{-- Filter Tipe Barang --}}
            <select id="filter-type" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs transition">
                <option value="">Semua Tipe</option>
                @foreach ($itemTypes as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select id="filter-status" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs transition">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>

            {{-- Reset Filter Button --}}
            <button type="button" id="btn-reset-filter" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 hover:text-zinc-900 rounded-lg transition flex items-center gap-1.5 shadow-2xs font-medium cursor-pointer" title="Reset Filter">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <span>Reset</span>
            </button>
        </div>
    </div>

    {{-- KANVAS TABEL YAJRA DATATABLES --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs overflow-hidden">
        <table id="items-table" class="dataTable hover stripe w-full text-xs text-left min-w-[1050px]">
            <thead>
                <tr>
                    <th class="w-12 text-center whitespace-nowrap" style="text-align: center !important;">No</th>
                    <th class="w-36 whitespace-nowrap">SKU / Kode</th>
                    <th class="min-w-[200px] whitespace-nowrap">Nama Barang</th>
                    <th class="w-36 whitespace-nowrap">Kategori</th>
                    <th class="w-40 whitespace-nowrap">Tipe</th>
                    <th class="w-28 text-right whitespace-nowrap" style="text-align: right !important;">Stok Fisik</th>
                    <th class="w-28 text-right whitespace-nowrap" style="text-align: right !important;">Min. Buffer</th>
                    <th class="w-24 text-center whitespace-nowrap" style="text-align: center !important;">Status</th>
                    <th class="w-24 text-center whitespace-nowrap" style="text-align: center !important;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Diisi secara otomatis oleh AJAX Yajra DataTables --}}
            </tbody>
        </table>
    </div>

    {{-- MODAL TAMBAH / EDIT BARANG --}}
    <div id="item-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">

            <form id="item-form" method="POST" action="{{ route('items.store') }}">
                @csrf
                <div id="item-method-container"></div>

                <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <h3 id="item-modal-title" class="text-sm font-bold text-zinc-900">Tambah Data Barang Baru</h3>
                    <button type="button" onclick="closeItemModal()" class="text-zinc-400 hover:text-zinc-700 text-lg leading-none cursor-pointer">&times;</button>
                </div>

                <div class="p-5 space-y-3.5 text-xs max-h-[75vh] overflow-y-auto">
                    {{-- Baris 1: Kode / SKU & Nama Barang --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Kode / SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" id="item-code" placeholder="Contoh: ITM-001, ATK-PPR-01" required
                                   class="w-full uppercase font-mono bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                            <span class="text-[10px] text-zinc-400 mt-0.5 block">Kode SKU unik penanda barang inventaris.</span>
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Nama Barang <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" id="item-name" placeholder="Contoh: Kertas HVS A4 80gr" required
                                   class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                        </div>
                    </div>

                    {{-- Baris 2: Kategori & Tipe Barang & Satuan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                            <select name="category_id" id="item-category-id" required
                                    class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Tipe Barang</label>
                            <select name="item_type_id" id="item-type-id"
                                    class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                                <option value="">Pilih Tipe</option>
                                @foreach ($itemTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Satuan <span class="text-rose-500">*</span></label>
                            <select name="unit_id" id="item-unit-id" required
                                    class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                                <option value="">Pilih Satuan</option>
                                @foreach ($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->symbol }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris 3: Min. Buffer Stok & Status Aktif --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Min. Buffer Stok</label>
                            <input type="number" step="any" min="0" name="minimum_stock" id="item-minimum-stock" value="0" placeholder="0"
                                   class="w-full font-mono bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                            <span class="text-[10px] text-zinc-400 mt-0.5 block">Batas peringatan untuk restock barang.</span>
                        </div>

                        <div class="pt-2 sm:pt-0">
                            <label class="block font-medium text-zinc-700 mb-1">Status Katalog</label>
                            <label class="inline-flex items-center gap-2 cursor-pointer mt-1">
                                <input type="checkbox" name="is_active" id="item-is-active" value="1" checked
                                       class="rounded border-zinc-300 text-amber-600 focus:ring-amber-500 w-4 h-4">
                                <span class="text-xs text-zinc-700 font-medium">Barang Aktif</span>
                            </label>
                        </div>
                    </div>

                    {{-- Baris 4: Deskripsi / Spesifikasi Barang --}}
                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Deskripsi / Spesifikasi</label>
                        <textarea name="description" id="item-description" rows="2.5" placeholder="Catatan spesifikasi teknis, merek, atau kegunaan barang..."
                                  class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition"></textarea>
                    </div>
                </div>

                <div class="px-5 py-3.5 bg-zinc-50 border-t border-zinc-100 flex items-center justify-end gap-2 text-xs">
                    <button type="button" onclick="closeItemModal()" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-100 text-zinc-700 rounded-lg transition font-medium cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-1.5 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white rounded-lg transition font-medium cursor-pointer shadow-xs">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS BARANG --}}
    <div id="delete-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-sm w-full p-5 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-zinc-900">Hapus Data Barang?</h3>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed">
                        Apakah Anda yakin ingin menghapus barang <span id="delete-item-name" class="font-semibold text-zinc-900"></span>? Data yang telah dihapus tidak dapat dikembalikan.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex items-center justify-end gap-2 text-xs">
                <button type="button" onclick="closeDeleteModal()" class="px-3.5 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-medium rounded-lg transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-confirm-delete" onclick="executeDeleteItem()" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 active:bg-rose-700 text-white font-medium rounded-lg transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <svg id="btn-delete-spinner" class="animate-spin w-3.5 h-3.5 hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span id="btn-delete-text">Ya, Hapus</span>
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- jQuery & DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        let table;

        // Modal Elements
        const itemModal = document.getElementById('item-modal');
        const itemForm = document.getElementById('item-form');
        const itemModalTitle = document.getElementById('item-modal-title');
        const itemMethodContainer = document.getElementById('item-method-container');
        const itemCodeInput = document.getElementById('item-code');
        const itemNameInput = document.getElementById('item-name');
        const itemCategoryIdInput = document.getElementById('item-category-id');
        const itemTypeIdInput = document.getElementById('item-type-id');
        const itemUnitIdInput = document.getElementById('item-unit-id');
        const itemMinimumStockInput = document.getElementById('item-minimum-stock');
        const itemIsActiveInput = document.getElementById('item-is-active');
        const itemDescInput = document.getElementById('item-description');

        // Delete Modal Elements
        let activeDeleteUrl = null;
        const deleteModal = document.getElementById('delete-modal');
        const deleteItemName = document.getElementById('delete-item-name');
        const btnConfirmDelete = document.getElementById('btn-confirm-delete');
        const btnDeleteSpinner = document.getElementById('btn-delete-spinner');
        const btnDeleteText = document.getElementById('btn-delete-text');

        function openCreateModal() {
            itemModalTitle.innerText = 'Tambah Data Barang Baru';
            itemForm.action = "{{ route('items.store') }}";
            itemMethodContainer.innerHTML = '';
            itemCodeInput.value = '';
            itemNameInput.value = '';
            itemCategoryIdInput.value = '';
            itemTypeIdInput.value = '';
            itemUnitIdInput.value = '';
            itemMinimumStockInput.value = '0';
            itemIsActiveInput.checked = true;
            itemDescInput.value = '';
            itemModal.classList.remove('hidden');
        }

        function openEditModal(item) {
            itemModalTitle.innerText = 'Edit Barang: ' + item.name;
            itemForm.action = "{{ url('/items') }}/" + item.id;
            itemMethodContainer.innerHTML = '@method("PUT")';
            itemCodeInput.value = item.code;
            itemNameInput.value = item.name;
            itemCategoryIdInput.value = item.category_id || '';
            itemTypeIdInput.value = item.item_type_id || '';
            itemUnitIdInput.value = item.unit_id || '';
            itemMinimumStockInput.value = item.minimum_stock || '0';
            itemIsActiveInput.checked = item.is_active == '1' || item.is_active === true;
            itemDescInput.value = item.description || '';
            itemModal.classList.remove('hidden');
        }

        function openEditFromBtn(btn) {
            const item = {
                id: btn.getAttribute('data-id'),
                code: btn.getAttribute('data-code'),
                name: btn.getAttribute('data-name'),
                category_id: btn.getAttribute('data-category_id'),
                item_type_id: btn.getAttribute('data-item_type_id'),
                unit_id: btn.getAttribute('data-unit_id'),
                minimum_stock: btn.getAttribute('data-minimum_stock'),
                description: btn.getAttribute('data-description'),
                is_active: btn.getAttribute('data-is_active')
            };
            openEditModal(item);
        }

        function closeItemModal() {
            itemModal.classList.add('hidden');
        }

        if (itemModal) {
            itemModal.addEventListener('click', function(e) {
                if (e.target === itemModal) closeItemModal();
            });
        }

        // Delete Modal Functions
        function confirmDeleteItem(btn) {
            activeDeleteUrl = btn.getAttribute('data-url');
            const name = btn.getAttribute('data-name');
            if (deleteItemName) deleteItemName.textContent = '"' + name + '"';
            if (deleteModal) deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            if (deleteModal) deleteModal.classList.add('hidden');
            activeDeleteUrl = null;
            if (btnConfirmDelete) btnConfirmDelete.disabled = false;
            if (btnDeleteSpinner) btnDeleteSpinner.classList.add('hidden');
            if (btnDeleteText) btnDeleteText.textContent = 'Ya, Hapus';
        }

        if (deleteModal) {
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) closeDeleteModal();
            });
        }

        function executeDeleteItem() {
            if (!activeDeleteUrl) return;

            if (btnConfirmDelete) btnConfirmDelete.disabled = true;
            if (btnDeleteSpinner) btnDeleteSpinner.classList.remove('hidden');
            if (btnDeleteText) btnDeleteText.textContent = 'Menghapus...';

            $.ajax({
                url: activeDeleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (res) {
                    closeDeleteModal();
                    if (table) table.ajax.reload(null, false);
                    if (window.showToast) {
                        window.showToast(res.message || 'Barang berhasil dihapus.', 'success');
                    }
                },
                error: function (xhr) {
                    closeDeleteModal();
                    const msg = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Terjadi kesalahan saat menghapus data.';
                    if (window.showToast) {
                        window.showToast(msg, 'error');
                    }
                }
            });
        }

        // Inisialisasi Yajra DataTables Server-Side
        $(document).ready(function () {
            table = $('#items-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                pageLength: 10,
                dom: '<"dt-top"lf>r<"overflow-x-auto"t><"dt-bottom"ip>',
                ajax: {
                    url: "{{ route('items.index') }}",
                    data: function (d) {
                        d.category_id  = $('#filter-category').val();
                        d.item_type_id = $('#filter-type').val();
                        d.is_active    = $('#filter-status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-mono text-xs text-zinc-400 whitespace-nowrap' },
                    { data: 'code', name: 'code', className: 'whitespace-nowrap' },
                    { data: 'name', name: 'name' },
                    { data: 'category_name', name: 'category.name', className: 'whitespace-nowrap' },
                    { data: 'type_badge', name: 'itemType.name', className: 'whitespace-nowrap' },
                    { data: 'stock_display', name: 'total_stock', searchable: false, className: 'text-right whitespace-nowrap' },
                    { data: 'minimum_stock', name: 'minimum_stock', className: 'text-right whitespace-nowrap' },
                    { data: 'status_badge', name: 'is_active', className: 'text-center whitespace-nowrap' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center whitespace-nowrap' }
                ],
                order: [[2, 'asc']], // default urutkan nama barang A-Z
                language: {
                    processing: '<div class="flex items-center gap-2 text-xs text-zinc-700"><svg class="animate-spin w-4 h-4 text-zinc-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Memuat data barang...</span></div>',
                    emptyTable: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Belum ada data barang di katalog.</div>',
                    zeroRecords: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Tidak ditemukan barang yang sesuai filter.</div>',
                    info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ barang',
                    infoEmpty: 'Menampilkan 0 data',
                    infoFiltered: '(disaring dari _MAX_ total data)',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: '',
                    searchPlaceholder: 'Cari barang (nama, SKU)...',
                    paginate: {
                        first: '«',
                        previous: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>',
                        next: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>',
                        last: '»'
                    }
                }
            });

            // 1. Filter Dropdown Trigger
            $('#filter-category, #filter-type, #filter-status').on('change', function () {
                table.draw();
            });

            // 2. Tombol Reset Filter
            $('#btn-reset-filter').on('click', function () {
                $('#filter-category').val('');
                $('#filter-type').val('');
                $('#filter-status').val('');
                table.search('').draw();
            });
        });
    </script>
@endpush

