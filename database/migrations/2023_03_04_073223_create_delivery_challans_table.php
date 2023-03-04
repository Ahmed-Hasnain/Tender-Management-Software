<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_challans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reference_no')->nullable();
            $table->unsignedBigInteger('supply_order_id')->nullable();
            $table->string('description')->nullable();
            $table->string('total')->nullable();
            $table->string('total_including_tax')->nullable();
            $table->boolean('delivered')->default(0)->nullable();

            $table->foreign('supply_order_id')->references('id')->on('supply_orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_challans');
    }
}
