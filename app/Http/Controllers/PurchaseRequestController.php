<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRequestController extends Controller
{
    /**
     * Menampilkan daftar Purchase Request (Server-Side AJAX Yajra DataTables).
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = PurchaseRequest::query()
                ->with(['requester', 'department', 'deptHead', 'items.unit'])
                ->withCount('items')
                ->select('purchase_requests.*');

            // 1. Filter Status
            if ($request->filled('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // 2. Filter Departemen
            if ($request->filled('department_id') && $request->department_id !== '') {
                $query->where('department_id', $request->department_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // Kolom Nomor PR
                ->editColumn('pr_number', function (PurchaseRequest $pr): string {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-1 rounded border border-zinc-200 text-xs tracking-tight whitespace-nowrap inline-block">'
                        .e($pr->pr_number)
                        .'</span>';
                })

                // Kolom Pemohon & Divisi
                ->addColumn('requester_info', function (PurchaseRequest $pr): string {
                    $requesterName = e($pr->requester->name ?? 'User #'.$pr->requester_id);
                    $deptName = e($pr->department->name ?? '-');

                    return '<div class="min-w-[150px]"><span class="font-semibold text-zinc-900 leading-snug">'.$requesterName.'</span><div class="text-[11px] text-zinc-400 font-sans mt-0.5">'.$deptName.'</div></div>';
                })

                // Kolom Tanggal Kebutuhan
                ->editColumn('required_date', function (PurchaseRequest $pr): string {
                    if (! $pr->required_date) {
                        return '<span class="text-zinc-400 font-mono text-xs">-</span>';
                    }

                    return '<div class="text-xs text-zinc-700 font-mono whitespace-nowrap flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/></svg>'
                        .$pr->required_date->translatedFormat('d M Y')
                        .'</div>';
                })

                // Kolom Jumlah Item
                ->addColumn('items_summary', function (PurchaseRequest $pr): string {
                    $count = $pr->items_count ?? 0;

                    return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-mono font-medium bg-zinc-100 text-zinc-600 border border-zinc-200/60 whitespace-nowrap">'
                        .$count.' item</span>';
                })

                // Kolom Estimasi Total Biaya
                ->addColumn('estimated_total', function (PurchaseRequest $pr): string {
                    $total = $pr->items->sum(function ($item) {
                        return (float) $item->quantity * (float) $item->estimated_price;
                    });

                    return '<div class="font-mono text-right font-semibold text-zinc-900 text-xs whitespace-nowrap">'
                        .'Rp '.number_format($total, 0, ',', '.')
                        .'</div>';
                })

                // Kolom Status
                ->addColumn('status_badge', function (PurchaseRequest $pr): string {
                    $badges = [
                        'draft' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200 whitespace-nowrap">Draft</span>',
                        'pending_dept_head' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-amber-50 text-amber-700 border border-amber-200 whitespace-nowrap">Menunggu Persetujuan</span>',
                        'approved_dept_head' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">Disetujui Kadiv</span>',
                        'rejected_dept_head' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap">Ditolak</span>',
                        'po_created' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-sky-50 text-sky-700 border border-sky-200 whitespace-nowrap">PO Terbit</span>',
                        'cancelled' => '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200 whitespace-nowrap">Dibatalkan</span>',
                    ];

                    return $badges[$pr->status] ?? '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 whitespace-nowrap">'.e($pr->status).'</span>';
                })

                // Kolom Aksi
                ->addColumn('action', function (PurchaseRequest $pr): string {
                    $viewBtn = '<button type="button" 
                        onclick="showPrDetail('.$pr->id.')" 
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 hover:text-sky-600 hover:border-sky-300 hover:bg-sky-50 transition shadow-2xs cursor-pointer" 
                        title="Lihat Detail PR">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </button>';

                    $deleteBtn = '';
                    if ($pr->status === 'draft' || $pr->status === 'pending_dept_head') {
                        $deleteUrl = route('purchase-requests.destroy', $pr->id);
                        $deleteBtn = '<button type="button" 
                            data-url="'.$deleteUrl.'" 
                            data-name="'.e($pr->pr_number).'" 
                            onclick="confirmDeletePr(this)" 
                            class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition shadow-2xs cursor-pointer" 
                            title="Hapus PR">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>';
                    }

                    return '<div class="flex items-center justify-center gap-1.5 whitespace-nowrap">'.$viewBtn.$deleteBtn.'</div>';
                })

                ->rawColumns(['pr_number', 'requester_info', 'required_date', 'items_summary', 'estimated_total', 'status_badge', 'action'])
                ->make(true);
        }

        $departments = Department::orderBy('name')->get();
        $items = Item::with('unit')->orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('pages.pengadaan.purchase-request.index', compact('departments', 'items', 'units'));
    }

    /**
     * Mengambil detail JSON untuk modal pratinjau PR.
     */
    public function show(PurchaseRequest $purchaseRequest): JsonResponse
    {
        $purchaseRequest->load(['requester', 'department', 'deptHead', 'items.unit', 'items.item']);

        return response()->json([
            'success' => true,
            'data' => $purchaseRequest,
        ]);
    }

    /**
     * Menyimpan data pengajuan PR baru beserta detail itemnya.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pr_number' => 'required|string|max:50|unique:purchase_requests,pr_number',
            'department_id' => 'required|exists:departments,id',
            'required_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'nullable|exists:items,id',
            'items.*.item_name' => 'required|string|max:150',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_id' => 'nullable|exists:units,id',
            'items.*.estimated_price' => 'nullable|numeric|min:0',
            'items.*.specification' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $pr = PurchaseRequest::create([
                'pr_number' => $validated['pr_number'],
                'requester_id' => Auth::id() ?? 1,
                'department_id' => $validated['department_id'],
                'status' => 'pending_dept_head',
                'required_date' => $validated['required_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $row) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'item_id' => $row['item_id'] ?? null,
                    'item_name' => $row['item_name'],
                    'quantity' => $row['quantity'],
                    'unit_id' => $row['unit_id'] ?? null,
                    'estimated_price' => $row['estimated_price'] ?? 0,
                    'specification' => $row['specification'] ?? null,
                ]);
            }
        });

        return back()->with('success', "Pengajuan Purchase Request '{$validated['pr_number']}' berhasil dibuat.");
    }

    /**
     * Menghapus Purchase Request.
     */
    public function destroy(PurchaseRequest $purchaseRequest): JsonResponse|RedirectResponse
    {
        if ($purchaseRequest->status === 'po_created' || $purchaseRequest->purchaseOrders()->count() > 0) {
            $msg = "Purchase Request '{$purchaseRequest->pr_number}' tidak dapat dihapus karena telah diterbitkan menjadi Purchase Order (PO).";
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }

            return back()->with('error', $msg);
        }

        $num = $purchaseRequest->pr_number;
        DB::transaction(function () use ($purchaseRequest) {
            $purchaseRequest->items()->delete();
            $purchaseRequest->delete();
        });

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Purchase Request '{$num}' berhasil dihapus.",
            ]);
        }

        return back()->with('success', "Purchase Request '{$num}' berhasil dihapus.");
    }
}
