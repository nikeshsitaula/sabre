<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('p_id');
            $table->string('travelname')->nullable();
            $table->integer('ta_id');
            $table->date('agreementdate');
            $table->integer('agreementnumber');
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
        Schema::dropIfExists('product_agreements');
    }
}
