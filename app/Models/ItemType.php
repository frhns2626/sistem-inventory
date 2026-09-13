<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    /**
     * Relasi ke seluruh item yang menggunakan tipe ini.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
