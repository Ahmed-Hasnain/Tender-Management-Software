<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'date_of_supply_order',
        'delivery_date',
    ];

    protected function dateOfSupplyOrder(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    protected function deliveryDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function items()
    {
        return $this->hasMany(SupplyOrderItem::class);
    }

    public function deliveryChallan()
    {
        return $this->hasMany(DeliveryChallan::class);
    }
}
