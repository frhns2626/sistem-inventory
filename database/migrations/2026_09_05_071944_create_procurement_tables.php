<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Purchase Request (Permohonan Pengadaan Barang Baru oleh Divisi)
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number', 50)->unique();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->enum('status', [
                'draft',
                'pending_dept_head',
                'approved_dept_head',
                'rejected_dept_head',
                'po_created',
                'cancelled',
            ])->default('draft');
            $table->date('required_date')->nullable();
            $table->foreignId('dept_head_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dept_head_action_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Detail Item PR
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete(); // Nullable jika item baru belum ada di master
            $table->string('item_name', 150);
            $table->decimal('quantity', 12, 2);
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->decimal('estimated_price', 15, 2)->default(0);
            $table->text('specification')->nullable();
            $table->timestamps();
        });

        // 3. Purchase Order (Pesanan Pembelian Resmi ke Vendor oleh Purchasing)
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number', 50)->unique();
            $table->foreignId('purchase_request_id')->nullable()->constrained('purchase_requests')->nullOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->restrictOnDelete();
            $table->foreignId('purchasing_officer_id')->constrained('users')->cascadeOnDelete();
            $table->date('order_date');
            $table->date('expected_delivery_date')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(11.00); // PPN
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->enum('status', [
                'draft',
                'issued',
                'partially_received',
                'completed',
                'cancelled',
            ])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Detail Item PO
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('quantity_received', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');
    }
};
