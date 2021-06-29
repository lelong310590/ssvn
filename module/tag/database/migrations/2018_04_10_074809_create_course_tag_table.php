<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
	        $table->integer('author')->unsigned();
	        $table->foreign('author')->references('id')->on('users');
            $table->timestamps();
        });
        
        Schema::create('course_tag', function (Blueprint $table) {
	        $table->integer('course_id')->unsigned()->index();
	        $table->integer('tag_id')->unsigned()->index();
	        $table->foreign('course_id')->references('id')->on('course_ldp')->onDelete('cascade');
	        $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
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
        Schema::dropIfExists('course_tag');
    }
}
