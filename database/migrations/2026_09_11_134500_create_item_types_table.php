<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel master item_types dinamis
        Schema::create('item_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Isi data default awal agar sistem langsung siap pakai
        DB::table('item_types')->insert([
            [
                'code' => 'CSM',
                'name' => 'Consumable (Barang Habis Pakai)',
                'description' => 'Barang operasional yang habis sekali pakai atau berjangka pendek',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'AST',
                'name' => 'Asset (Aset Tetap / Inventaris)',
                'description' => 'Aset bernilai tinggi yang dipinjamkan/dialokasikan ke divisi atau karyawan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RMT',
                'name' => 'Raw Material (Bahan Baku)',
                'description' => 'Material dan bahan baku untuk kebutuhan perakitan atau teknis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Tambahkan relasi item_type_id pada tabel items
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('item_type_id')->nullable()->after('unit_id')->constrained('item_types')->nullOnDelete();
        });

        // 4. Sinkronisasi data lama jika kolom type sebelumnya sudah memiliki isi
        $typeMapping = [
            'consumable' => 'CSM',
            'asset' => 'AST',
            'raw_material' => 'RMT',
        ];

        foreach ($typeMapping as $oldType => $newCode) {
            $typeRecord = DB::table('item_types')->where('code', $newCode)->first();
            if ($typeRecord && Schema::hasColumn('items', 'type')) {
                DB::table('items')->where('type', $oldType)->update(['item_type_id' => $typeRecord->id]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['item_type_id']);
            $table->dropColumn('item_type_id');
        });

        Schema::dropIfExists('item_types');
    }
};
