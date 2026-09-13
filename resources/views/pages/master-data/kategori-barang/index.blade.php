@extends('layouts.app')

@section('title', 'Kategori Barang')
@section('page-title', 'Kategori Barang')
@section('page-group', 'Master Data')

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
            padding: 12px 16px;
            font-size: 12px;
            color: #475569;
        }
        .dataTables_wrapper .dataTables_filter input {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 4px 8px;
            margin-left: 6px;
            font-size: 12px;
            outline: none;
            transition: border-color 0.15s ease;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #94a3b8;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 3px 6px;
            margin: 0 4px;
            font-size: 12px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 11px;
            color: #64748b;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            padding: 12px 16px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding: 12px 16px !important;
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
                <span>Master Kategori Barang</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Klasifikasi Inventaris
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola klasifikasi dan pengelompokan jenis barang (ATK, IT Hardware, Perkakas, Suku Cadang, dll).</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <button type="button" onclick="openCreateModal()" class="px-3.5 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white font-medium rounded transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>+ Kategori Baru</span>
            </button>
        </div>
    </div>

    {{-- KANVAS TABEL YAJRA DATATABLES --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table id="categories-table" class="dataTable hover stripe w-full text-xs text-left">
                <thead>
                    <tr>
                        <th class="w-12 text-center">#</th>
                        <th class="w-36">Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="w-28 text-center">Jumlah Item</th>
                        <th class="w-24 text-center">Status</th>
                        <th class="w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Diisi secara otomatis oleh AJAX Yajra DataTables --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT KATEGORI --}}
    <div id="category-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-lg border border-zinc-200 shadow-xl max-w-md w-full overflow-hidden">

            <form id="category-form" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div id="category-method-container"></div>

                <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <h3 id="category-modal-title" class="text-sm font-bold text-zinc-900">Tambah Kategori Baru</h3>
                    <button type="button" onclick="closeCategoryModal()" class="text-zinc-400 hover:text-zinc-700 text-lg leading-none cursor-pointer">&times;</button>
                </div>

                <div class="p-5 space-y-3.5 text-xs">
                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Kode Kategori</label>
                        <input type="text" name="code" id="category-code" placeholder="Contoh: CAT-ATK, CAT-HW, CAT-ELK" required
                               class="w-full uppercase font-mono bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                        <span class="text-[10px] text-zinc-400 mt-0.5 block">Kode unik penanda pengelompokan barang.</span>
                    </div>

                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Nama Kategori</label>
                        <input type="text" name="name" id="category-name" placeholder="Contoh: Alat Tulis Kantor, Hardware & IT" required
                               class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Deskripsi Kategori</label>
                        <textarea name="description" id="category-description" rows="2" placeholder="Catatan atau keterangan cakupan kategori ini..."
                                  class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition"></textarea>
                    </div>

                    @if($hasIsActive)
                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_active" id="category-active" value="1" checked class="rounded border-zinc-300 text-zinc-900 focus:ring-0">
                            <label for="category-active" class="text-zinc-700 font-medium">Kategori aktif (muncul di pilihan input barang)</label>
                        </div>
                    @endif
                </div>

                <div class="px-5 py-3.5 bg-zinc-50 border-t border-zinc-100 flex items-center justify-end gap-2 text-xs">
                    <button type="button" onclick="closeCategoryModal()" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-100 text-zinc-700 rounded transition font-medium cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white rounded transition font-medium cursor-pointer">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- jQuery & DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        const catModal = document.getElementById('category-modal');
        const catForm = document.getElementById('category-form');
        const catModalTitle = document.getElementById('category-modal-title');
        const catCodeInput = document.getElementById('category-code');
        const catNameInput = document.getElementById('category-name');
        const catDescInput = document.getElementById('category-description');
        const catActiveInput = document.getElementById('category-active');
        const catMethodContainer = document.getElementById('category-method-container');

        function openCreateModal() {
            catModalTitle.innerText = 'Tambah Kategori Barang Baru';
            catForm.action = "{{ route('categories.store') }}";
            catMethodContainer.innerHTML = '';
            catCodeInput.value = '';
            catNameInput.value = '';
            catDescInput.value = '';
            if (catActiveInput) catActiveInput.checked = true;
            catModal.classList.remove('hidden');
        }

        function openEditModal(category) {
            catModalTitle.innerText = 'Edit Kategori: ' + category.name;
            catForm.action = "{{ url('/categories') }}/" + category.id;
            catMethodContainer.innerHTML = '@method("PUT")';
            catCodeInput.value = category.code;
            catNameInput.value = category.name;
            catDescInput.value = category.description || '';
            if (catActiveInput) catActiveInput.checked = category.is_active ? true : false;
            catModal.classList.remove('hidden');
        }

        function openEditFromBtn(btn) {
            const category = {
                id: btn.getAttribute('data-id'),
                code: btn.getAttribute('data-code'),
                name: btn.getAttribute('data-name'),
                description: btn.getAttribute('data-description'),
                is_active: btn.getAttribute('data-active') === '1'
            };
            openEditModal(category);
        }

        function closeCategoryModal() {
            catModal.classList.add('hidden');
        }

        // Tutup modal jika klik di luar box
        if (catModal) {
            catModal.addEventListener('click', function(e) {
                if (e.target === catModal) closeCategoryModal();
            });
        }

        // Inisialisasi Yajra DataTables Server-Side
        $(document).ready(function () {
            const table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                ajax: "{{ route('categories.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-mono text-xs text-zinc-400' },
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'items_count', name: 'items_count', searchable: false, className: 'text-center' },
                    { data: 'status', name: 'is_active', searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[2, 'asc']], // default urutkan nama kategori A-Z
                language: {
                    processing: '<div class="flex items-center gap-2 text-xs text-zinc-700"><svg class="animate-spin w-4 h-4 text-zinc-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Memuat data kategori...</span></div>',
                    emptyTable: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Belum ada data kategori barang.</div>',
                    zeroRecords: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Tidak ditemukan kategori yang sesuai pencarian.</div>',
                    info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ kategori',
                    infoEmpty: 'Menampilkan 0 data',
                    infoFiltered: '(disaring dari _MAX_ total data)',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: 'Cari kategori:',
                    searchPlaceholder: 'Nama / kode...',
                    paginate: {
                        first: '«',
                        previous: 'Sebelumnya',
                        next: 'Selanjutnya',
                        last: '»'
                    }
                }
            });
        });
    </script>
@endpush
