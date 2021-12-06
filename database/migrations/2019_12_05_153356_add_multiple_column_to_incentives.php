<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnToIncentives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incentives', function (Blueprint $table) {
            $table->string('incentives')->nullable();
            $table->string('marketsharecommitment')->nullable();
            $table->string('accountmanager')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incentives', function (Blueprint $table) {
            //
        });
    }
}
