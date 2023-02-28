<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_no',
        'currency',
        'total_price',
        'terms_and_conditions',
        'tender_id',
        'delivery_time',
        'validity_of_quotation',
        'status',
        'tax',
        'applied_date'
    ];

    protected function appliedDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    public function tender() 
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function supplyOrder()
    {
        return $this->hasOne(SupplyOrder::class);
    }
}
