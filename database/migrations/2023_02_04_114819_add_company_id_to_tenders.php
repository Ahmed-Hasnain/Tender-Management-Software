<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToTenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('mode_of_payment_id');
            $table->unsignedBigInteger('demand_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('demand_id')->references('id')->on('demands');
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
            $table->unsignedBigInteger('company_id')->nullable()->after('mode_of_payment_id');
            $table->unsignedBigInteger('demand_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('demand_id')->references('id')->on('demands');
        });
    }
}
