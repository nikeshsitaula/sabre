<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountManagerSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_manager_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ta_id')->nullable();
            $table->date('next_month')->nullable();
            $table->date('running_date')->nullable();
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
        Schema::dropIfExists('account_manager_schedules');
    }
}
