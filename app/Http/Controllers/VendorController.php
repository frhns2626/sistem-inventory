<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Vendor::query()
                ->withCount('PurchaseOrders')
                ->select('vendors.*');

            // Filter status keaktifan
            if ($request->filled('is_active') && $request->is_active !== '') {
                $query->where('is_active', (bool) $request->is_active);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // Kolom Kode Vendor
                ->editColumn('code', function (Vendor $vendor): string {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-1 rounded border border-zinc-200 text-xs tracking-tight whitespace-nowrap inline-block">'
                        .e($vendor->code)
                        .'</span>';
                })

                // Kolom Nama Vendor & NPWP
                ->editColumn('name', function (Vendor $vendor): string {
                    $taxHtml = $vendor->tax_id
                        ? '<div class="text-[11px] font-mono text-zinc-400 mt-0.5 whitespace-nowrap"><span class="text-zinc-500 font-semibold">NPWP:</span> '.e($vendor->tax_id).'</div>'
                        : '';

                    return '<div class="min-w-[180px]"><span class="font-semibold text-zinc-900 leading-snug">'.e($vendor->name).'</span>'.$taxHtml.'</div>';
                })

                // Kolom Contact Person (PIC)
                ->editColumn('contact_person', function (Vendor $vendor): string {
                    return '<span class="text-xs text-zinc-700 font-medium whitespace-nowrap">'
                        .e($vendor->contact_person ?: '-')
                        .'</span>';
                })

                // Kolom Telepon & Email
                ->addColumn('contact_details', function (Vendor $vendor): string {
                    $phoneHtml = $vendor->phone
                        ? '<div class="text-xs font-mono text-zinc-700 flex items-center gap-1.5 whitespace-nowrap"><svg class="w-3 h-3 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>'.e($vendor->phone).'</div>'
                        : '';

                    $emailHtml = $vendor->email
                        ? '<div class="text-[11px] text-zinc-500 font-sans flex items-center gap-1.5 whitespace-nowrap mt-0.5"><svg class="w-3 h-3 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>'.e($vendor->email).'</div>'
                        : '';

                    if (! $phoneHtml && ! $emailHtml) {
                        return '<span class="text-zinc-400">-</span>';
                    }

                    return '<div>'.$phoneHtml.$emailHtml.'</div>';
                })

                // Kolom Informasi Rekening Bank
                ->addColumn('bank_info', function (Vendor $vendor): string {
                    if (! $vendor->bank_name && ! $vendor->bank_account_number) {
                        return '<span class="text-zinc-400 font-mono text-xs">-</span>';
                    }

                    $bankName = $vendor->bank_name ? '<span class="font-bold text-zinc-800">'.e($vendor->bank_name).'</span>' : '';
                    $accountNo = $vendor->bank_account_number ? '<div class="font-mono text-xs text-zinc-600 font-medium">'.e($vendor->bank_account_number).'</div>' : '';
                    $holder = $vendor->bank_account_holder ? '<div class="text-[10px] text-zinc-400 font-sans truncate max-w-[140px]">a/n '.e($vendor->bank_account_holder).'</div>' : '';

                    return '<div class="whitespace-nowrap leading-tight">'.$bankName.$accountNo.$holder.'</div>';
                })

                // Kolom Status Keaktifan
                ->addColumn('status_badge', function (Vendor $vendor): string {
                    if (! $vendor->is_active) {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200 whitespace-nowrap">Nonaktif</span>';
                    }

                    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">Aktif</span>';
                })

                // Kolom Aksi
                ->addColumn('action', function (Vendor $vendor): string {
                    $editBtn = '<button type="button"
                        data-id="'.$vendor->id.'"
                        data-code="'.e($vendor->code).'"
                        data-name="'.e($vendor->name).'"
                        data-contact_person="'.e($vendor->contact_person ?? '').'"
                        data-phone="'.e($vendor->phone ?? '').'"
                        data-email="'.e($vendor->email ?? '').'"
                        data-address="'.e($vendor->address ?? '').'"
                        data-tax_id="'.e($vendor->tax_id ?? '').'"
                        data-bank_name="'.e($vendor->bank_name ?? '').'"
                        data-bank_account_number="'.e($vendor->bank_account_number ?? '').'"
                        data-bank_account_holder="'.e($vendor->bank_account_holder ?? '').'"
                        data-is_active="'.($vendor->is_active ? '1' : '0').'"
                        onclick="openEditFromBtn(this)"
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 transition shadow-2xs cursor-pointer"
                        title="Edit Data Vendor">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </button>';

                    $deleteBtn = '';
                    $poCount = $vendor->purchase_orders_count ?? 0;
                    if ($poCount === 0) {
                        $deleteUrl = route('vendors.destroy', $vendor->id);
                        $deleteBtn = '<button type="button"
                            data-url="'.$deleteUrl.'"
                            data-name="'.e($vendor->name).'"
                            onclick="confirmDeleteVendor(this)"
                            class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition shadow-2xs cursor-pointer"
                            title="Hapus Vendor">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>';
                    }

                    return '<div class="flex items-center justify-center gap-1.5 whitespace-nowrap">'.$editBtn.$deleteBtn.'</div>';
                })

                ->rawColumns(['code', 'name', 'contact_person', 'contact_details', 'bank_info', 'status_badge', 'action'])
                ->make(true);
        }

        return view('pages.master-data.vendor.index');
    }

    /**
     * Menyimpan data vendor baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:vendors,code',
            'name' => 'required|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $vendor = Vendor::create($validated);

        return back()->with('success', "Vendor '{$vendor->name}' ({$vendor->code}) berhasil ditambahkan.");
    }

    /**
     * Memperbarui data vendor yang sudah ada.
     */
    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:vendors,code,'.$vendor->id,
            'name' => 'required|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $vendor->update($validated);

        return back()->with('success', "Data vendor '{$vendor->name}' berhasil diperbarui.");
    }

    /**
     * Menghapus data vendor dengan proteksi integritas Purchase Order.
     */
    public function destroy(Vendor $vendor): JsonResponse|RedirectResponse
    {
        $poCount = $vendor->PurchaseOrders()->count();

        if ($poCount > 0) {
            $msg = "Vendor '{$vendor->name}' tidak dapat dihapus karena telah terhubung dengan {$poCount} dokumen Purchase Order (PO).";
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }

            return back()->with('error', $msg);
        }

        $name = $vendor->name;
        $vendor->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Vendor '{$name}' berhasil dihapus dari sistem.",
            ]);
        }

        return back()->with('success', "Vendor '{$name}' berhasil dihapus.");
    }
}
