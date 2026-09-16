@extends('layouts.app')

@section('title', 'Vendor / Supplier')
@section('page-title', 'Vendor / Supplier')
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
            width: 240px !important;
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
                <span>Vendor / Supplier</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Mitra Pengadaan
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola seluruh data rekanan, distributor, dan supplier pengadaan barang/jasa SIMBA.</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <button type="button" onclick="openCreateModal()" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white font-medium rounded-lg transition flex items-center gap-1.5 shadow-xs ring-1 ring-amber-700/20 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Vendor Baru</span>
            </button>
        </div>
    </div>

    {{-- TOOLBAR FILTER (TERPISAH DI ATAS DATATABLES) --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs p-3.5 mb-4">
        <div class="flex flex-wrap items-center gap-2 text-xs">
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
                <span>Reset Filter</span>
            </button>
        </div>
    </div>

    {{-- KANVAS TABEL YAJRA DATATABLES --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs overflow-hidden">
        <table id="vendors-table" class="dataTable hover stripe w-full text-xs text-left min-w-[1050px]">
            <thead>
                <tr>
                    <th class="w-12 text-center whitespace-nowrap" style="text-align: center !important;">No</th>
                    <th class="w-32 whitespace-nowrap">Kode Vendor</th>
                    <th class="min-w-[200px] whitespace-nowrap">Nama Vendor & NPWP</th>
                    <th class="w-36 whitespace-nowrap">Kontak Person</th>
                    <th class="w-48 whitespace-nowrap">Telepon & Email</th>
                    <th class="w-44 whitespace-nowrap">Informasi Bank</th>
                    <th class="w-24 text-center whitespace-nowrap" style="text-align: center !important;">Status</th>
                    <th class="w-24 text-center whitespace-nowrap" style="text-align: center !important;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Diisi secara otomatis oleh AJAX Yajra DataTables --}}
            </tbody>
        </table>
    </div>

    {{-- MODAL TAMBAH / EDIT VENDOR --}}
    <div id="vendor-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-2xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">

            <div class="p-4 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50 shrink-0">
                <div>
                    <h3 id="modal-title" class="font-bold text-zinc-900 text-sm">Tambah Vendor Baru</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Lengkapi formulir identitas rekanan pengadaan barang/jasa.</p>
                </div>
                <button type="button" onclick="closeVendorModal()" class="w-7 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-600 rounded-lg hover:bg-zinc-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="vendor-form" method="POST" action="{{ route('vendors.store') }}" class="flex flex-col overflow-hidden flex-1">
                @csrf
                <div id="vendor-method-container"></div>

                <div class="p-5 overflow-y-auto space-y-4 text-xs flex-1">

                    {{-- Informasi Utama --}}
                    <div>
                        <div class="text-[11px] font-mono uppercase font-bold text-zinc-400 mb-2.5 tracking-wider">Informasi Utama</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">Kode Vendor <span class="text-rose-500">*</span></label>
                                <input type="text" name="code" id="vendor-code" required placeholder="Contoh: VND-001" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div class="flex items-center sm:pt-6">
                                <label class="relative inline-flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" name="is_active" id="vendor-is-active" value="1" checked class="w-4 h-4 text-amber-600 rounded border-zinc-300 focus:ring-amber-500 cursor-pointer">
                                    <span class="text-xs font-medium text-zinc-700 select-none">Status Vendor Aktif</span>
                                </label>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-medium text-zinc-700 mb-1">Nama Perusahaan / Rekanan <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="vendor-name" required placeholder="Contoh: PT Belden Kabelindo Nusantara" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-medium text-zinc-700 mb-1">Nomor NPWP / Tax ID</label>
                                <input type="text" name="tax_id" id="vendor-tax-id" placeholder="Contoh: 01.345.678.9-413.000" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>
                        </div>
                    </div>

                    {{-- Kontak & Alamat --}}
                    <div class="pt-3 border-t border-zinc-100">
                        <div class="text-[11px] font-mono uppercase font-bold text-zinc-400 mb-2.5 tracking-wider">Kontak & Alamat</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">Contact Person (PIC)</label>
                                <input type="text" name="contact_person" id="vendor-contact-person" placeholder="Nama PIC / Sales Rep" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">No. Telepon / WhatsApp</label>
                                <input type="text" name="phone" id="vendor-phone" placeholder="021-xxxx / 0812-xxxx" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-medium text-zinc-700 mb-1">Alamat Email</label>
                                <input type="email" name="email" id="vendor-email" placeholder="sales@perusahaan.co.id" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-medium text-zinc-700 mb-1">Alamat Kantor / Pabrik</label>
                                <textarea name="address" id="vendor-address" rows="2" placeholder="Alamat lengkap rekanan vendor..." class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Bank (Opsional) --}}
                    <div class="pt-3 border-t border-zinc-100">
                        <div class="text-[11px] font-mono uppercase font-bold text-zinc-400 mb-2.5 tracking-wider">Rekening Bank Rekanan (Opsional)</div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">Nama Bank</label>
                                <input type="text" name="bank_name" id="vendor-bank-name" placeholder="BCA / Mandiri / BNI" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">Nomor Rekening</label>
                                <input type="text" name="bank_account_number" id="vendor-bank-account-number" placeholder="Nomor rekening" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>

                            <div>
                                <label class="block font-medium text-zinc-700 mb-1">Atas Nama (A/N)</label>
                                <input type="text" name="bank_account_holder" id="vendor-bank-account-holder" placeholder="Nama pemilik rekening" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-3.5 border-t border-zinc-100 bg-zinc-50 flex items-center justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeVendorModal()" class="px-3.5 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-medium rounded-lg transition text-xs cursor-pointer shadow-2xs">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white font-medium rounded-lg transition text-xs cursor-pointer shadow-xs">
                        Simpan Vendor
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS (TAILWIND MODAL - BUKAN BROWSER POPUP) --}}
    <div id="delete-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-sm w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-zinc-900 text-sm">Hapus Vendor?</h4>
                    <p class="text-xs text-zinc-500 mt-0.5">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="mt-4 p-3 bg-zinc-50 rounded-lg border border-zinc-200 text-xs text-zinc-700">
                Apakah Anda yakin ingin menghapus data rekanan <span id="delete-vendor-name" class="font-bold text-zinc-900"></span>?
            </div>

            <div class="mt-5 flex items-center justify-end gap-2">
                <button type="button" onclick="closeDeleteModal()" class="px-3.5 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-medium rounded-lg transition text-xs cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-confirm-delete" onclick="executeDeleteVendor()" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-500 active:bg-rose-700 text-white font-medium rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer">
                    <svg id="btn-delete-spinner" class="animate-spin w-3.5 h-3.5 text-white hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    <span id="btn-delete-text">Ya, Hapus</span>
                </button>
            </div>
        </div>
    </div>

    {{-- FLOATING TOAST NOTIFICATION --}}
    <div id="toast-notification" class="fixed bottom-5 right-5 z-50 hidden transition-all duration-300 transform translate-y-2 opacity-0">
        <div id="toast-body" class="px-4 py-3 rounded-lg shadow-lg border text-xs font-medium flex items-center gap-2 max-w-sm">
            <span id="toast-icon"></span>
            <span id="toast-message"></span>
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
        let activeDeleteUrl = null;

        // Elemen DOM
        const vendorModal = document.getElementById('vendor-modal');
        const vendorForm = document.getElementById('vendor-form');
        const modalTitle = document.getElementById('modal-title');
        const methodContainer = document.getElementById('vendor-method-container');
        const btnSubmit = document.getElementById('btn-submit');

        const vendorCodeInput = document.getElementById('vendor-code');
        const vendorNameInput = document.getElementById('vendor-name');
        const vendorTaxIdInput = document.getElementById('vendor-tax-id');
        const vendorContactPersonInput = document.getElementById('vendor-contact-person');
        const vendorPhoneInput = document.getElementById('vendor-phone');
        const vendorEmailInput = document.getElementById('vendor-email');
        const vendorAddressInput = document.getElementById('vendor-address');
        const vendorBankNameInput = document.getElementById('vendor-bank-name');
        const vendorBankAccountNumberInput = document.getElementById('vendor-bank-account-number');
        const vendorBankAccountHolderInput = document.getElementById('vendor-bank-account-holder');
        const vendorIsActiveInput = document.getElementById('vendor-is-active');

        const deleteModal = document.getElementById('delete-modal');
        const deleteVendorName = document.getElementById('delete-vendor-name');
        const btnConfirmDelete = document.getElementById('btn-confirm-delete');
        const btnDeleteSpinner = document.getElementById('btn-delete-spinner');
        const btnDeleteText = document.getElementById('btn-delete-text');

        // Fungsi Toast Notification
        window.showToast = function(message, type = 'success') {
            const toast = document.getElementById('toast-notification');
            const toastBody = document.getElementById('toast-body');
            const toastIcon = document.getElementById('toast-icon');
            const toastMessage = document.getElementById('toast-message');

            if (!toast) return;

            toastMessage.textContent = message;

            if (type === 'success') {
                toastBody.className = 'px-4 py-3 rounded-lg shadow-lg border text-xs font-medium flex items-center gap-2 max-w-sm bg-emerald-50 text-emerald-800 border-emerald-200';
                toastIcon.innerHTML = '<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            } else {
                toastBody.className = 'px-4 py-3 rounded-lg shadow-lg border text-xs font-medium flex items-center gap-2 max-w-sm bg-rose-50 text-rose-800 border-rose-200';
                toastIcon.innerHTML = '<svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>';
            }

            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 4000);
        };

        // Modal Functions
        function openCreateModal() {
            modalTitle.textContent = 'Tambah Vendor Baru';
            vendorForm.action = "{{ route('vendors.store') }}";
            methodContainer.innerHTML = '';
            btnSubmit.textContent = 'Simpan Vendor';

            vendorCodeInput.value = '';
            vendorNameInput.value = '';
            vendorTaxIdInput.value = '';
            vendorContactPersonInput.value = '';
            vendorPhoneInput.value = '';
            vendorEmailInput.value = '';
            vendorAddressInput.value = '';
            vendorBankNameInput.value = '';
            vendorBankAccountNumberInput.value = '';
            vendorBankAccountHolderInput.value = '';
            vendorIsActiveInput.checked = true;

            vendorModal.classList.remove('hidden');
            setTimeout(() => vendorCodeInput.focus(), 50);
        }

        function openEditModal(vendor) {
            modalTitle.textContent = 'Edit Data Vendor';
            vendorForm.action = `/vendors/${vendor.id}`;
            methodContainer.innerHTML = '@method("PUT")';
            btnSubmit.textContent = 'Perbarui Vendor';

            vendorCodeInput.value = vendor.code || '';
            vendorNameInput.value = vendor.name || '';
            vendorTaxIdInput.value = vendor.tax_id || '';
            vendorContactPersonInput.value = vendor.contact_person || '';
            vendorPhoneInput.value = vendor.phone || '';
            vendorEmailInput.value = vendor.email || '';
            vendorAddressInput.value = vendor.address || '';
            vendorBankNameInput.value = vendor.bank_name || '';
            vendorBankAccountNumberInput.value = vendor.bank_account_number || '';
            vendorBankAccountHolderInput.value = vendor.bank_account_holder || '';
            vendorIsActiveInput.checked = vendor.is_active == '1' || vendor.is_active === true;

            vendorModal.classList.remove('hidden');
        }

        function openEditFromBtn(btn) {
            const vendor = {
                id: btn.getAttribute('data-id'),
                code: btn.getAttribute('data-code'),
                name: btn.getAttribute('data-name'),
                contact_person: btn.getAttribute('data-contact_person'),
                phone: btn.getAttribute('data-phone'),
                email: btn.getAttribute('data-email'),
                address: btn.getAttribute('data-address'),
                tax_id: btn.getAttribute('data-tax_id'),
                bank_name: btn.getAttribute('data-bank_name'),
                bank_account_number: btn.getAttribute('data-bank_account_number'),
                bank_account_holder: btn.getAttribute('data-bank_account_holder'),
                is_active: btn.getAttribute('data-is_active')
            };
            openEditModal(vendor);
        }

        function closeVendorModal() {
            vendorModal.classList.add('hidden');
        }

        if (vendorModal) {
            vendorModal.addEventListener('click', function(e) {
                if (e.target === vendorModal) closeVendorModal();
            });
        }

        // Delete Modal Functions
        function confirmDeleteVendor(btn) {
            activeDeleteUrl = btn.getAttribute('data-url');
            const name = btn.getAttribute('data-name');
            if (deleteVendorName) deleteVendorName.textContent = '"' + name + '"';
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

        function executeDeleteVendor() {
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
                        window.showToast(res.message || 'Vendor berhasil dihapus.', 'success');
                    }
                },
                error: function (xhr) {
                    closeDeleteModal();
                    const msg = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Terjadi kesalahan saat menghapus data vendor.';
                    if (window.showToast) {
                        window.showToast(msg, 'error');
                    }
                }
            });
        }

        // Inisialisasi Yajra DataTables Server-Side
        $(document).ready(function () {
            table = $('#vendors-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                pageLength: 10,
                dom: '<"dt-top"lf>r<"overflow-x-auto"t><"dt-bottom"ip>',
                ajax: {
                    url: "{{ route('vendors.index') }}",
                    data: function (d) {
                        d.is_active = $('#filter-status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-mono text-xs text-zinc-400 whitespace-nowrap' },
                    { data: 'code', name: 'code', className: 'whitespace-nowrap' },
                    { data: 'name', name: 'name' },
                    { data: 'contact_person', name: 'contact_person', className: 'whitespace-nowrap' },
                    { data: 'contact_details', name: 'phone', className: 'whitespace-nowrap' },
                    { data: 'bank_info', name: 'bank_name', className: 'whitespace-nowrap' },
                    { data: 'status_badge', name: 'is_active', className: 'text-center whitespace-nowrap' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center whitespace-nowrap' }
                ],
                order: [[2, 'asc']], // default urutkan nama vendor A-Z
                language: {
                    processing: '<div class="flex items-center gap-2 text-xs text-zinc-700"><svg class="animate-spin w-4 h-4 text-zinc-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Memuat data vendor...</span></div>',
                    emptyTable: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Belum ada data vendor / supplier di database.</div>',
                    zeroRecords: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Tidak ditemukan vendor yang sesuai filter.</div>',
                    info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ vendor',
                    infoEmpty: 'Menampilkan 0 data',
                    infoFiltered: '(disaring dari _MAX_ total data)',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: '',
                    searchPlaceholder: 'Cari vendor (nama, kode, PIC)...',
                    paginate: {
                        first: '«',
                        previous: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>',
                        next: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>',
                        last: '»'
                    }
                }
            });

            // 1. Filter Dropdown Trigger
            $('#filter-status').on('change', function () {
                table.draw();
            });

            // 2. Tombol Reset Filter
            $('#btn-reset-filter').on('click', function () {
                $('#filter-status').val('');
                table.search('').draw();
            });
        });
    </script>
@endpush
