<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnToMIDTS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_i_d_t_s', function (Blueprint $table) {
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
        Schema::table('m_i_d_t_s', function (Blueprint $table) {
            //
        });
    }
}
