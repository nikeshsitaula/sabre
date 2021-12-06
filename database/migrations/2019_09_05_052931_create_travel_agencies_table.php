<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ta_id');
            $table->string('ta_name')->nullable();
            $table->string('ta_address')->nullable();
            $table->string('ta_phone')->nullable();
            $table->string('ta_iata_no')->nullable();
            $table->string('ta_fax_no')->nullable();
            $table->string('ta_email')->nullable();
            $table->string('accountmanager')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('travel_agencies');
    }
}
