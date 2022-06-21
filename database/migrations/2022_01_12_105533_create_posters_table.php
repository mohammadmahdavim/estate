<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('verifier');
            $table->foreign('verifier')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->on('types')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->on('forms')->references('id')->onDelete('cascade');
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('verify')->default(0);
            $table->string('mobile')->nullable();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->string('mime')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('filename')->nullable();
            $table->string('resize_image')->nullable();
            $table->string('lng')->nullable();
            $table->string('lat')->nullable();
            $table->tinyInteger('show_mobile')->default(0);
            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->on('sectors')->references('id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posters');
    }
}
