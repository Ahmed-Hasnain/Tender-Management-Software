<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSupplyOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_orders', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'processing',
                'completed'
            ])->default('pending')->after('delivered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_orders', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'processing',
                'completed'
            ])->default('pending')->after('delivered')->nullable();
        });
    }
}
