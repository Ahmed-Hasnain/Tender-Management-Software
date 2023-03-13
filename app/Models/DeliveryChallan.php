<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChallan extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'supply_order_id',
        'description',
        'delivered',
        'total',
        'total_including_tax',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deliveryChallan) {
            $deliveryChallan->setReferenceNoAttribute(null);
        });
    }

    public function supplyOrder() 
    {
        return $this->belongsTo(SupplyOrder::class);
    }

    public function items()
    {
        return $this->hasMany(DeliveryChallanItem::class);
    }

    public function setReferenceNoAttribute($value)
    {
        $lastProduct = static::latest()->first();
        if ($lastProduct) {
            $lastReferenceNo = $lastProduct->reference_no;
            $lastNumber = substr($lastReferenceNo, strpos($lastReferenceNo, '-') + 1);
            $newNumber = intval($lastNumber) + 1;
            $newReferenceNo = 'DC-' . $newNumber;
        } else {
            $newReferenceNo = 'DC-1';
        }
        $this->attributes['reference_no'] = $newReferenceNo;
    }
}
