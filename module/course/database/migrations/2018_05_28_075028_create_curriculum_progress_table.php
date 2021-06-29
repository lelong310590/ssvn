<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->integer('curriculum_id')->unsigned();
            $table->foreign('curriculum_id')->references('id')->on('course_curriculum_items');
            $table->integer('student')->unsigned();
            $table->foreign('student')->references('id')->on('users');
            $table->integer('progress')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->json('detail')->nullable();
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
        Schema::dropIfExists('curriculum_progress');
    }
}
