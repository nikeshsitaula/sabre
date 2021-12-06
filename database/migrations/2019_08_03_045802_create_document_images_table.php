<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDocumentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('emp_no')->nullable();
            $table->integer('document_id')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('document_images');
    }
}
