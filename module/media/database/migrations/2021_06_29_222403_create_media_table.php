<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->string('type');
            $table->integer('owner')->unsigned();
            $table->foreign('owner')->references('id')->on('users');
            $table->integer('curriculum_item')->unsigned()->nullable();
            $table->foreign('curriculum_item')->references('id')->on('course_curriculum_items');
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable();
            $table->text('reject_reason')->nullable();
            $table->enum('status', ['active', 'disable', 'processing'])->default('processing');
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
        Schema::dropIfExists('media');
    }
}
