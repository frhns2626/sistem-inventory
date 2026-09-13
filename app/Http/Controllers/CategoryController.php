<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $hasCategories = Schema::hasTable('categories');
        $hasIsActive   = $hasCategories && Schema::hasColumn('categories', 'is_active');

        if ($request->ajax()) {
            $query = Category::withCount('items')->select('categories.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('code', function ($cat) {
                    return '<span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded border border-zinc-200 text-[11px]">'
                        . e($cat->code)
                        . '</span>';
                })
                ->editColumn('name', function ($cat) {
                    return '<span class="font-semibold text-zinc-900">' . e($cat->name) . '</span>';
                })
                ->editColumn('description', function ($cat) {
                    return '<span class="text-zinc-500 max-w-sm truncate block">' . e($cat->description ?? '-') . '</span>';
                })
                ->addColumn('items_count', function ($cat) {
                    return '<span class="px-2 py-0.5 bg-zinc-50 border border-zinc-200 rounded text-[11px] font-mono font-semibold text-zinc-800">'
                        . $cat->items_count . ' item</span>';
                })
                ->addColumn('status', function ($cat) {
                    $active = $cat->is_active ?? true;
                    if ($active) {
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>';
                    }
                    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200">Nonaktif</span>';
                })
                ->addColumn('action', function ($cat) {
                    $editBtn = '<button type="button" 
                        data-id="' . $cat->id . '" 
                        data-code="' . e($cat->code) . '" 
                        data-name="' . e($cat->name) . '" 
                        data-description="' . e($cat->description ?? '') . '" 
                        data-active="' . ($cat->is_active ? '1' : '0') . '" 
                        onclick="openEditFromBtn(this)" 
                        class="p-1 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 rounded transition cursor-pointer" title="Edit Kategori">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </button>';

                    $deleteBtn = '';
                    if ($cat->items_count == 0) {
                        $deleteUrl = route('categories.destroy', $cat->id);
                        $csrfToken = csrf_token();
                        $deleteBtn = '<form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus kategori [' . e($cat->name) . ']?\');" class="inline">
                            <input type="hidden" name="_token" value="' . $csrfToken . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="p-1 text-zinc-400 hover:text-rose-600 hover:bg-rose-50 rounded transition cursor-pointer" title="Hapus Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            </button>
                        </form>';
                    }

                    return '<div class="flex items-center justify-center gap-1">' . $editBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['code', 'name', 'description', 'items_count', 'status', 'action'])
                ->make(true);
        }

        $categories = $hasCategories
            ? Category::withCount('items')->orderBy('name')->get()
            : collect();

        return view('pages.master-data.kategori-barang.index', compact('categories', 'hasIsActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:30|unique:categories,code',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        if (Schema::hasColumn('categories', 'is_active')) {
            $validated['is_active'] = $request->has('is_active') ? true : false;
        }

        $category = Category::create($validated);

        return back()->with('success', "Kategori '{$category->name}' ({$category->code}) berhasil ditambahkan.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:30|unique:categories,code,' . $category->id,
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        if (Schema::hasColumn('categories', 'is_active')) {
            $validated['is_active'] = $request->has('is_active') ? true : false;
        }

        $category->update($validated);

        return back()->with('success', "Data kategori '{$category->name}' berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        $usedCount = $category->items()->count();

        if ($usedCount > 0) {
            return back()->with('error', "Kategori '{$category->name}' tidak dapat dihapus karena sedang dipakai oleh {$usedCount} barang.");
        }

        $name = $category->name;
        $category->delete();

        return back()->with('success', "Kategori '{$name}' berhasil dihapus.");
    }
}
