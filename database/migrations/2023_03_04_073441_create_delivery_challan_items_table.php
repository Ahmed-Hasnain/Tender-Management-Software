<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChallanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_challan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_challan_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('delivery_challan_id')->references('id')->on('delivery_challans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_challan_items');
    }
}
