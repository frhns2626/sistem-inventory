<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\VendorController;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Route;

// Halaman Dashboard Utama
Route::get('/', function () {
    $categories = Category::orderBy('name')->get();
    $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
    $totalItems = Item::count();
    $totalCategories = $categories->count();
    $totalTypes = ItemType::count();

    $items = Item::with(['category', 'unit', 'itemType', 'stocks.warehouse'])
        ->withSum('stocks as total_stock', 'quantity')
        ->latest()
        ->take(10)
        ->get();

    $criticalCount = Item::withSum('stocks as total_stock', 'quantity')
        ->get()
        ->filter(fn ($item) => ($item->total_stock ?? 0) <= ($item->minimum_stock ?? 0))
        ->count();

    return view('pages.dashboard', compact(
        'categories',
        'warehouses',
        'totalItems',
        'totalCategories',
        'totalTypes',
        'items',
        'criticalCount'
    ));
})->name('dashboard');

// Template Dasar Halaman (Starter Template siap ditarik/dicopy)
Route::get('/starter', function () {
    return view('pages.starter');
})->name('starter');

// role switcher untuk pengembangan dan pengujian
Route::get('/dev/login-as/{role}', function (string $role) {
    $user = User::role($role)->first();

    if ($user) {
        auth()->login($user);

        return back()->with('success', "Berhasil beralih akun: {$user->name} (Role: {$role})");
    }

    $firstUser = User::first();
    if ($firstUser) {
        $firstUser->syncRoles([$role]);
        auth()->login($firstUser);

        return back()->with('success', "Role {$role} diterapkan pada {$firstUser->name}");
    }

    return back()->with('warning', "User untuk role [{$role}] tidak ditemukan. Jalankan php artisan db:seed.");
})->name('dev.switch-role');

// Resource route untuk CRUD data barang
Route::resource('items', ItemController::class);

// Resource route untuk Master Tipe Barang (Dinamis)
Route::resource('item-types', ItemTypeController::class);

// Resource route untuk Master Kategori Barang (Dinamis)
Route::resource('categories', CategoryController::class);

// Resource route untuk Master Vendor / Supplier
Route::resource('vendors', VendorController::class);

// Resource route untuk Pengadaan: Purchase Request & Purchase Order
Route::resource('purchase-requests', PurchaseRequestController::class);
Route::resource('purchase-orders', PurchaseOrderController::class);
