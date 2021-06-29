<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('rating_number');
            $table->text('content');
            $table->integer('course')->unsigned();
            $table->foreign('course')->references('id')->on('course');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
            $table->json('answer')->nullable();
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
        Schema::dropIfExists('rating');
    }
}
