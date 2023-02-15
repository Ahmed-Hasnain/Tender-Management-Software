<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('delivery_time')->nullable()->after('total_price');
            $table->string('validity_of_quotation')->nullable()->after('delivery_time');
            $table->enum('status', [
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
                ])->default('quotation_in_process')->nullable()->after('validity_of_quotation');
            $table->string('tax')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('delivery_time')->nullable()->after('total_price');
            $table->string('validity_of_quotation')->nullable()->after('delivery_time');
            $table->enum('status', [
                'quotation_in_process',
                'quotation_applied',
                'quotation_not_applied',
                'quotation_not_qualified',
                'expected_order',
                'clarification_before_supply_order',
                'validity_extended',
                'purchasing_in_process',
                'clarification_aftere_supply_order',
                'store_purchased',
                'store_delivered',
                'payment_received',
                'supply_regretted',
                ])->default('quotation_in_process')->nullable()->after('validity_of_quotation');
            $table->string('tax')->nullable()->after('status');
        });
    }
}
