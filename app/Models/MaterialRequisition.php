<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequisition extends Model
{
    protected $fillable = [
        'requisition_number',
        'requester_id',
        'department_id',
        'status',
        'dept_head_id',
        'dept_head_action_at',
        'rejection_reason',
        'purpose',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'dept_head_action_at' => 'datetime',
        ];
    }

    // karyawan yang meminta  barang
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

    // riwayat serah terima fisik barang keluar
    public function goodsIssues()
    {
        return $this->hasMany(GoodsIssue::class);
    }
}
