<?php

namespace App\Observers;

use App\Models\DeliveryChallanItem;
use Illuminate\Support\Facades\Log;

class DeliveryChallanItemObserver
{
    /**
     * Handle the DeliveryChallanItem "created" event.
     *
     * @param  \App\Models\DeliveryChallanItem  $deliveryChallanItem
     * @return void
     */
    public function created(DeliveryChallanItem $deliveryChallanItem)
    {
        try {
            if ($deliveryChallanItem) {
                $total_price =  $deliveryChallanItem->unit_price * $deliveryChallanItem->qty;
                $deliveryChallanItem->total_price = $total_price;
                $deliveryChallanItem->saveQuietly();
                if ($deliveryChallanItem->deliveryChallan) {
                    $deliveryChallanItem->deliveryChallan->total = $deliveryChallanItem->deliveryChallan->items->sum('total_price');  
                    $deliveryChallanItem->deliveryChallan->save();
                }
                if ($deliveryChallanItem->supplyOrderItem) {
                    $deliveryChallanItem->supplyOrderItem->qty_left = $deliveryChallanItem->supplyOrderItem->qty_left - $deliveryChallanItem->qty;
                    $deliveryChallanItem->supplyOrderItem->save();
                }
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Handle the DeliveryChallanItem "updated" event.
     *
     * @param  \App\Models\DeliveryChallanItem  $deliveryChallanItem
     * @return void
     */
    public function updated(DeliveryChallanItem $deliveryChallanItem)
    {
        //
    }

    /**
     * Handle the DeliveryChallanItem "deleted" event.
     *
     * @param  \App\Models\DeliveryChallanItem  $deliveryChallanItem
     * @return void
     */
    public function deleted(DeliveryChallanItem $deliveryChallanItem)
    {
        //
    }

    /**
     * Handle the DeliveryChallanItem "restored" event.
     *
     * @param  \App\Models\DeliveryChallanItem  $deliveryChallanItem
     * @return void
     */
    public function restored(DeliveryChallanItem $deliveryChallanItem)
    {
        //
    }

    /**
     * Handle the DeliveryChallanItem "force deleted" event.
     *
     * @param  \App\Models\DeliveryChallanItem  $deliveryChallanItem
     * @return void
     */
    public function forceDeleted(DeliveryChallanItem $deliveryChallanItem)
    {
        //
    }
}
