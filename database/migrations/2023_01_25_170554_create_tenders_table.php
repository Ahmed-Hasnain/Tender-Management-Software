<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->string('file_name')->nullable();
            $table->string('rate_basis')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('description')->nullable();
            $table->string('special_terms')->nullable();
            $table->date('rfq_date')->default(Carbon::now())->nullable();
            $table->date('last_date_of_submission')->default(Carbon::now())->nullable();
            $table->date('validity_of_quotation')->default(Carbon::now())->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('mode_of_payment_id')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('mode_of_payment_id')->references('id')->on('mode_of_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenders');
    }
}
