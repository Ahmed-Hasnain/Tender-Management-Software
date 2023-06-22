<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'quotation_in_process',
                'quotation_applied',
                'quotation_not_applied',
                'quotation_not_qualified',
                'expected_order',
                'clarification_before_supply_order',
                'validity_extended',
                'purchasing_in_process',
                'clarification_after_supply_order',
                'store_purchased',
                'store_delivered',
                'payment_received',
                'supply_regretted',
                ])->default('pending')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'quotation_in_process',
                'quotation_applied',
                'quotation_not_applied',
                'quotation_not_qualified',
                'expected_order',
                'clarification_before_supply_order',
                'validity_extended',
                'purchasing_in_process',
                'clarification_after_supply_order',
                'store_purchased',
                'store_delivered',
                'payment_received',
                'supply_regretted',
                ])->default('pending')->nullable();
        });
    }
}
