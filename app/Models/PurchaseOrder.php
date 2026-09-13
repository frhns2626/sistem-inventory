<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'purchase_request_id',
        'vendor_id',
        'purchasing_officer_id',
        'order_date',
        'expected_delivery_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'status',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchasingOfficer()
    {
        return $this->belongsTo(User::class, 'purchasing_officer_id');
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }
}
