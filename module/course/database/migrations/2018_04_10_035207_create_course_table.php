<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
	        $table->integer('author')->unsigned();
	        $table->foreign('author')->references('id')->on('users');
	        $table->integer('editor')->unsigned()->nullable();
	        $table->foreign('editor')->references('id')->on('users');
	        $table->json('curriculums')->nullable();
	        $table->integer('course_ldp')->unsigned()->nullable();
	        $table->integer('price')->nullable();
            $table->integer('bought')->default(0);
            $table->integer('bought1')->default(0);
            $table->integer('bought2')->default(0);
            $table->integer('bought3')->default(0);
            $table->integer('time')->default(0);
            $table->integer('score')->default(0);
            $table->enum('random', ['active', 'false']);
	        //$table->foreign('price')->references('id')->on('price_tier');
	        $table->enum('status', ['active', 'disable'])->default('disable');
	        $table->string('version')->nullable();
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
        Schema::dropIfExists('course');
    }
}
