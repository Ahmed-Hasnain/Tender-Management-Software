<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentRecievingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_recievings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_order_id')->nullable();
            $table->dateTime('payment_date')->default(Carbon::now())->nullable();
            $table->string('cheque_no')->nullable();
            $table->enum('bank_name', [
                'state_bank_of_pakistan',
                'national_bank_of_pakistan',
                'habib_bank_limited_(hbl)',
                'united_bank_limited_(ubl)',
                'mcb_bank_limited',
                'allied_bank_limited_(abl)',
                'bank_alfalah_limited',
                'sindh_bank_limited',
                'askari_bank_limited',
                'faysal_bank_limited',
                'bank_of_punjab_(bop)',
                'habib_metropolitan_bank',
                'soneri_bank_limited',
                'bank_al-habib_limited',
                'standard_chartered_bank_(pakistan)',
                'js_bank_limited',
                'summit_bank_limited',
                'bankislami_pakistan_limited',
                'silk_bank_limited',
                'meezan_bank_limited'
            ])->default('habib_bank_limited_(hbl)')->nullable();
            $table->string('cheque_amount')->nullable();
            $table->string('income_tax_amount')->nullable();
            $table->string('gst_withhold_amount')->nullable();
            $table->dateTime('cheque_date')->default(Carbon::now())->nullable();
            $table->string('serial_no')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed' ])->default('pending')->nullable();
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
        Schema::dropIfExists('payment_recievings');
    }
}
