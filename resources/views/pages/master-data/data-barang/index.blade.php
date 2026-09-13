@extends('layouts.app')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

@push('styles')
    {{-- DataTables Core CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* Custom Styling agar DataTables selaras dengan Utilitarian Design SIMBA */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            font-size: 0.75rem; /* 12px */
            margin: 0 !important;
        }
        table.dataTable thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600 !important;
            border-top: 1px solid #e2e8f0 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 10px 14px !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 0.04em !important;
        }
        table.dataTable tbody td {
            padding: 11px 14px !important;
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
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: none; /* Kita ganti dengan Custom Filter Bar SIMBA */
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 11px;
            color: #64748b;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            padding-top: 14px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 10px !important;
            font-size: 11px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 4px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #475569 !important;
            padding: 4px 10px !important;
            margin-left: 2px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            transition: all 0.15s ease;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #0f172a !important;
            color: #ffffff !important;
            border-color: #0f172a !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #f8fafc !important;
            color: #94a3b8 !important;
            border-color: #f1f5f9 !important;
            cursor: not-allowed !important;
        }
        /* Custom Processing overlay */
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

    {{-- HEADER MODUL: Judul, Deskripsi & Tombol Aksi Utama --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div>
            <h1 class="text-base font-bold text-zinc-900 tracking-tight flex items-center gap-2">
                <span>Data Barang</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Master Katalog
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola seluruh data aset, bahan baku, dan barang operasional inventaris SIMBA.</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('categories.index') }}" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-medium rounded transition flex items-center gap-1.5 shadow-xs" title="Kelola Master Kategori">
                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v1.75c0 .621.504 1.125 1.125 1.125h7c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 012.25 16.875V7.125z"/></svg>
                <span>Kategori</span>
            </a>

            <a href="{{ route('item-types.index') }}" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-medium rounded transition flex items-center gap-1.5 shadow-xs" title="Kelola Master Tipe">
                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                <span>Tipe</span>
            </a>

            <button type="button" id="btn-refresh" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-medium rounded transition flex items-center gap-1.5 shadow-xs">
                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <span>Muat Ulang</span>
            </button>

            <a href="{{ route('items.create') }}" class="px-3.5 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white font-medium rounded transition flex items-center gap-1.5 shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>+ Item Baru</span>
            </a>
        </div>
    </div>

    {{-- KANVAS UTAMA --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs overflow-hidden">

        {{-- TOOLBAR FILTER & SEARCH --}}
        <div class="p-3.5 border-b border-zinc-200 bg-zinc-50/50 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">

            {{-- Kiri: Input Pencarian Cepat --}}
            <div class="relative w-full md:w-72">
                <input type="text" id="custom-search" placeholder="Cari nama, SKU/kode, spesifikasi..."
                       class="w-full bg-white border border-zinc-200 text-zinc-900 text-xs rounded px-3 py-1.5 pl-8.5 focus:outline-none focus:border-zinc-400 transition font-sans">
                <svg class="w-3.5 h-3.5 text-zinc-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>

            {{-- Kanan: Dropdown Filter Kategori, Tipe, dan Status --}}
            <div class="flex flex-wrap items-center gap-2">

                {{-- Filter Kategori --}}
                <select id="filter-category" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded px-2.5 py-1.5 focus:outline-none focus:border-zinc-400">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                {{-- Filter Tipe Barang (Dinamis) --}}
                <select id="filter-type" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded px-2.5 py-1.5 focus:outline-none focus:border-zinc-400">
                    <option value="">Semua Tipe</option>
                    @if(isset($itemTypes) && $itemTypes->isNotEmpty())
                        @foreach ($itemTypes as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    @else
                        <option value="consumable">Consumable</option>
                        <option value="asset">Asset</option>
                        <option value="raw_material">Raw Material</option>
                    @endif
                </select>

                {{-- Filter Status --}}
                <select id="filter-status" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded px-2.5 py-1.5 focus:outline-none focus:border-zinc-400">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>

                {{-- Reset Filter --}}
                <button type="button" id="btn-reset-filter" class="px-2.5 py-1.5 text-zinc-500 hover:text-zinc-800 hover:bg-zinc-200/60 rounded transition font-medium" title="Reset Filter">
                    Reset
                </button>
            </div>
        </div>

        {{-- TABEL YAJRA DATATABLES --}}
        <div class="overflow-x-auto">
            <table id="items-table" class="dataTable hover stripe">
                <thead>
                    <tr>
                        <th class="w-10 text-center">#</th>
                        <th class="w-32">SKU / Kode</th>
                        <th>Nama Barang</th>
                        <th class="w-28">Kategori</th>
                        <th class="w-24">Tipe</th>
                        <th class="w-28">Stok Fisik</th>
                        <th class="w-28">Min. Buffer</th>
                        <th class="w-20 text-center">Status</th>
                        <th class="w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Diisi secara otomatis oleh AJAX Yajra DataTables --}}
                </tbody>
            </table>
        </div>

        {{-- FOOTER INFO & PAGINATION CONTAINER --}}
        <div id="table-footer-wrapper" class="p-3.5 border-t border-zinc-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2"></div>

    </div>

@endsection

@push('scripts')
    {{-- jQuery & DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi Yajra DataTables Server-Side
            const table = $('#items-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                dom: 'rt<"#custom-footer"ip>', // Sembunyikan default length & filter, gunakan custom toolbar
                ajax: {
                    url: "{{ route('items.index') }}",
                    data: function (d) {
                        d.category_id = $('#filter-category').val();
                        d.type        = $('#filter-type').val();
                        d.is_active   = $('#filter-status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-mono text-xs text-zinc-400' },
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'category_name', name: 'category.name' },
                    { data: 'type_badge', name: 'type.name' },
                    { data: 'stock_display', name: 'total_stock', searchable: false },
                    { data: 'minimum_stock', name: 'minimum_stock' },
                    { data: 'status_badge', name: 'is_active', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'asc']],
                language: {
                    processing: '<div class="flex items-center gap-2"><svg class="animate-spin w-4 h-4 text-zinc-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Memuat data inventaris...</span></div>',
                    emptyTable: '<div class="py-8 text-center text-zinc-400 font-mono text-xs">Belum ada data barang di database.</div>',
                    zeroRecords: '<div class="py-8 text-center text-zinc-400 font-mono text-xs">Tidak ditemukan barang yang sesuai filter.</div>',
                    info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ data barang',
                    infoEmpty: 'Menampilkan 0 data',
                    infoFiltered: '(disaring dari _MAX_ total data)',
                    paginate: {
                        first: '«',
                        previous: 'Sebelumnya',
                        next: 'Selanjutnya',
                        last: '»'
                    }
                },
                initComplete: function () {
                    // Pindahkan info & pagination ke wrapper footer SIMBA
                    $('#custom-footer').appendTo('#table-footer-wrapper');
                }
            });

            // 1. Live Search dengan Debounce
            let searchTimeout;
            $('#custom-search').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function () {
                    table.search($('#custom-search').val()).draw();
                }, 300);
            });

            // 2. Filter Dropdown Trigger
            $('#filter-category, #filter-type, #filter-status').on('change', function () {
                table.draw();
            });

            // 3. Tombol Reset Filter
            $('#btn-reset-filter').on('click', function () {
                $('#custom-search').val('');
                $('#filter-category').val('');
                $('#filter-type').val('');
                $('#filter-status').val('');
                table.search('').draw();
            });

            // 4. Tombol Refresh Data
            $('#btn-refresh').on('click', function () {
                table.ajax.reload(null, false);
            });
        });
    </script>
@endpush
