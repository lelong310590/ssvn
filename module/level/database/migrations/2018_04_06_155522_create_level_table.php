<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('slug')->unique();
	        $table->string('thumbnail')->nullable();
	        $table->string('seo_title')->nullable();
	        $table->string('seo_keywords')->nullable();
	        $table->string('seo_description')->nullable();
	        $table->integer('author')->unsigned();
	        $table->foreign('author')->references('id')->on('users');
	        $table->integer('editor')->unsigned()->nullable();
	        $table->foreign('editor')->references('id')->on('users');
	        $table->enum('status', ['active', 'disable'])->default('active');
	        $table->enum('featured', ['active', 'disable'])->default('disable');
	        $table->timestamp('published_at')->default(Carbon::now());
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
        Schema::dropIfExists('level');
    }
}
