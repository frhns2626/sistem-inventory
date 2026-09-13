<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $hasItemTypes = Schema::hasTable('item_types');

        if ($request->ajax()) {
            $relations = ['category', 'unit'];
            if ($hasItemTypes) {
                $relations[] = 'type';
            }

            $query = Item::with($relations)
                ->withSum('stocks as total_stock', 'quantity')
                ->select('items.*');

            // 1. Filter Kategori (opsional)
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // 2. Filter Tipe Barang (Dinamis)
            if ($request->filled('type')) {
                $typeVal = $request->type;
                $query->where(function ($q) use ($typeVal) {
                    $q->where('item_type_id', $typeVal)
                      ->orWhere('type', $typeVal);
                });
            }

            // 3. Filter Status Aktif
            if ($request->filled('is_active')) {
                $query->where('is_active', $request->is_active);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                // Kolom SKU / Kode
                ->editColumn('code', function ($item) {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-1 rounded border border-zinc-200 text-xs tracking-tight">'
                        . e($item->code)
                        . '</span>';
                })

                // Kolom Nama & Deskripsi Spesifikasi
                ->editColumn('name', function ($item) {
                    $desc = $item->description
                        ? '<div class="text-[11px] text-zinc-400 font-sans truncate max-w-xs mt-0.5">' . e($item->description) . '</div>'
                        : '';
                    return '<div><span class="font-semibold text-zinc-900 leading-snug">' . e($item->name) . '</span>' . $desc . '</div>';
                })

                // Kolom Kategori
                ->addColumn('category_name', function ($item) {
                    return '<span class="text-xs text-zinc-600 bg-zinc-50 border border-zinc-200 px-2 py-0.5 rounded font-medium">'
                        . e($item->category->name ?? '-')
                        . '</span>';
                })

                // Kolom Tipe Barang Dinamis
                ->addColumn('type_badge', function ($item) {
                    $typeName = $item->type->name ?? ($item->type ?? '-');
                    $typeCode = $item->type->code ?? strtoupper($item->type ?? '');

                    $colors = [
                        'CSM' => 'bg-sky-50 text-sky-700 border-sky-200',
                        'AST' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'RMT' => 'bg-amber-50 text-amber-700 border-amber-200',
                    ];
                    $badgeClass = $colors[$typeCode] ?? 'bg-zinc-100 text-zinc-700 border-zinc-200';

                    return '<span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded border ' . $badgeClass . '">'
                        . e($typeName)
                        . '</span>';
                })

                // Kolom Stok Fisik (Total dari semua gudang)
                ->addColumn('stock_display', function ($item) {
                    $stock = (float) ($item->total_stock ?? 0);
                    $min = (float) ($item->minimum_stock ?? 0);
                    $unit = e($item->unit->symbol ?? ($item->unit->name ?? 'Unit'));

                    if ($stock <= 0) {
                        return '<div class="font-mono"><span class="font-bold text-rose-600">0</span> <span class="text-xs text-zinc-400">' . $unit . '</span></div>';
                    } elseif ($stock <= $min) {
                        return '<div class="font-mono"><span class="font-bold text-rose-600">' . $stock . '</span> <span class="text-xs text-zinc-400">' . $unit . '</span></div>';
                    } else {
                        return '<div class="font-mono"><span class="font-bold text-zinc-900">' . $stock . '</span> <span class="text-xs text-zinc-400">' . $unit . '</span></div>';
                    }
                })

                // Kolom Min. Buffer Stok
                ->editColumn('minimum_stock', function ($item) {
                    $unit = e($item->unit->symbol ?? ($item->unit->name ?? 'Unit'));
                    return '<span class="font-mono text-xs text-zinc-600 font-medium">'
                        . ((float) $item->minimum_stock) . ' ' . $unit
                        . '</span>';
                })

                // Kolom Status Stok (Normal vs Kritis vs Habis)
                ->addColumn('status_badge', function ($item) {
                    $stock = (float) ($item->total_stock ?? 0);
                    $min = (float) ($item->minimum_stock ?? 0);

                    if (!$item->is_active) {
                        return '<span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200">Nonaktif</span>';
                    }

                    if ($stock <= 0) {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-rose-50 text-rose-700 border border-rose-200">Habis</span>';
                    } elseif ($stock <= $min) {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-rose-50 text-rose-700 border border-rose-200">Kritis</span>';
                    } else {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Normal</span>';
                    }
                })

                // Kolom Aksi
                ->addColumn('action', function ($item) {
                    $editUrl = route('items.edit', $item->id);
                    $showUrl = route('items.show', $item->id);

                    return '
                    <div class="flex items-center justify-center gap-1">
                        <a href="' . $showUrl . '" class="p-1.5 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 rounded transition" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                        <a href="' . $editUrl . '" class="p-1.5 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 rounded transition" title="Edit Barang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                    </div>';
                })

                ->rawColumns(['code', 'name', 'category_name', 'type_badge', 'stock_display', 'minimum_stock', 'status_badge', 'action'])
                ->make(true);
        }

        // Ambil data pendukung untuk dropdown filter
        $hasCategories = Schema::hasTable('categories');
        $categories = $hasCategories
            ? (Schema::hasColumn('categories', 'is_active')
                ? Category::where('is_active', true)->orderBy('name')->get()
                : Category::orderBy('name')->get())
            : collect();

        $units     = Schema::hasTable('units') ? Unit::orderBy('name')->get() : collect();
        $itemTypes = $hasItemTypes
            ? ItemType::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('pages.master-data.data-barang.index', compact('categories', 'units', 'itemTypes'));
    }

    public function create()
    {
        $hasItemTypes  = Schema::hasTable('item_types');
        $hasCategories = Schema::hasTable('categories');

        $categories = $hasCategories
            ? (Schema::hasColumn('categories', 'is_active')
                ? Category::where('is_active', true)->orderBy('name')->get()
                : Category::orderBy('name')->get())
            : collect();

        $units     = Schema::hasTable('units') ? Unit::orderBy('name')->get() : collect();
        $itemTypes = $hasItemTypes
            ? ItemType::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('pages.master-data.data-barang.create', compact('categories', 'units', 'itemTypes'));
    }

    public function show(Item $item)
    {
        $item->load(['category', 'unit', 'type', 'stocks.warehouse']);
        return view('pages.master-data.data-barang.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $hasItemTypes  = Schema::hasTable('item_types');
        $hasCategories = Schema::hasTable('categories');

        $categories = $hasCategories
            ? (Schema::hasColumn('categories', 'is_active')
                ? Category::where('is_active', true)->orderBy('name')->get()
                : Category::orderBy('name')->get())
            : collect();

        $units     = Schema::hasTable('units') ? Unit::orderBy('name')->get() : collect();
        $itemTypes = $hasItemTypes
            ? ItemType::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('pages.master-data.data-barang.edit', compact('item', 'categories', 'units', 'itemTypes'));
    }
}
