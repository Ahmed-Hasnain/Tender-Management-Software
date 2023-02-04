<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_no',
        'file_name',
        'rate_basis',
        'delivery_time',
        'description',
        'special_terms',
        'rfq_date',
        'last_date_of_submission',
        'validity_of_quotation',
        'client_id',
        'mode_of_payment_id',
    ];

    protected function rfqDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    protected function lastDateOfSubmission(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    protected function validityOfQuotation(): Attribute
    {
        return new Attribute(
            set: fn ($value) => setDateValues($value),
        );
    }

    public function items()
    {
        return $this->hasMany(TenderItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function mop()
    {
        return $this->belongsTo(ModeOfPayment::class, 'mode_of_payment_id');
    }

    public function quotation() 
    {
        return $this->hasOne(Quotation::class, 'tender_id');
    }
}
