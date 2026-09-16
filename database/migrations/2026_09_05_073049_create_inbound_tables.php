<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Goods Receipt (Bukti Barang Masuk ke Gudang)
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('gr_number', 50)->unique();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->string('delivery_order_number', 100); // Nomor Surat Jalan Vendor
            $table->foreignId('received_by_id')->constrained('users')->cascadeOnDelete(); // warehouse_staff
            $table->foreignId('verified_by_id')->nullable()->constrained('users')->nullOnDelete(); // warehouse_manager
            $table->date('receipt_date');
            $table->enum('status', [
                'pending_verification',
                'verified',
                'rejected',
            ])->default('pending_verification');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Detail Item Barang Masuk & Hasil QC
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_receipt_id')->constrained('goods_receipts')->cascadeOnDelete();
            $table->foreignId('purchase_order_item_id')->constrained('purchase_order_items')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->decimal('quantity_received', 12, 2);
            $table->decimal('quantity_rejected', 12, 2)->default(0); // Cacat / tidak sesuai spek
            $table->text('rejection_reason')->nullable();
            $table->text('condition_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
        Schema::dropIfExists('goods_receipts');
    }
};
