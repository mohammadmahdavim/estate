<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->tinyInteger('order')->default(1);
            $table->boolean('active')->default(1)->index();
            $table->boolean('question')->default(1)->index();
            $table->enum('type', [
                'text',
                'textarea',
                'select',
                'multi-select',
                'radio',
                'number',
                'date',
                'hidden',
                'file',
                'checkbox',
                'autocomplete',
                'slider',
                'editor'
            ])->default('text');
            $table->integer('mark')->default(0);
            $table->boolean('required')->index()->default(0);
            $table->boolean('filter')->index()->default(0);
            $table->boolean('sync')->index()->default(0);
            $table->boolean('report')->index()->default(0);
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
        Schema::dropIfExists('fields');
    }
}
