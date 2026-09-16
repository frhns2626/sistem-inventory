<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Tampilkan data master katalog barang dengan Yajra DataTables Server-Side.
     */
    public function index(Request $request): View|JsonResponse
    {
        $hasItemTypes = Schema::hasTable('item_types');

        if ($request->ajax()) {
            $relations = ['category', 'unit'];
            if ($hasItemTypes) {
                $relations[] = 'itemType';
            }

            $query = Item::with($relations)
                ->withSum('stocks as total_stock', 'quantity')
                ->select('items.*');

            // 1. Filter Kategori
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // 2. Filter Tipe Barang
            if ($request->filled('item_type_id')) {
                $query->where('item_type_id', $request->item_type_id);
            } elseif ($request->filled('type')) {
                $typeVal = $request->type;
                $query->where(function ($q) use ($typeVal) {
                    $q->where('item_type_id', $typeVal)
                        ->orWhere('type', $typeVal);
                });
            }

            // 3. Filter Status Aktif
            if ($request->filled('is_active') && $request->is_active !== '') {
                $query->where('is_active', $request->is_active);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // Kolom SKU / Kode Barang
                ->editColumn('code', function ($item) {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-1 rounded border border-zinc-200 text-xs tracking-tight whitespace-nowrap inline-block">'
                        .e($item->code)
                        .'</span>';
                })

                // Kolom Nama & Deskripsi
                ->editColumn('name', function ($item) {
                    $desc = $item->description
                        ? '<div class="text-[11px] text-zinc-400 font-sans truncate max-w-sm mt-0.5">'.e($item->description).'</div>'
                        : '';

                    return '<div class="min-w-[180px]"><span class="font-semibold text-zinc-900 leading-snug">'.e($item->name).'</span>'.$desc.'</div>';
                })

                // Kolom Kategori
                ->addColumn('category_name', function ($item) {
                    return '<span class="text-xs text-zinc-600 bg-zinc-50 border border-zinc-200 px-2 py-0.5 rounded font-medium whitespace-nowrap inline-block">'
                        .e($item->category->name ?? '-')
                        .'</span>';
                })

                // Kolom Tipe Barang Dinamis
                ->addColumn('type_badge', function ($item) {
                    $typeName = $item->itemType->name ?? ($item->type ?? '-');
                    $typeCode = $item->itemType->code ?? strtoupper($item->type ?? '');

                    $colors = [
                        'CSM' => 'bg-sky-50 text-sky-700 border-sky-200',
                        'AST' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'RMT' => 'bg-amber-50 text-amber-700 border-amber-200',
                    ];
                    $badgeClass = $colors[$typeCode] ?? 'bg-zinc-100 text-zinc-700 border-zinc-200';

                    return '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded border whitespace-nowrap inline-block '.$badgeClass.'">'
                        .e($typeName)
                        .'</span>';
                })

                // Kolom Stok Fisik (Total dari seluruh gudang)
                ->addColumn('stock_display', function ($item) {
                    $stock = (float) ($item->total_stock ?? 0);
                    $min = (float) ($item->minimum_stock ?? 0);
                    $unit = e($item->unit->symbol ?? ($item->unit->name ?? 'Unit'));

                    if ($stock <= 0) {
                        return '<div class="font-mono text-right whitespace-nowrap"><span class="font-bold text-rose-600">0</span> <span class="text-[11px] text-zinc-400">'.$unit.'</span></div>';
                    } elseif ($stock <= $min) {
                        return '<div class="font-mono text-right whitespace-nowrap"><span class="font-bold text-amber-600">'.$stock.'</span> <span class="text-[11px] text-zinc-400">'.$unit.'</span></div>';
                    } else {
                        return '<div class="font-mono text-right whitespace-nowrap"><span class="font-bold text-zinc-900">'.$stock.'</span> <span class="text-[11px] text-zinc-400">'.$unit.'</span></div>';
                    }
                })

                // Kolom Minimum Buffer Stok
                ->editColumn('minimum_stock', function ($item) {
                    $unit = e($item->unit->symbol ?? ($item->unit->name ?? 'Unit'));

                    return '<div class="text-right font-mono text-xs text-zinc-600 font-medium whitespace-nowrap">'
                        .((float) $item->minimum_stock).' '.$unit
                        .'</div>';
                })

                // Kolom Status Aktif
                ->addColumn('status_badge', function ($item) {
                    if (! $item->is_active) {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200 whitespace-nowrap">Nonaktif</span>';
                    }

                    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">Aktif</span>';
                })

                // Kolom Aksi (Tombol Edit & Hapus Serasi dengan Kategori & Tipe Barang)
                ->addColumn('action', function ($item) {
                    $editBtn = '<button type="button" 
                        data-id="'.$item->id.'" 
                        data-code="'.e($item->code).'" 
                        data-name="'.e($item->name).'" 
                        data-category_id="'.$item->category_id.'" 
                        data-item_type_id="'.($item->item_type_id ?? '').'" 
                        data-unit_id="'.$item->unit_id.'" 
                        data-minimum_stock="'.(float) $item->minimum_stock.'" 
                        data-description="'.e($item->description ?? '').'" 
                        data-is_active="'.($item->is_active ? '1' : '0').'" 
                        onclick="openEditFromBtn(this)" 
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 transition shadow-2xs cursor-pointer" 
                        title="Edit Data Barang">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </button>';

                    $deleteUrl = route('items.destroy', $item->id);
                    $deleteBtn = '<button type="button" 
                        data-url="'.$deleteUrl.'" 
                        data-name="'.e($item->name).'" 
                        onclick="confirmDeleteItem(this)" 
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition shadow-2xs cursor-pointer" 
                        title="Hapus Barang">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                    </button>';

                    return '<div class="flex items-center justify-center gap-1.5 whitespace-nowrap">'.$editBtn.$deleteBtn.'</div>';
                })

                ->rawColumns(['code', 'name', 'category_name', 'type_badge', 'stock_display', 'minimum_stock', 'status_badge', 'action'])
                ->make(true);
        }

        // Data pendukung untuk dropdown form dan filter
        $hasCategories = Schema::hasTable('categories');
        $categories = $hasCategories
            ? Category::orderBy('name')->get()
            : collect();

        $units = Schema::hasTable('units') ? Unit::orderBy('name')->get() : collect();
        $itemTypes = $hasItemTypes
            ? ItemType::orderBy('name')->get()
            : collect();

        return view('pages.master-data.data-barang.index', compact('categories', 'units', 'itemTypes'));
    }

    /**
     * Simpan barang baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:items,code',
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'item_type_id' => 'nullable|exists:item_types,id',
            'minimum_stock' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
        $validated['minimum_stock'] = $validated['minimum_stock'] ?? 0;

        // Sinkronisasi kolom legacy type enum
        if (! empty($validated['item_type_id'])) {
            $typeObj = ItemType::find($validated['item_type_id']);
            if ($typeObj) {
                $validated['type'] = match ($typeObj->code) {
                    'AST' => 'asset',
                    'RMT' => 'raw_material',
                    default => 'consumable',
                };
            }
        }

        $item = Item::create($validated);

        return back()->with('success', "Barang '{$item->name}' ({$item->code}) berhasil ditambahkan.");
    }

    /**
     * Update data barang.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:items,code,'.$item->id,
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'item_type_id' => 'nullable|exists:item_types,id',
            'minimum_stock' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        $validated['minimum_stock'] = $validated['minimum_stock'] ?? 0;

        // Sinkronisasi kolom legacy type enum
        if (! empty($validated['item_type_id'])) {
            $typeObj = ItemType::find($validated['item_type_id']);
            if ($typeObj) {
                $validated['type'] = match ($typeObj->code) {
                    'AST' => 'asset',
                    'RMT' => 'raw_material',
                    default => 'consumable',
                };
            }
        }

        $item->update($validated);

        return back()->with('success', "Data barang '{$item->name}' berhasil diperbarui.");
    }

    /**
     * Hapus barang secara aman.
     */
    public function destroy(Item $item): JsonResponse|RedirectResponse
    {
        try {
            // Cek apakah item masih memiliki stok fisik
            $hasStock = $item->stocks()->where('quantity', '>', 0)->exists();
            if ($hasStock) {
                $msg = "Barang '{$item->name}' tidak dapat dihapus karena masih memiliki saldo stok fisik di gudang.";
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 422);
                }

                return back()->with('error', $msg);
            }

            $name = $item->name;
            $item->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Barang '{$name}' berhasil dihapus.",
                ]);
            }

            return back()->with('success', "Barang '{$name}' berhasil dihapus.");
        } catch (QueryException $e) {
            $msg = "Barang '{$item->name}' tidak dapat dihapus karena sudah tercatat dalam riwayat transaksi logistik.";
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }

            return back()->with('error', $msg);
        }
    }

    /**
     * Fallback redirect untuk route create/edit/show ke index modal.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('items.index');
    }

    public function show(Item $item): RedirectResponse
    {
        return redirect()->route('items.index');
    }

    public function edit(Item $item): RedirectResponse
    {
        return redirect()->route('items.index');
    }
}
