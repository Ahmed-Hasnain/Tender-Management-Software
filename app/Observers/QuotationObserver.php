<?php

namespace App\Observers;

use App\Models\Quotation;
use Illuminate\Support\Str;

class QuotationObserver
{
    /**
     * Handle the Quotation "created" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function creating(Quotation $quotation)
    {
        //
    }
    
    /**
     * Handle the Quotation "created" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function created(Quotation $quotation)
    {
        if ($quotation->tender) {
            $quotation->tender->status = $quotation->status;
            $quotation->tender->saveQuietly();
        }
    }

    /**
     * Handle the Quotation "updated" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function updated(Quotation $quotation)
    {
        if ($quotation->tender) {
            $quotation->tender->status = $quotation->status;
            $quotation->tender->saveQuietly();
        }
    }

    /**
     * Handle the Quotation "deleted" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function deleted(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the Quotation "restored" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function restored(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the Quotation "force deleted" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function forceDeleted(Quotation $quotation)
    {
        //
    }
}
