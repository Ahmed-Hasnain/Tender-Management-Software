<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quotation_id',
        'tender_item_id',
        'unit_price',
        'total_price',
    ];
    
    public function quotation() 
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function tenderItem() 
    {
        return $this->belongsTo(TenderItem::class, 'tender_item_id');
    }
}
