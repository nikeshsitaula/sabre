<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('p_id');
            $table->integer('ta_id')->nullable();
            $table->integer('agreementnumber')->nullable();
            $table->string('period')->nullable();
            $table->date('entrydate')->nullable();
            $table->double('cost')->nullable();
            $table->double('received')->nullable();
            $table->string('accountmanager')->nullable();
            $table->double('balance')->nullable();
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
        Schema::dropIfExists('product_costs');
    }
}
