<?php

namespace Database\Seeders;

use App\Models\SupplyOrderItem;
use Illuminate\Database\Seeder;

class SupplyOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplyOrderItems =  SupplyOrderItem::all();
        foreach ($supplyOrderItems as $key => $supplyOrderItem) {
            $supplyOrderItem->qty_left = $supplyOrderItem->qty;
            $supplyOrderItem->saveQuietly();
        }
    }
}
