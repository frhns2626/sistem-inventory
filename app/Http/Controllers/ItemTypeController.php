<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ItemTypeController extends Controller
{
    /**
     * Menampilkan daftar master tipe barang beserta jumlah item yang menggunakannya.
     */
    public function index()
    {
        $itemTypes = Schema::hasTable('item_types') 
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
            'code'        => 'required|string|max:30|unique:item_types,code',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        ItemType::create($validated);

        return back()->with('success', 'Tipe barang baru berhasil ditambahkan.');
    }

    /**
     * Update tipe barang yang sudah ada.
     */
    public function update(Request $request, ItemType $itemType)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:30|unique:item_types,code,' . $itemType->id,
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $itemType->update($validated);

        return back()->with('success', 'Data tipe barang berhasil diperbarui.');
    }

    /**
     * Hapus tipe barang (jika belum dipakai oleh barang manapun).
     */
    public function destroy(ItemType $itemType)
    {
        if ($itemType->items()->exists()) {
            return back()->with('warning', 'Tipe barang tidak dapat dihapus karena masih digunakan oleh data barang yang ada.');
        }

        $itemType->delete();

        return back()->with('success', 'Tipe barang berhasil dihapus.');
    }
}
