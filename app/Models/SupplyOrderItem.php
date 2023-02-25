<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_order_id',
        'quotation_item_id',
        'qty',
        'unit_price',
    ];

    public function suppyOrder() 
    {
        return $this->belongsTo(SupplyOrder::class);
    }

    public function quotationItem() 
    {
        return $this->belongsTo(QuotationItem::class);
    }
}