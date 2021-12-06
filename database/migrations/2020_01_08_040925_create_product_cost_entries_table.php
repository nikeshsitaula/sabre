<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCostEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cost_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ta_id')->nullable();
            $table->integer('agreementnumber')->nullable();
            $table->double('cost')->nullable();
            $table->double('payment')->nullable();
            $table->date('date')->nullable();
            $table->double('balance')->nullable();
            $table->integer('p_id')->nullable();
            $table->string('name');
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
        Schema::dropIfExists('product_cost_entries');
    }
}
