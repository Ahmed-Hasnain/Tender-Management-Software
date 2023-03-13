<?php

namespace App\Observers;

use App\Models\SupplyOrder;

class SupplyOrderObserver
{
    /**
     * Handle the SupplyOrder "created" event.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return void
     */
    public function created(SupplyOrder $supplyOrder)
    {
        
    }

    /**
     * Handle the SupplyOrder "updated" event.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return void
     */
    public function updated(SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Handle the SupplyOrder "deleted" event.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return void
     */
    public function deleted(SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Handle the SupplyOrder "restored" event.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return void
     */
    public function restored(SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Handle the SupplyOrder "force deleted" event.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return void
     */
    public function forceDeleted(SupplyOrder $supplyOrder)
    {
        //
    }
}
