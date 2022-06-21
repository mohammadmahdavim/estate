<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosterDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poster_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poster_id');
            $table->foreign('poster_id')->on('posters')->references('id')->onDelete('cascade');
            $table->string('mime');
            $table->string('original_filename');
            $table->string('filename');
            $table->string('resize_image');
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
        Schema::dropIfExists('poster_documents');
    }
}
