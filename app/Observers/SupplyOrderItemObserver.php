<?php

namespace App\Observers;

use App\Models\SupplyOrder;
use App\Models\SupplyOrderItem;
use Illuminate\Support\Facades\Log;

class SupplyOrderItemObserver
{
    /**
     * Handle the SupplyOrderItem "created" event.
     *
     * @param  \App\Models\SupplyOrderItem  $supplyOrderItem
     * @return void
     */
    public function created(SupplyOrderItem $supplyOrderItem)
    {
        try {
            if ($supplyOrderItem) {
                $total_price =  $supplyOrderItem->unit_price * $supplyOrderItem->qty;
                $supplyOrderItem->total = $total_price;
                $supplyOrderItem->saveQuietly();
                if ($supplyOrderItem->supplyOrder) {
                    $supplyOrderItem->supplyOrder->total_price = $supplyOrderItem->supplyOrder->items->sum('total');  
                    $supplyOrderItem->supplyOrder->save();
                }
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Handle the SupplyOrderItem "updated" event.
     *
     * @param  \App\Models\SupplyOrderItem  $supplyOrderItem
     * @return void
     */
    public function updated(SupplyOrderItem $supplyOrderItem)
    {
        try {
            if ($supplyOrderItem) {
                $total_price =  $supplyOrderItem->unit_price * $supplyOrderItem->qty;
                $supplyOrderItem->total = $total_price;
                $supplyOrderItem->saveQuietly();
                if ($supplyOrderItem->supplyOrder) {
                    $supplyOrderItem->supplyOrder->total_price =  0;
                    $supplyOrderItem->supplyOrder->total_price = $supplyOrderItem->supplyOrder->items->sum('total');
                    $supplyOrderHasAllItemsWithZeroQty  = $supplyOrderItem->supplyOrder->items->where('qty_left', 0)->count();
                    $allItemsQty = $supplyOrderItem->supplyOrder->items->count();
                    if ($supplyOrderHasAllItemsWithZeroQty == $allItemsQty) {
                        $supplyOrderItem->supplyOrder->delivered = 1;
                    } else {
                        $supplyOrderItem->supplyOrder->delivered = 0;
                    }
                    $supplyOrderItem->supplyOrder->save();
                }
                
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Handle the SupplyOrderItem "deleted" event.
     *
     * @param  \App\Models\SupplyOrderItem  $supplyOrderItem
     * @return void
     */
    public function deleted(SupplyOrderItem $supplyOrderItem)
    {
        //
    }

    /**
     * Handle the SupplyOrderItem "restored" event.
     *
     * @param  \App\Models\SupplyOrderItem  $supplyOrderItem
     * @return void
     */
    public function restored(SupplyOrderItem $supplyOrderItem)
    {
        //
    }

    /**
     * Handle the SupplyOrderItem "force deleted" event.
     *
     * @param  \App\Models\SupplyOrderItem  $supplyOrderItem
     * @return void
     */
    public function forceDeleted(SupplyOrderItem $supplyOrderItem)
    {
        //
    }
}
