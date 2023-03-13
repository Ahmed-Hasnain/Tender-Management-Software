<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChallanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_challan_id',
        'qty',
        'unit_price',
        'total_price',
        'description',
        'supply_order_item_id',
    ];

    public function deliveryChallan()
    {
        return $this->belongsTo(DeliveryChallan::class);
    }

    public function supplyOrderItem()
    {
        return $this->belongsTo(SupplyOrderItem::class);
    }
}
