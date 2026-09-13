<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    protected $fillable = [
        'item_id',
        'warehouse_id',
        'type',
        'quantity',
        'balance_after',
        'reference_type',
        'reference_id',
        'created_by_id',
        'notes'
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    // barang yang bermutasi
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // gudang lokasi barang
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // user yang memicu  mutasi
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    // relasi polimorfik ke model referensi mutasi
    public function reference()
    {
        return $this->morphTo();}
}
