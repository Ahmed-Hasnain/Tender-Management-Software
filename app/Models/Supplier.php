<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'website',
        'address',
        'city',
        'district',
        'country',
        'category_id',
        'account_title',
        'bank_name',
        'branch_code',
        'account_number',
        'notes',
        'iban'
    ];

    public function people() 
    {
        return $this->morphMany(Person::class, 'personable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_supplier');
    }
}
