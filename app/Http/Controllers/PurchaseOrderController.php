<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    /**
     * Menampilkan daftar Purchase Order (Server-Side AJAX Yajra DataTables).
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = PurchaseOrder::query()
                ->with(['vendor', 'purchasingOfficer', 'purchaseRequest', 'items.item'])
                ->withCount('items')
                ->select('purchase_orders.*');

            // 1. Filter Status
            if ($request->filled('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // 2. Filter Vendor
            if ($request->filled('vendor_id') && $request->vendor_id !== '') {
                $query->where('vendor_id', $request->vendor_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // Kolom Nomor PO
                ->editColumn('po_number', function (PurchaseOrder $po): string {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-1 rounded border border-zinc-200 text-xs tracking-tight whitespace-nowrap inline-block">'
                        .e($po->po_number)
                        .'</span>';
                })

                // Kolom Rekanan Vendor
                ->addColumn('vendor_info', function (PurchaseOrder $po): string {
                    $vendorName = e($po->vendor->name ?? 'Vendor #'.$po->vendor_id);
                    $pic = $po->vendor->contact_person ? '<div class="text-[11px] text-zinc-400 font-sans mt-0.5 whitespace-nowrap">PIC: '.e($po->vendor->contact_person).'</div>' : '';

                    return '<div class="min-w-[170px]"><span class="font-semibold text-zinc-900 leading-snug">'.$vendorName.'</span>'.$pic.'</div>';
                })

                // Kolom Tanggal Order & Estimasi Kirim
                ->addColumn('order_dates', function (PurchaseOrder $po): string {
                    $orderDate = $po->order_date ? $po->order_date->translatedFormat('d M Y') : '-';
                    $deliveryDate = $po->expected_delivery_date
                        ? '<div class="text-[11px] text-zinc-400 font-sans mt-0.5 whitespace-nowrap">Est: '.$po->expected_delivery_date->translatedFormat('d M Y').'</div>'
                        : '';

                    return '<div class="text-xs font-mono text-zinc-700 whitespace-nowrap">'.$orderDate.$deliveryDate.'</div>';
                })

                // Kolom Referensi PR
                ->addColumn('pr_reference', function (PurchaseOrder $po): string {
                    if (! $po->purchaseRequest) {
                        return '<span class="text-zinc-400 font-mono text-xs whitespace-nowrap">Pesanan Langsung</span>';
                    }

                    return '<span class="px-2 py-0.5 text-[11px] font-mono font-medium rounded bg-zinc-100 text-zinc-700 border border-zinc-200 whitespace-nowrap">'
                        .e($po->purchaseRequest->pr_number)
                        .'</span>';
                })

                // Kolom Grand Total Rupiah
                ->editColumn('grand_total', function (PurchaseOrder $po): string {
                    return '<div class="font-mono text-right font-bold text-zinc-900 text-xs whitespace-nowrap">'
                        .'Rp '.number_format((float) $po->grand_total, 0, ',', '.')
                        .'</div>';
                })

                // Kolom Status
                ->addColumn('status_badge', function (PurchaseOrder $po): string {
                    $badges = [
                        'draft' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200 whitespace-nowrap">Draft</span>',
                        'issued' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-amber-50 text-amber-700 border border-amber-200 whitespace-nowrap">Terkirim ke Vendor</span>',
                        'partially_received' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-sky-50 text-sky-700 border border-sky-200 whitespace-nowrap">Diterima Sebagian</span>',
                        'completed' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">Selesai</span>',
                        'cancelled' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap">Dibatalkan</span>',
                    ];

                    return $badges[$po->status] ?? '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 whitespace-nowrap">'.e($po->status).'</span>';
                })

                // Kolom Aksi
                ->addColumn('action', function (PurchaseOrder $po): string {
                    $viewBtn = '<button type="button" 
                        onclick="showPoDetail('.$po->id.')" 
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 hover:text-sky-600 hover:border-sky-300 hover:bg-sky-50 transition shadow-2xs cursor-pointer" 
                        title="Lihat Lembar PO">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </button>';

                    $deleteBtn = '';
                    if ($po->status === 'draft' || $po->status === 'issued') {
                        $deleteUrl = route('purchase-orders.destroy', $po->id);
                        $deleteBtn = '<button type="button" 
                            data-url="'.$deleteUrl.'" 
                            data-name="'.e($po->po_number).'" 
                            onclick="confirmDeletePo(this)" 
                            class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition shadow-2xs cursor-pointer" 
                            title="Hapus PO">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>';
                    }

                    return '<div class="flex items-center justify-center gap-1.5 whitespace-nowrap">'.$viewBtn.$deleteBtn.'</div>';
                })

                ->rawColumns(['po_number', 'vendor_info', 'order_dates', 'pr_reference', 'grand_total', 'status_badge', 'action'])
                ->make(true);
        }

        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();
        $items = Item::with('unit')->where('is_active', true)->orderBy('name')->get();
        $approvedPrs = PurchaseRequest::where('status', 'approved_dept_head')->orderBy('pr_number')->get();

        return view('pages.pengadaan.purchase-order.index', compact('vendors', 'items', 'approvedPrs'));
    }

    /**
     * Mengambil detail JSON untuk modal pratinjau lembar PO.
     */
    public function show(PurchaseOrder $purchaseOrder): JsonResponse
    {
        $purchaseOrder->load(['vendor', 'purchasingOfficer', 'purchaseRequest.department', 'items.item.unit']);

        return response()->json([
            'success' => true,
            'data' => $purchaseOrder,
        ]);
    }

    /**
     * Menyimpan data Purchase Order baru beserta baris itemnya.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:50|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'purchase_request_id' => 'nullable|exists:purchase_requests,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $qty = (float) $item['quantity'];
                $price = (float) $item['unit_price'];
                $lineSubtotal = $qty * $price;
                $subtotal += $lineSubtotal;

                $itemsData[] = [
                    'item_id' => $item['item_id'],
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $lineSubtotal,
                    'quantity_received' => 0,
                ];
            }

            $taxRate = isset($validated['tax_rate']) ? (float) $validated['tax_rate'] : 11.00;
            $taxAmount = ($subtotal * $taxRate) / 100;
            $discount = isset($validated['discount_amount']) ? (float) $validated['discount_amount'] : 0;
            $grandTotal = max(0, ($subtotal + $taxAmount) - $discount);

            $po = PurchaseOrder::create([
                'po_number' => $validated['po_number'],
                'purchase_request_id' => $validated['purchase_request_id'] ?? null,
                'vendor_id' => $validated['vendor_id'],
                'purchasing_officer_id' => Auth::id() ?? 1,
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discount,
                'grand_total' => $grandTotal,
                'status' => 'issued',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $row) {
                $row['purchase_order_id'] = $po->id;
                PurchaseOrderItem::create($row);
            }

            // Jika dibuat dari PR, ubah status PR menjadi po_created
            if (! empty($validated['purchase_request_id'])) {
                PurchaseRequest::where('id', $validated['purchase_request_id'])->update(['status' => 'po_created']);
            }
        });

        return back()->with('success', "Purchase Order '{$validated['po_number']}' berhasil diterbitkan.");
    }

    /**
     * Menghapus Purchase Order.
     */
    public function destroy(PurchaseOrder $purchaseOrder): JsonResponse|RedirectResponse
    {
        if ($purchaseOrder->goodsReceipts()->count() > 0) {
            $msg = "Purchase Order '{$purchaseOrder->po_number}' tidak dapat dihapus karena sudah memiliki catatan Penerimaan Barang (Goods Receipt).";
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }

            return back()->with('error', $msg);
        }

        $num = $purchaseOrder->po_number;
        DB::transaction(function () use ($purchaseOrder) {
            // Jika ada relasi PR, kembalikan status PR ke approved_dept_head
            if ($purchaseOrder->purchase_request_id) {
                PurchaseRequest::where('id', $purchaseOrder->purchase_request_id)->update(['status' => 'approved_dept_head']);
            }

            $purchaseOrder->items()->delete();
            $purchaseOrder->delete();
        });

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Purchase Order '{$num}' berhasil dihapus.",
            ]);
        }

        return back()->with('success', "Purchase Order '{$num}' berhasil dihapus.");
    }
}
