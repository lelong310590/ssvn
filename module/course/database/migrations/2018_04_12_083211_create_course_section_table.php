<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_curriculum_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->string('name')->nullable();
	        $table->string('description')->nullable();
	        $table->integer('index')->default(0);
	        $table->integer('duration')->nullable();
	        $table->enum('type', ['section', 'lecture', 'quiz', 'test'])->default('section');
	        $table->enum('status', ['active', 'disable', 'editing'])->default('disable');
	        $table->enum('preview', ['active', 'disable'])->default('disable');
	        $table->integer('time')->default(0);
	        $table->integer('score')->default(0);
	        $table->integer('version')->default(1);
            $table->enum('random', ['active', 'disable'])->default('disable');
            $table->integer('parent_section')->nullable();
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
        Schema::dropIfExists('course_curriculum_items');
    }
}
