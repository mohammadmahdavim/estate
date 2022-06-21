<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poster_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poster_id');
            $table->foreign('poster_id')->on('posters')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->on('forms')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->on('fields')->references('id')->onDelete('cascade');
            $table->string('value');
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
        Schema::dropIfExists('poster_details');
    }
}
