<?php

namespace App\Observers;

use App\Models\QuotationItem;
use Illuminate\Support\Facades\Log;

class QuotationItemObserver
{
    /**
     * Handle the QuotationItem "created" event.
     *
     * @param  \App\Models\QuotationItem  $quotationItem
     * @return void
     */
    public function created(QuotationItem $quotationItem)
    {
        try {
            if ($quotationItem) {
                $total_price =  $quotationItem->unit_price * $quotationItem->tenderItem->qty;
                $quotationItem->total_price = $total_price;
                $quotationItem->saveQuietly();
                if ($quotationItem->quotation) {
                    $quotationItem->quotation->total_price = $quotationItem->quotation->items->sum('total_price');  
                    $quotationItem->quotation->save();
                }
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Handle the QuotationItem "updated" event.
     *
     * @param  \App\Models\QuotationItem  $quotationItem
     * @return void
     */
    public function updated(QuotationItem $quotationItem)
    {
        try {
            if ($quotationItem) {
                $total_price =  $quotationItem->unit_price * $quotationItem->tenderItem->qty;
                $quotationItem->total_price = $total_price;
                $quotationItem->saveQuietly();
                if ($quotationItem->quotation) {
                    $quotationItem->quotation->total_price =  0;
                    $quotationItem->quotation->total_price =  $quotationItem->quotation->items->sum('total_price');
                    $quotationItem->quotation->save();
                }
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Handle the QuotationItem "deleted" event.
     *
     * @param  \App\Models\QuotationItem  $quotationItem
     * @return void
     */
    public function deleted(QuotationItem $quotationItem)
    {
        //
    }

    /**
     * Handle the QuotationItem "restored" event.
     *
     * @param  \App\Models\QuotationItem  $quotationItem
     * @return void
     */
    public function restored(QuotationItem $quotationItem)
    {
        //
    }

    /**
     * Handle the QuotationItem "force deleted" event.
     *
     * @param  \App\Models\QuotationItem  $quotationItem
     * @return void
     */
    public function forceDeleted(QuotationItem $quotationItem)
    {
        //
    }
}
