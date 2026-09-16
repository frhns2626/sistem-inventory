<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProcurementSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dept = Department::first() ?? Department::create(['code' => 'IT', 'name' => 'Information Technology']);
        $requester = User::first();
        $deptHead = User::skip(1)->first() ?? $requester;
        $purchasingOfficer = User::skip(2)->first() ?? $requester;

        $vendor1 = Vendor::where('code', 'VND-001')->first() ?? Vendor::first();
        $vendor2 = Vendor::where('code', 'VND-002')->first() ?? Vendor::skip(1)->first() ?? $vendor1;

        $items = Item::all();
        $item1 = $items->first();
        $item2 = $items->skip(1)->first() ?? $item1;
        $item3 = $items->skip(2)->first() ?? $item1;

        $unit = Unit::first();

        // 1. Sample Purchase Requests
        $pr1 = PurchaseRequest::firstOrCreate(
            ['pr_number' => 'PR-2026-001'],
            [
                'requester_id' => $requester->id,
                'department_id' => $dept->id,
                'status' => 'approved_dept_head',
                'required_date' => Carbon::now()->addDays(7)->toDateString(),
                'dept_head_id' => $deptHead->id,
                'dept_head_action_at' => Carbon::now()->subDays(1),
                'notes' => 'Pengadaan kabel jaringan UTP dan perlengkapan instalasi server',
            ]
        );

        if ($pr1->items()->count() === 0) {
            PurchaseRequestItem::create([
                'purchase_request_id' => $pr1->id,
                'item_id' => $item1?->id,
                'item_name' => $item1?->name ?? 'Kabel UTP Cat6 Belden 305m',
                'quantity' => 5,
                'unit_id' => $item1?->unit_id ?? $unit?->id,
                'estimated_price' => 1850000,
                'specification' => 'Original Belden Grey jacket, 1000ft indoor installation',
            ]);
            PurchaseRequestItem::create([
                'purchase_request_id' => $pr1->id,
                'item_id' => $item2?->id,
                'item_name' => $item2?->name ?? 'RJ45 Modular Plug Cat6',
                'quantity' => 10,
                'unit_id' => $unit?->id,
                'estimated_price' => 150000,
                'specification' => 'Pack isi 50 pcs gold plated pins',
            ]);
        }

        $pr2 = PurchaseRequest::firstOrCreate(
            ['pr_number' => 'PR-2026-002'],
            [
                'requester_id' => $requester->id,
                'department_id' => $dept->id,
                'status' => 'pending_dept_head',
                'required_date' => Carbon::now()->addDays(14)->toDateString(),
                'notes' => 'Pengadaan kertas HVS A4 untuk laporan operasional triwulan',
            ]
        );

        if ($pr2->items()->count() === 0) {
            PurchaseRequestItem::create([
                'purchase_request_id' => $pr2->id,
                'item_id' => $item3?->id,
                'item_name' => $item3?->name ?? 'Kertas HVS A4 80gr PaperOne',
                'quantity' => 20,
                'unit_id' => $unit?->id,
                'estimated_price' => 245000,
                'specification' => 'Box isi 5 rim warna putih cerah 80gr',
            ]);
        }

        // 2. Sample Purchase Orders
        if ($vendor1) {
            $po1 = PurchaseOrder::firstOrCreate(
                ['po_number' => 'PO-2026-001'],
                [
                    'purchase_request_id' => $pr1->id,
                    'vendor_id' => $vendor1->id,
                    'purchasing_officer_id' => $purchasingOfficer->id,
                    'order_date' => Carbon::now()->subDays(2)->toDateString(),
                    'expected_delivery_date' => Carbon::now()->addDays(5)->toDateString(),
                    'subtotal' => 9250000,
                    'tax_rate' => 11.00,
                    'tax_amount' => 1017500,
                    'discount_amount' => 0,
                    'grand_total' => 10267500,
                    'status' => 'issued',
                    'notes' => 'Pengiriman langsung ke Gudang Utama Cikarang via kurir logistik vendor',
                ]
            );

            if ($po1->items()->count() === 0 && $item1) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po1->id,
                    'item_id' => $item1->id,
                    'quantity' => 5,
                    'unit_price' => 1850000,
                    'subtotal' => 9250000,
                    'quantity_received' => 0,
                ]);
            }
        }

        if ($vendor2 && $item2) {
            $po2 = PurchaseOrder::firstOrCreate(
                ['po_number' => 'PO-2026-002'],
                [
                    'purchase_request_id' => null,
                    'vendor_id' => $vendor2->id,
                    'purchasing_officer_id' => $purchasingOfficer->id,
                    'order_date' => Carbon::now()->subDays(5)->toDateString(),
                    'expected_delivery_date' => Carbon::now()->toDateString(),
                    'subtotal' => 4900000,
                    'tax_rate' => 11.00,
                    'tax_amount' => 539000,
                    'discount_amount' => 100000,
                    'grand_total' => 5339000,
                    'status' => 'completed',
                    'notes' => 'Pesanan rutin ATK kantor pusat',
                ]
            );

            if ($po2->items()->count() === 0) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po2->id,
                    'item_id' => $item2->id,
                    'quantity' => 20,
                    'unit_price' => 245000,
                    'subtotal' => 4900000,
                    'quantity_received' => 20,
                ]);
            }
        }
    }
}
