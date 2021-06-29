<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner')->unsigned();
            $table->foreign('owner')->references('id')->on('users');
            $table->integer('lecture_id')->unsigned();
            $table->foreign('lecture_id')->references('id')->on('course_curriculum_items');
            $table->integer('skip')->nullable();
            $table->integer('correct')->nullable();
            $table->integer('wrong')->nullable();
            $table->string('version')->nullable();
            $table->integer('time')->nullable();
            $table->integer('test_time')->nullable();
            $table->integer('score')->nullable();
            $table->longText('question')->nullable();
            $table->longText('detail')->nullable();
            $table->integer('percent_correct')->default(0);
            $table->boolean('expand')->default(false);
            $table->enum('result', ['pass', 'failed'])->default('failed');
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
        Schema::dropIfExists('test_result');
    }
}
