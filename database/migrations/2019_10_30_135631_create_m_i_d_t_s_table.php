<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMIDTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_i_d_t_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('month')->nullable();
            $table->year('year')->nullable();
            $table->integer('sabre_bookings')->nullable();
            $table->integer('amadeus')->nullable();
            $table->integer('travel_port')->nullable();
            $table->integer('others')->default(0);
            $table->integer('ta_id')->nullable();
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
        Schema::dropIfExists('m_i_d_t_s');
    }
}
