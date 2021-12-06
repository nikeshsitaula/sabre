<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentiveDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentive_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ta_id')->nullable();
            $table->integer('volumecommitment')->nullable();
            $table->integer('contactperiod')->nullable();
            $table->float('segmenttomonth')->nullable();
            $table->date('startdate')->nullable();
            $table->float('marketshare')->nullable();
            $table->float('tomonthmarketshare')->nullable();
            $table->integer('month')->nullable();
            $table->float('targetsegment')->nullable();
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
        Schema::dropIfExists('incentive_data');
    }
}
