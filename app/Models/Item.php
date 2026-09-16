<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'unit_id',
        'item_type_id',
        'type',
        'minimum_stock',
        'description',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function stocks()
    {
        return $this->hasMany(ItemStock::class);
    }
}
