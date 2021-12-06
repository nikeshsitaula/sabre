<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ai_id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('numericiata')->nullable();
            $table->string('alphanumericiata')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
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
        Schema::dropIfExists('airlines');
    }
}
