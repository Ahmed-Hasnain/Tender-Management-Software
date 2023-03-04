<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplyOrderItemIdToDeliveryChallanItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_challan_items', function (Blueprint $table) {
            $table->unsignedBigInteger('supply_order_item_id')->nullable();
            $table->foreign('supply_order_item_id')->references('id')->on('supply_order_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_challan_items', function (Blueprint $table) {
            //
        });
    }
}
