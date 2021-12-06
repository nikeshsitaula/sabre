<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ta_id')->nullable();
            $table->string('staff_no')->nullable();
            $table->string('course')->nullable();
            $table->date('to')->nullable();
            $table->date('from')->nullable();
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
        Schema::dropIfExists('training_staff');
    }
}
