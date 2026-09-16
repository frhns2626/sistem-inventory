<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Permohonan Pengambilan Barang dari Gudang (Material Requisition)
        Schema::create('material_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_number', 50)->unique();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete(); // employee
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->enum('status', [
                'draft',
                'pending_dept_head',
                'approved',
                'rejected',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('draft');
            $table->foreignId('dept_head_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dept_head_action_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('purpose')->nullable(); // Keperluan pemakaian barang
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Detail Item Permintaan Gudang
        Schema::create('material_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_requisition_id')->constrained('material_requisitions')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->decimal('quantity_requested', 12, 2);
            $table->decimal('quantity_approved', 12, 2)->default(0);
            $table->decimal('quantity_issued', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Serah Terima Fisik Barang Keluar (Goods Issue)
        Schema::create('goods_issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_number', 50)->unique();
            $table->foreignId('material_requisition_id')->constrained('material_requisitions')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('issued_by_id')->constrained('users')->cascadeOnDelete();   // warehouse_staff
            $table->foreignId('received_by_id')->constrained('users')->cascadeOnDelete(); // employee penerima
            $table->date('issue_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Detail Item Barang Keluar
        Schema::create('goods_issue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_issue_id')->constrained('goods_issues')->cascadeOnDelete();
            $table->foreignId('material_requisition_item_id')->constrained('material_requisition_items')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_issue_items');
        Schema::dropIfExists('goods_issues');
        Schema::dropIfExists('material_requisition_items');
        Schema::dropIfExists('material_requisitions');
    }
};
