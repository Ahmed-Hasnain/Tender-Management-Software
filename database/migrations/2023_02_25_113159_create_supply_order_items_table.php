<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_order_id')->nullable();
            $table->unsignedBigInteger('quotation_item_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();

            $table->foreign('supply_order_id')->references('id')->on('supply_orders')->onDelete('cascade');
            $table->foreign('quotation_item_id')->references('id')->on('quotation_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_order_items');
    }
}
