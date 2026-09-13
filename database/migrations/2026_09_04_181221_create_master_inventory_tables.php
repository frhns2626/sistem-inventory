<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kategori Barang (ATK, Sparepart, Elektronik, Mebel, Kimia)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Satuan Barang / Unit of Measure (pcs, box, kg, rim, roll, unit)
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('symbol', 20)->unique();
            $table->timestamps();
        });

        // 3. Lokasi Gudang (Gudang Utama, Gudang Transit, Gudang Sparepart)
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Katalog / Master Barang
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // Misal: ITM-0001
            $table->string('name', 150);
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('unit_id')->constrained('units')->restrictOnDelete();
            $table->enum('type', ['consumable', 'asset', 'raw_material'])->default('consumable');
            $table->decimal('minimum_stock', 12, 2)->default(0); // Batas peringatan restock
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Stok Barang per Lokasi Gudang
        Schema::create('item_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->timestamps();

            // Mencegah record ganda barang di satu gudang
            $table->unique(['item_id', 'warehouse_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_stocks');
        Schema::dropIfExists('items');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
    }
};
