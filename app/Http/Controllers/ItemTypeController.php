<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class ItemTypeController extends Controller
{
    /**
     * Menampilkan daftar master tipe barang beserta jumlah item yang menggunakannya.
     */
    public function index(Request $request)
    {
        $hasItemTypes = Schema::hasTable('item_types');

        if ($request->ajax()) {
            $query = ItemType::withCount('items')->select('item_types.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('code', function ($type) {
                    return '<span class="font-mono text-xs text-zinc-500 font-medium tracking-tight">'
                        .e($type->code)
                        .'</span>';
                })
                ->editColumn('name', function ($type) {
                    return '<span class="font-semibold text-zinc-900">'.e($type->name).'</span>';
                })
                ->editColumn('description', function ($type) {
                    return '<span class="text-zinc-500 max-w-sm truncate block">'.e($type->description ?? '-').'</span>';
                })
                ->addColumn('items_count', function ($type) {
                    $count = $type->items_count ?? 0;

                    return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-mono font-medium bg-zinc-100 text-zinc-600 border border-zinc-200/60">'
                        .$count.' item</span>';
                })
                ->addColumn('action', function ($type) {
                    $editBtn = '<button type="button" 
                        data-id="'.$type->id.'" 
                        data-code="'.e($type->code).'" 
                        data-name="'.e($type->name).'" 
                        data-description="'.e($type->description ?? '').'" 
                        onclick="openEditFromBtn(this)" 
                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 transition shadow-2xs cursor-pointer" 
                        title="Edit Tipe Barang">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </button>';

                    $deleteBtn = '';
                    if ($type->items_count == 0) {
                        $deleteUrl = route('item-types.destroy', $type->id);
                        $deleteBtn = '<button type="button" 
                            data-url="'.$deleteUrl.'" 
                            data-name="'.e($type->name).'" 
                            onclick="confirmDeleteType(this)" 
                            class="w-7 h-7 inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition shadow-2xs cursor-pointer" 
                            title="Hapus Tipe Barang">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>';
                    }

                    return '<div class="flex items-center justify-center gap-1.5">'.$editBtn.$deleteBtn.'</div>';
                })
                ->rawColumns(['code', 'name', 'description', 'items_count', 'action'])
                ->make(true);
        }

        $itemTypes = $hasItemTypes
            ? ItemType::withCount('items')->orderBy('name')->get()
            : collect();

        return view('pages.master-data.tipe-barang.index', compact('itemTypes'));
    }

    /**
     * Simpan tipe barang baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:item_types,code',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $type = ItemType::create($validated);

        return back()->with('success', "Tipe barang '{$type->name}' ({$type->code}) berhasil ditambahkan.");
    }

    /**
     * Update tipe barang yang sudah ada.
     */
    public function update(Request $request, ItemType $itemType)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:item_types,code,'.$itemType->id,
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $itemType->update($validated);

        return back()->with('success', "Data tipe barang '{$itemType->name}' berhasil diperbarui.");
    }

    /**
     * Hapus tipe barang (jika belum dipakai oleh barang manapun).
     */
    public function destroy(ItemType $itemType)
    {
        $usedCount = $itemType->items()->count();

        if ($usedCount > 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Tipe barang '{$itemType->name}' tidak dapat dihapus karena sedang dipakai oleh {$usedCount} barang.",
                ], 422);
            }

            return back()->with('warning', "Tipe barang '{$itemType->name}' tidak dapat dihapus karena sedang dipakai oleh {$usedCount} barang.");
        }

        $name = $itemType->name;
        $itemType->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Tipe barang '{$name}' berhasil dihapus.",
            ]);
        }

        return back()->with('success', "Tipe barang '{$name}' berhasil dihapus.");
    }
}
