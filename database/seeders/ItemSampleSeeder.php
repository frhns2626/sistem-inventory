<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Database\Seeder;

class ItemSampleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Contoh
        $categories = [
            ['code' => 'CAT-HW', 'name' => 'Hardware & IT', 'description' => 'Perangkat keras komputer dan jaringan'],
            ['code' => 'CAT-ATK', 'name' => 'ATK & Kantor', 'description' => 'Alat tulis dan perlengkapan kantor'],
            ['code' => 'CAT-ACC', 'name' => 'Aksesoris IT', 'description' => 'Periferal dan aksesoris komputer'],
            ['code' => 'CAT-GDG', 'name' => 'Peralatan Gudang', 'description' => 'Perkakas dan safety alat gudang'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['code' => $cat['code']], $cat);
        }

        // 2. Satuan Contoh
        $units = [
            ['name' => 'Unit', 'symbol' => 'Unit'],
            ['name' => 'Dus / Box', 'symbol' => 'Dus'],
            ['name' => 'Rim', 'symbol' => 'Rim'],
            ['name' => 'Pieces', 'symbol' => 'Pcs'],
            ['name' => 'Roll', 'symbol' => 'Roll'],
        ];

        foreach ($units as $u) {
            Unit::firstOrCreate(['symbol' => $u['symbol']], $u);
        }

        // 3. Gudang Contoh
        $warehouses = [
            ['code' => 'WH-01', 'name' => 'Gudang Utama (G-01)', 'location' => 'Blok A Sentral'],
            ['code' => 'WH-02', 'name' => 'Gudang Transit (G-02)', 'location' => 'Blok B Utara'],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::firstOrCreate(['code' => $wh['code']], $wh);
        }

        // 4. Sample Item Katalog
        $catHW = Category::where('code', 'CAT-HW')->first();
        $catATK = Category::where('code', 'CAT-ATK')->first();
        $catACC = Category::where('code', 'CAT-ACC')->first();

        $unitUnit = Unit::where('symbol', 'Unit')->first();
        $unitDus = Unit::where('symbol', 'Dus')->first();
        $unitPcs = Unit::where('symbol', 'Pcs')->first();

        $wh1 = Warehouse::where('code', 'WH-01')->first();
        $wh2 = Warehouse::where('code', 'WH-02')->first();

        $typeCSM = class_exists(\App\Models\ItemType::class) ? \App\Models\ItemType::where('code', 'CSM')->first() : null;
        $typeAST = class_exists(\App\Models\ItemType::class) ? \App\Models\ItemType::where('code', 'AST')->first() : null;
        $typeRMT = class_exists(\App\Models\ItemType::class) ? \App\Models\ItemType::where('code', 'RMT')->first() : null;

        $items = [
            [
                'code' => 'ITM-2026-001',
                'name' => 'Laptop Dell Latitude 3420 14"',
                'category_id' => $catHW->id,
                'unit_id' => $unitUnit->id,
                'item_type_id' => $typeAST->id ?? null,
                'type' => 'asset',
                'minimum_stock' => 5,
                'description' => 'Intel Core i5-1135G7, 16GB RAM DDR4, 512GB NVMe SSD',
                'is_active' => true,
                'stock' => 24,
            ],
            [
                'code' => 'ITM-2026-042',
                'name' => 'Kertas HVS A4 80gr PaperOne',
                'category_id' => $catATK->id,
                'unit_id' => $unitDus->id,
                'item_type_id' => $typeCSM->id ?? null,
                'type' => 'consumable',
                'minimum_stock' => 10,
                'description' => 'Dus isi 5 Rim @ 500 lembar warna putih cerah',
                'is_active' => true,
                'stock' => 2, // Stok kritis
            ],
            [
                'code' => 'ITM-2026-088',
                'name' => 'Mouse Wireless Logitech M220 Silent',
                'category_id' => $catACC->id,
                'unit_id' => $unitUnit->id,
                'item_type_id' => $typeCSM->id ?? null,
                'type' => 'consumable',
                'minimum_stock' => 5,
                'description' => 'Warna Charcoal Grey, koneksi nano receiver USB 2.4GHz',
                'is_active' => true,
                'stock' => 18,
            ],
            [
                'code' => 'ITM-2026-095',
                'name' => 'Kabel UTP Cat6 Belden 305m',
                'category_id' => $catHW->id,
                'unit_id' => $unitDus->id,
                'item_type_id' => $typeRMT->id ?? null,
                'type' => 'raw_material',
                'minimum_stock' => 3,
                'description' => 'Original Grey jacket, 1000ft indoor installation',
                'is_active' => true,
                'stock' => 0, // Stok habis
            ],
            [
                'code' => 'ITM-2026-112',
                'name' => 'Toner Cartridge HP LaserJet 85A (CE285A)',
                'category_id' => $catATK->id,
                'unit_id' => $unitPcs->id,
                'item_type_id' => $typeCSM->id ?? null,
                'type' => 'consumable',
                'minimum_stock' => 4,
                'description' => 'Original HP Black Toner for P1102 / M1132 / M1212',
                'is_active' => true,
                'stock' => 9,
            ],
        ];

        foreach ($items as $data) {
            $stockQty = $data['stock'];
            unset($data['stock']);

            $item = Item::firstOrCreate(['code' => $data['code']], $data);

            if ($wh1 && $stockQty > 0) {
                ItemStock::updateOrCreate(
                    ['item_id' => $item->id, 'warehouse_id' => $wh1->id],
                    ['quantity' => $stockQty]
                );
            }
        }
    }
}
