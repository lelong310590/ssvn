<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name');
	        $table->string('slug')->unique();
	        $table->string('icon');
	        $table->string('seo_title')->nullable();
	        $table->string('seo_keywords')->nullable();
	        $table->string('seo_description')->nullable();
	        $table->integer('author')->unsigned();
	        $table->foreign('author')->references('id')->on('users');
	        $table->integer('editor')->unsigned()->nullable();
	        $table->foreign('editor')->references('id')->on('users');
	        $table->timestamp('published_at')->default(Carbon::now());
            $table->timestamps();
        });
        
        Schema::create('class_subject', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('class_id')->unsigned();
        	$table->foreign('class_id')->references('id')->on('classlevel')->onDelete('cascade');
        	$table->integer('subject_id')->unsigned();
        	$table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
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
        Schema::dropIfExists('subject');
    }
}
