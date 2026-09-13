<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;


// Halaman Dashboard Utama
Route::get('/', function () {
    return view('pages.dashboard');
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

use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\CategoryController;

// Resource route untuk CRUD data barang
Route::resource('items', ItemController::class);

// Resource route untuk Master Tipe Barang (Dinamis)
Route::resource('item-types', ItemTypeController::class);

// Resource route untuk Master Kategori Barang (Dinamis)
Route::resource('categories', CategoryController::class);
