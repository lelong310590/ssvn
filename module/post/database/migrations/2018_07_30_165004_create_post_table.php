<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('author')->unsigned()->nullable();
            $table->foreign('author')->references('id')->on('users')->onDelete('SET NULL');
            $table->enum('post_type', ['post', 'page'])->default('post');
            $table->enum('status', ['active', 'disable'])->default('active');
            $table->string('template')->default('post');
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
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
        Schema::dropIfExists('post');
    }
}
