<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->enum('department', ['Human Resources', 'Accounting and Finance ', 'Sales and Marketing', 'Operations', 'Information Technology', 'Customer Service', 'Research and Development', 'Legal', 'Quality Assurance', 'Supply Chain', 'unknown'])->default('unknown');
            $table->morphs('personable');
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
        Schema::dropIfExists('people');
    }
}
