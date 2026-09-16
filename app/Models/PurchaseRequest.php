<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'pr_number',
        'requester_id',
        'department_id',
        'status',
        'required_date',
        'dept_head_id',
        'dept_head_action_at',
        'rejection_reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'required_date' => 'date',
            'dept_head_action_at' => 'datetime',
        ];
    }

    // user yang mengajukan (employee)
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    // departemen pemohon
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // kepala divisi  yang menyetujui/menolak
    public function deptHead()
    {
        return $this->belongsTo(User::class, 'dept_head_id');
    }

    // PO yang diterbitkan dari PR ini
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    // Detail item yang diajukan
    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}
