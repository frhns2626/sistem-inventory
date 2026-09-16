<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    protected $casts = [
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
