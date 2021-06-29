<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->integer('report')->default(0);
            $table->tinyInteger('readed')->length(1)->default(0);
            $table->integer('course')->unsigned();
            $table->foreign('course')->references('id')->on('course');
            $table->integer('lecture')->unsigned()->nullable();
            $table->foreign('lecture')->references('id')->on('course_curriculum_items');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
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
        Schema::dropIfExists('question');
    }
}
