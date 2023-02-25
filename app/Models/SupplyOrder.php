<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'date_of_supply_order',
        'delivery_date',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

}
