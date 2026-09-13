<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIssue extends Model
{
    protected $fillable = [
        'issue_number',
        'material_requisition_id',
        'warehouse_id',
        'issued_by_id',
        'received_by_id',
        'issue_date',
        'notes'
    ];
    public function requisition()
    {
        return $this->belongsTo(MaterialRequisition::class, 'material_requisition_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by_id');
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }
}
