<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRecieving extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supply_order_id',
        'payment_date',
        'cheque_no',
        'bank_name',
        'cheque_amount',
        'income_tax_amount',
        'gst_withhold_amount',
        'cheque_date',
        'serial_no',
        'status',
    ];

    protected function paymentDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    protected function chequeDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    public function supplyOrder()
    {
        return $this->belongsTo(SupplyOrder::class, 'supply_order_id');
    }
}
