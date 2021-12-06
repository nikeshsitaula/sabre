<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePCCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_c_c_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ta_id');
            $table->string('br_pcc');
            $table->string('br_address')->nullable();
            $table->string('br_phone')->nullable();
            $table->string('br_fax_no')->nullable();
            $table->string('br_email')->nullable();
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
        Schema::dropIfExists('p_c_c_s');
    }
}
