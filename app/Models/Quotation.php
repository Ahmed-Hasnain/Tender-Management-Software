<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function tender() 
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
}
