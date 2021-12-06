<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmaprizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smaprizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sma_id');
            $table->integer('ta_id');
            $table->string('travelname')->nullable();
            $table->string('staff_no');
            $table->double('prizeamount');
            $table->string('prizeother');
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
        Schema::dropIfExists('smaprizes');
    }
}
