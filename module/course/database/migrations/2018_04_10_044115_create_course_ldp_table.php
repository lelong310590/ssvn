<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseLdpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_ldp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->integer('classlevel')->unsigned()->nullable();
            $table->foreign('classlevel')->references('id')->on('classlevel');
	        $table->integer('subject')->unsigned()->nullable();
	        $table->foreign('subject')->references('id')->on('subject');
	        $table->integer('level')->unsigned()->nullable();
	        $table->foreign('level')->references('id')->on('level');
	        $table->string('thumbnail')->nullable()->nullable();
	        $table->string('video_promo')->nullable();
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
        Schema::dropIfExists('course_ldp');
    }
}
