@extends('layouts.app')

@section('title', 'Purchase Order (PO)')
@section('page-title', 'Purchase Order (PO)')
@section('page-group', 'Pengadaan')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            font-size: 0.75rem;
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
                <span>Purchase Order (PO)</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Pesanan Resmi Pemasok
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola penerbitan pesanan pembelian resmi kepada rekanan vendor dan status penerimaannya.</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <button type="button" onclick="openCreateModal()" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white font-medium rounded-lg transition flex items-center gap-1.5 shadow-xs ring-1 ring-amber-700/20 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Buat PO Baru</span>
            </button>
        </div>
    </div>

    {{-- TOOLBAR FILTER --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs p-3.5 mb-4">
        <div class="flex flex-wrap items-center gap-2 text-xs">
            {{-- Filter Status --}}
            <select id="filter-status" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs transition">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="issued">Terkirim ke Vendor</option>
                <option value="partially_received">Diterima Sebagian</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>

            {{-- Filter Vendor --}}
            <select id="filter-vendor" class="bg-white border border-zinc-200 text-zinc-700 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs transition">
                <option value="">Semua Rekanan Vendor</option>
                @foreach ($vendors as $v)
                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
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
        <table id="pos-table" class="dataTable hover stripe w-full text-xs text-left min-w-[1050px]">
            <thead>
                <tr>
                    <th class="w-12 text-center whitespace-nowrap" style="text-align: center !important;">No</th>
                    <th class="w-32 whitespace-nowrap">Nomor PO</th>
                    <th class="min-w-[180px] whitespace-nowrap">Rekanan Vendor</th>
                    <th class="w-36 whitespace-nowrap">Tgl Order & Kirim</th>
                    <th class="w-32 whitespace-nowrap">Referensi PR</th>
                    <th class="w-36 text-right whitespace-nowrap" style="text-align: right !important;">Grand Total</th>
                    <th class="w-36 text-center whitespace-nowrap" style="text-align: center !important;">Status</th>
                    <th class="w-24 text-center whitespace-nowrap" style="text-align: center !important;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Diisi otomatis oleh AJAX Yajra DataTables --}}
            </tbody>
        </table>
    </div>

    {{-- MODAL TAMBAH PURCHASE ORDER (MULTI-ITEM & LIVE CALC) --}}
    <div id="po-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-3xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">

            <div class="p-4 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50 shrink-0">
                <div>
                    <h3 class="font-bold text-zinc-900 text-sm">Terbitkan Purchase Order (PO) Baru</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Surat pesanan pembelian resmi kepada vendor rekanan terpilih.</p>
                </div>
                <button type="button" onclick="closePoModal()" class="w-7 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-600 rounded-lg hover:bg-zinc-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="po-form" method="POST" action="{{ route('purchase-orders.store') }}" class="flex flex-col overflow-hidden flex-1">
                @csrf

                <div class="p-5 overflow-y-auto space-y-4 text-xs flex-1">

                    {{-- Informasi Header PO --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Nomor PO <span class="text-rose-500">*</span></label>
                            <input type="text" name="po_number" id="po-number" required value="PO-{{ date('Y') }}-{{ str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) }}" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Vendor / Supplier <span class="text-rose-500">*</span></label>
                            <select name="vendor_id" id="po-vendor" required class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                                <option value="">Pilih Vendor</option>
                                @foreach ($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Referensi PR (Opsional)</label>
                            <select name="purchase_request_id" id="po-pr-id" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                                <option value="">Tanpa PR (Pesanan Langsung)</option>
                                @foreach ($approvedPrs as $apr)
                                    <option value="{{ $apr->id }}">{{ $apr->pr_number }} - {{ $apr->department->name ?? 'Divisi' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Tanggal Pesanan <span class="text-rose-500">*</span></label>
                            <input type="date" name="order_date" id="po-order-date" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Estimasi Tanggal Kirim</label>
                            <input type="date" name="expected_delivery_date" id="po-delivery-date" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                        </div>

                        <div>
                            <label class="block font-medium text-zinc-700 mb-1">Tarif PPN (%)</label>
                            <input type="number" step="0.01" name="tax_rate" id="po-tax-rate" value="11" oninput="calculatePoTotals()" class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs font-mono focus:outline-none focus:border-amber-500 shadow-2xs">
                        </div>

                        <div class="sm:col-span-3">
                            <label class="block font-medium text-zinc-700 mb-1">Catatan Pengiriman / Terms</label>
                            <input type="text" name="notes" id="po-notes" placeholder="Contoh: Pengiriman via ekspedisi rekanan langsung ke Gudang Utama..." class="w-full px-3 py-2 border border-zinc-200 rounded-lg text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-2xs">
                        </div>
                    </div>

                    {{-- Tabel Baris Item Pesanan --}}
                    <div class="pt-3 border-t border-zinc-100">
                        <div class="flex items-center justify-between mb-2.5">
                            <span class="text-[11px] font-mono uppercase font-bold text-zinc-400 tracking-wider">Rincian Barang yang Dipesan</span>
                            <button type="button" onclick="addPoItemRow()" class="px-2.5 py-1 bg-amber-50 border border-amber-200 hover:bg-amber-100 text-amber-800 rounded-lg font-medium transition text-xs flex items-center gap-1 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                <span>Tambah Baris</span>
                            </button>
                        </div>

                        <div class="border border-zinc-200 rounded-lg overflow-hidden">
                            <table class="w-full text-left text-xs" id="po-items-table">
                                <thead class="bg-zinc-50 text-zinc-600 text-[11px] uppercase border-b border-zinc-200">
                                    <tr>
                                        <th class="p-2.5">Pilih Barang Master</th>
                                        <th class="p-2.5 w-24">Jumlah</th>
                                        <th class="p-2.5 w-36">Harga Satuan (Rp)</th>
                                        <th class="p-2.5 w-36 text-right">Subtotal (Rp)</th>
                                        <th class="p-2.5 w-10 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="po-items-body" class="divide-y divide-zinc-100">
                                    <tr class="po-row">
                                        <td class="p-2">
                                            <select name="items[0][item_id]" required class="w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs focus:outline-none focus:border-amber-500">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-2">
                                            <input type="number" step="0.01" min="0.01" name="items[0][quantity]" required value="1" oninput="calculatePoTotals()" class="po-qty w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs font-mono focus:outline-none focus:border-amber-500">
                                        </td>
                                        <td class="p-2">
                                            <input type="number" min="0" name="items[0][unit_price]" required value="0" oninput="calculatePoTotals()" class="po-price w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs font-mono text-right focus:outline-none focus:border-amber-500">
                                        </td>
                                        <td class="p-2 text-right font-mono font-semibold text-zinc-900 po-subtotal">
                                            Rp 0
                                        </td>
                                        <td class="p-2 text-center">
                                            <button type="button" onclick="removePoItemRow(this)" class="text-zinc-400 hover:text-rose-600 transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Kotak Kalkulasi Tagihan --}}
                        <div class="mt-3 flex justify-end">
                            <div class="w-72 bg-zinc-50 p-3.5 rounded-lg border border-zinc-200 space-y-1.5 text-xs">
                                <div class="flex justify-between text-zinc-600">
                                    <span>Subtotal:</span>
                                    <span id="calc-subtotal" class="font-mono">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-zinc-600">
                                    <span>PPN (11%):</span>
                                    <span id="calc-tax" class="font-mono">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-zinc-600 items-center">
                                    <span>Diskon (Rp):</span>
                                    <input type="number" min="0" name="discount_amount" id="po-discount" value="0" oninput="calculatePoTotals()" class="w-24 px-2 py-0.5 border border-zinc-200 rounded text-right font-mono text-xs focus:outline-none">
                                </div>
                                <div class="pt-2 border-t border-zinc-200 flex justify-between font-bold text-zinc-900 text-sm">
                                    <span>Grand Total:</span>
                                    <span id="calc-grandtotal" class="font-mono text-amber-600">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-3.5 border-t border-zinc-100 bg-zinc-50 flex items-center justify-end gap-2 shrink-0">
                    <button type="button" onclick="closePoModal()" class="px-3.5 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-medium rounded-lg transition text-xs cursor-pointer shadow-2xs">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-500 active:bg-amber-700 text-white font-medium rounded-lg transition text-xs cursor-pointer shadow-xs">
                        Terbitkan Purchase Order
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- MODAL LEMBAR DETAIL DOKUMEN PO --}}
    <div id="po-detail-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-2xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">

            <div class="p-4 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50 shrink-0">
                <div class="flex items-center gap-2.5">
                    <span id="detail-po-number" class="font-mono font-bold text-zinc-900 text-sm bg-zinc-100 px-2.5 py-1 rounded border border-zinc-200"></span>
                    <span id="detail-po-status"></span>
                </div>
                <button type="button" onclick="closePoDetailModal()" class="w-7 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-600 rounded-lg hover:bg-zinc-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-5 overflow-y-auto space-y-4 text-xs flex-1">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-zinc-50/80 p-3.5 rounded-lg border border-zinc-100">
                    <div>
                        <div class="text-[10px] uppercase font-mono text-zinc-400">Pemasok / Vendor</div>
                        <div id="detail-po-vendor" class="font-semibold text-zinc-900 mt-0.5"></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase font-mono text-zinc-400">Tgl Order</div>
                        <div id="detail-po-orderdate" class="font-mono text-zinc-700 mt-0.5"></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase font-mono text-zinc-400">Est. Tgl Kirim</div>
                        <div id="detail-po-delivery" class="font-mono text-zinc-700 mt-0.5"></div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase font-mono text-zinc-400">Referensi PR</div>
                        <div id="detail-po-pr" class="font-mono text-zinc-700 mt-0.5"></div>
                    </div>
                    <div class="col-span-2 sm:col-span-4 pt-2 border-t border-zinc-200/60">
                        <div class="text-[10px] uppercase font-mono text-zinc-400">Catatan Pengiriman</div>
                        <div id="detail-po-notes" class="text-zinc-600 mt-0.5 italic"></div>
                    </div>
                </div>

                <div>
                    <div class="text-[11px] font-mono uppercase font-bold text-zinc-400 mb-2 tracking-wider">Daftar Barang yang Dipesan</div>
                    <div class="border border-zinc-200 rounded-lg overflow-hidden">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-zinc-50 text-zinc-600 text-[11px] uppercase border-b border-zinc-200">
                                <tr>
                                    <th class="p-2.5">No</th>
                                    <th class="p-2.5">Nama Barang</th>
                                    <th class="p-2.5 text-center">Qty</th>
                                    <th class="p-2.5 text-right">Harga Satuan</th>
                                    <th class="p-2.5 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detail-po-items-body" class="divide-y divide-zinc-100"></tbody>
                            <tfoot class="bg-zinc-50 border-t border-zinc-200 text-xs">
                                <tr>
                                    <td colspan="4" class="p-2 text-right text-zinc-500">Subtotal:</td>
                                    <td id="detail-po-subtotal" class="p-2 text-right font-mono"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="p-2 text-right text-zinc-500">PPN (11%):</td>
                                    <td id="detail-po-tax" class="p-2 text-right font-mono"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="p-2 text-right text-zinc-500">Diskon:</td>
                                    <td id="detail-po-discount" class="p-2 text-right font-mono"></td>
                                </tr>
                                <tr class="font-bold text-zinc-900 border-t border-zinc-200 text-sm">
                                    <td colspan="4" class="p-2 text-right">Grand Total:</td>
                                    <td id="detail-po-grandtotal" class="p-2 text-right font-mono text-amber-600"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-3.5 border-t border-zinc-100 bg-zinc-50 flex items-center justify-end shrink-0">
                <button type="button" onclick="closePoDetailModal()" class="px-4 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-medium rounded-lg transition text-xs cursor-pointer shadow-2xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="delete-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-2xl max-w-sm w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-zinc-900 text-sm">Hapus Purchase Order?</h4>
                    <p class="text-xs text-zinc-500 mt-0.5">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="mt-4 p-3 bg-zinc-50 rounded-lg border border-zinc-200 text-xs text-zinc-700">
                Apakah Anda yakin ingin menghapus dokumen <span id="delete-po-name" class="font-bold text-zinc-900"></span>?
            </div>

            <div class="mt-5 flex items-center justify-end gap-2">
                <button type="button" onclick="closeDeleteModal()" class="px-3.5 py-2 bg-white border border-zinc-200 hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-medium rounded-lg transition text-xs cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-confirm-delete" onclick="executeDeletePo()" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-500 active:bg-rose-700 text-white font-medium rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer">
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        let table;
        let activeDeleteUrl = null;
        let poItemIndex = 1;

        const poItemsOptions = `@foreach ($items as $item)<option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>@endforeach`;

        // Toast
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
            setTimeout(() => toast.classList.remove('translate-y-2', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 4000);
        };

        // Form Modal
        function openCreateModal() {
            document.getElementById('po-modal').classList.remove('hidden');
            calculatePoTotals();
        }

        function closePoModal() {
            document.getElementById('po-modal').classList.add('hidden');
        }

        function addPoItemRow() {
            const tbody = document.getElementById('po-items-body');
            const tr = document.createElement('tr');
            tr.className = 'po-row';
            tr.innerHTML = `
                <td class="p-2">
                    <select name="items[${poItemIndex}][item_id]" required class="w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs focus:outline-none focus:border-amber-500">
                        <option value="">Pilih Barang</option>
                        ${poItemsOptions}
                    </select>
                </td>
                <td class="p-2">
                    <input type="number" step="0.01" min="0.01" name="items[${poItemIndex}][quantity]" required value="1" oninput="calculatePoTotals()" class="po-qty w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs font-mono focus:outline-none focus:border-amber-500">
                </td>
                <td class="p-2">
                    <input type="number" min="0" name="items[${poItemIndex}][unit_price]" required value="0" oninput="calculatePoTotals()" class="po-price w-full px-2.5 py-1.5 border border-zinc-200 rounded text-xs font-mono text-right focus:outline-none focus:border-amber-500">
                </td>
                <td class="p-2 text-right font-mono font-semibold text-zinc-900 po-subtotal">
                    Rp 0
                </td>
                <td class="p-2 text-center">
                    <button type="button" onclick="removePoItemRow(this)" class="text-zinc-400 hover:text-rose-600 transition p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            poItemIndex++;
            calculatePoTotals();
        }

        function removePoItemRow(btn) {
            const rows = document.querySelectorAll('.po-row');
            if (rows.length > 1) {
                btn.closest('tr').remove();
                calculatePoTotals();
            } else {
                alert('Minimal harus ada 1 baris barang dalam Purchase Order.');
            }
        }

        function calculatePoTotals() {
            let subtotal = 0;
            $('.po-row').each(function() {
                const qty = parseFloat($(this).find('.po-qty').val()) || 0;
                const price = parseFloat($(this).find('.po-price').val()) || 0;
                const lineSubtotal = qty * price;
                subtotal += lineSubtotal;
                $(this).find('.po-subtotal').text('Rp ' + lineSubtotal.toLocaleString('id-ID'));
            });

            const taxRate = parseFloat($('#po-tax-rate').val()) || 0;
            const taxAmount = (subtotal * taxRate) / 100;
            const discount = parseFloat($('#po-discount').val()) || 0;
            const grandTotal = Math.max(0, (subtotal + taxAmount) - discount);

            $('#calc-subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
            $('#calc-tax').text('Rp ' + taxAmount.toLocaleString('id-ID'));
            $('#calc-grandtotal').text('Rp ' + grandTotal.toLocaleString('id-ID'));
        }

        // Detail Modal
        function showPoDetail(id) {
            $.get(`/purchase-orders/${id}`, function(res) {
                if (res.success && res.data) {
                    const po = res.data;
                    document.getElementById('detail-po-number').textContent = po.po_number;
                    document.getElementById('detail-po-vendor').textContent = po.vendor ? po.vendor.name : '-';
                    document.getElementById('detail-po-orderdate').textContent = po.order_date ? new Date(po.order_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                    document.getElementById('detail-po-delivery').textContent = po.expected_delivery_date ? new Date(po.expected_delivery_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                    document.getElementById('detail-po-pr').textContent = po.purchase_request ? po.purchase_request.pr_number : 'Pesanan Langsung';
                    document.getElementById('detail-po-notes').textContent = po.notes ? `"${po.notes}"` : 'Tidak ada catatan.';

                    const statusBadges = {
                        'draft': '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-zinc-100 text-zinc-600 border border-zinc-200">Draft</span>',
                        'issued': '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-amber-50 text-amber-700 border border-amber-200">Terkirim ke Vendor</span>',
                        'partially_received': '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-sky-50 text-sky-700 border border-sky-200">Diterima Sebagian</span>',
                        'completed': '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>',
                        'cancelled': '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-rose-50 text-rose-700 border border-rose-200">Dibatalkan</span>',
                    };
                    document.getElementById('detail-po-status').innerHTML = statusBadges[po.status] || po.status;

                    // Items
                    const tbody = document.getElementById('detail-po-items-body');
                    tbody.innerHTML = '';

                    (po.items || []).forEach((item, index) => {
                        const itemName = item.item ? item.item.name : 'Barang #' + item.item_id;
                        const itemCode = item.item ? item.item.code : '';
                        const unitName = (item.item && item.item.unit) ? item.item.unit.name : 'Unit';
                        const qty = parseFloat(item.quantity) || 0;
                        const price = parseFloat(item.unit_price) || 0;
                        const subtotal = parseFloat(item.subtotal) || (qty * price);

                        tbody.innerHTML += `
                            <tr>
                                <td class="p-2.5 text-center font-mono text-zinc-400">${index + 1}</td>
                                <td class="p-2.5">
                                    <div class="font-semibold text-zinc-900">${itemName}</div>
                                    <div class="text-[11px] font-mono text-zinc-400">${itemCode}</div>
                                </td>
                                <td class="p-2.5 text-center font-mono">${qty} <span class="text-zinc-400 text-[11px]">${unitName}</span></td>
                                <td class="p-2.5 text-right font-mono">Rp ${price.toLocaleString('id-ID')}</td>
                                <td class="p-2.5 text-right font-mono font-semibold">Rp ${subtotal.toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });

                    document.getElementById('detail-po-subtotal').textContent = `Rp ${parseFloat(po.subtotal || 0).toLocaleString('id-ID')}`;
                    document.getElementById('detail-po-tax').textContent = `Rp ${parseFloat(po.tax_amount || 0).toLocaleString('id-ID')}`;
                    document.getElementById('detail-po-discount').textContent = `- Rp ${parseFloat(po.discount_amount || 0).toLocaleString('id-ID')}`;
                    document.getElementById('detail-po-grandtotal').textContent = `Rp ${parseFloat(po.grand_total || 0).toLocaleString('id-ID')}`;

                    document.getElementById('po-detail-modal').classList.remove('hidden');
                }
            });
        }

        function closePoDetailModal() {
            document.getElementById('po-detail-modal').classList.add('hidden');
        }

        // Delete Modal
        function confirmDeletePo(btn) {
            activeDeleteUrl = btn.getAttribute('data-url');
            document.getElementById('delete-po-name').textContent = '"' + btn.getAttribute('data-name') + '"';
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            activeDeleteUrl = null;
        }

        function executeDeletePo() {
            if (!activeDeleteUrl) return;
            $('#btn-delete-spinner').removeClass('hidden');
            $('#btn-delete-text').text('Menghapus...');

            $.ajax({
                url: activeDeleteUrl,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(res) {
                    closeDeleteModal();
                    table.ajax.reload(null, false);
                    showToast(res.message || 'PO berhasil dihapus.', 'success');
                    $('#btn-delete-spinner').addClass('hidden');
                    $('#btn-delete-text').text('Ya, Hapus');
                },
                error: function(xhr) {
                    closeDeleteModal();
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal menghapus PO.';
                    showToast(msg, 'error');
                    $('#btn-delete-spinner').addClass('hidden');
                    $('#btn-delete-text').text('Ya, Hapus');
                }
            });
        }

        // DataTables
        $(document).ready(function() {
            table = $('#pos-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                pageLength: 10,
                dom: '<"dt-top"lf>r<"overflow-x-auto"t><"dt-bottom"ip>',
                ajax: {
                    url: "{{ route('purchase-orders.index') }}",
                    data: function(d) {
                        d.status = $('#filter-status').val();
                        d.vendor_id = $('#filter-vendor').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-mono text-xs text-zinc-400 whitespace-nowrap' },
                    { data: 'po_number', name: 'po_number', className: 'whitespace-nowrap' },
                    { data: 'vendor_info', name: 'vendor.name' },
                    { data: 'order_dates', name: 'order_date', className: 'whitespace-nowrap' },
                    { data: 'pr_reference', name: 'purchaseRequest.pr_number', className: 'whitespace-nowrap' },
                    { data: 'grand_total', name: 'grand_total', className: 'text-right whitespace-nowrap' },
                    { data: 'status_badge', name: 'status', className: 'text-center whitespace-nowrap' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center whitespace-nowrap' }
                ],
                order: [[1, 'desc']],
                language: {
                    processing: '<div class="flex items-center gap-2 text-xs text-zinc-700"><svg class="animate-spin w-4 h-4 text-zinc-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Memuat Purchase Order...</span></div>',
                    emptyTable: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Belum ada dokumen Purchase Order di sistem.</div>',
                    zeroRecords: '<div class="py-6 text-center text-zinc-400 font-mono text-xs">Tidak ditemukan PO yang sesuai filter.</div>',
                    info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ PO',
                    infoEmpty: 'Menampilkan 0 data',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: '',
                    searchPlaceholder: 'Cari PO (nomor, vendor)...',
                    paginate: {
                        first: '«',
                        previous: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>',
                        next: '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>',
                        last: '»'
                    }
                }
            });

            $('#filter-status, #filter-vendor').on('change', function() {
                table.draw();
            });

            $('#btn-reset-filter').on('click', function() {
                $('#filter-status').val('');
                $('#filter-vendor').val('');
                table.search('').draw();
            });
        });
    </script>
@endpush
