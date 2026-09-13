<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kartu Stok / Mutasi Stok Real-Time (Stock Movements)
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->enum('type', [
                'in_receipt',        // Barang Masuk dari GR
                'out_issue',         // Barang Keluar dari GI
                'adjustment_plus',   // Selisih Lebih dari Stock Opname
                'adjustment_minus'   // Selisih Kurang / Rusak dari Stock Opname
            ]);
            $table->decimal('quantity', 12, 2);
            $table->decimal('balance_before', 12, 2); // Saldo sebelum transaksi
            $table->decimal('balance_after', 12, 2);  // Saldo sesudah transaksi
            $table->string('reference_type')->nullable(); // Model referensi
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['item_id', 'warehouse_id']);
            $table->index(['reference_type', 'reference_id']);
        });

        // 2. Header Pemeriksaan Fisik Gudang (Stock Opname)
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('opname_number', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('conducted_by_id')->constrained('users')->cascadeOnDelete(); // warehouse_staff
            $table->foreignId('verified_by_id')->nullable()->constrained('users')->nullOnDelete(); // warehouse_manager
            $table->date('opname_date');
            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'rejected'
            ])->default('draft');
            $table->text('approval_notes')->nullable();
            $table->timestamps();
        });

        // 3. Detail Item Opname & Selisih
        Schema::create('stock_opname_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_opname_id')->constrained('stock_opnames')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->decimal('system_stock', 12, 2);   // Stok komputer sebelum opname
            $table->decimal('physical_stock', 12, 2); // Hasil hitung fisik di rak
            $table->decimal('difference', 12, 2);     // physical_stock - system_stock
            $table->enum('adjustment_type', ['none', 'plus', 'minus'])->default('none');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opname_items');
        Schema::dropIfExists('stock_opnames');
        Schema::dropIfExists('stock_mutations');
    }
};
