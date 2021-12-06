<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlineStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ai_id');
            $table->string('staff_id');
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('remarks')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('airline_staff');
    }
}
