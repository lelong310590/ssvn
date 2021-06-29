<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->integer('price')->nullable();
            $table->tinyInteger('type');
            $table->enum('status', ['active', 'disable', 'expire'])->default('disable');
            $table->string('name');
            $table->json('apply_with')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
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
        Schema::dropIfExists('sale');
    }
}
