<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Faktur Tagihan Vendor (3-Way Matching: PO + GR + Invoice)
        Schema::create('vendor_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 100)->unique();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('goods_receipt_id')->nullable()->constrained('goods_receipts')->nullOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->restrictOnDelete();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('amount', 15, 2);
            $table->enum('status', [
                'pending_verification',
                'verified',
                'paid',
                'cancelled'
            ])->default('pending_verification');
            $table->foreignId('verified_by_id')->nullable()->constrained('users')->nullOnDelete(); // finance
            $table->string('invoice_document')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Pembayaran / Pelunasan ke Rekening Vendor
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number', 50)->unique();
            $table->foreignId('vendor_invoice_id')->constrained('vendor_invoices')->cascadeOnDelete();
            $table->foreignId('paid_by_id')->constrained('users')->cascadeOnDelete(); // finance
            $table->date('payment_date');
            $table->enum('payment_method', [
                'bank_transfer',
                'cash',
                'cheque',
                'giro'
            ])->default('bank_transfer');
            $table->decimal('amount', 15, 2);
            $table->string('reference_number', 100)->nullable(); // No transaksi bank
            $table->string('proof_document')->nullable();         // Bukti transfer
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('vendor_invoices');
    }
};
