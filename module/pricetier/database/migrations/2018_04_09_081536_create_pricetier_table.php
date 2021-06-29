<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricetierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_tier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('price');
	        $table->integer('author')->unsigned();
	        $table->foreign('author')->references('id')->on('users');
	        $table->integer('editor')->unsigned()->nullable();
	        $table->foreign('editor')->references('id')->on('users');
	        $table->enum('status', ['active', 'disable'])->default('active');
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
        Schema::dropIfExists('pricetier');
    }
}
