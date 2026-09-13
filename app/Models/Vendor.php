<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'code',
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'tax_id',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'is_active'
    ];

    public function PurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
