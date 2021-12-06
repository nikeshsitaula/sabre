<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnToRevenues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
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
        Schema::table('revenues', function (Blueprint $table) {
            //
        });
    }
}
