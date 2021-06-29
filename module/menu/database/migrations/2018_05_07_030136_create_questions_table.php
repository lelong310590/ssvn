<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('curriculum_item')->unsigned()->nullable();
            $table->foreign('curriculum_item')->references('id')->on('course_curriculum_items');
	        $table->integer('related_lecture')->unsigned()->nullable();
	        $table->foreign('related_lecture')->references('id')->on('course_curriculum_items');
	        $table->text('knowledge_area')->nullable();
	        $table->string('type')->nullable();
	        $table->text('reason')->nullable();
	        $table->integer('owner')->unsigned();
	        $table->foreign('owner')->references('id')->on('users');
	        $table->integer('index')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
