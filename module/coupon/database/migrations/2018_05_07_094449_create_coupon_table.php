<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('course')->unsigned();
            $table->foreign('course')->references('id')->on('course');
            $table->integer('price');
            $table->integer('reamain');
            $table->datetime('deadline');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
            $table->enum('status', ['active', 'disable'])->default('disable');
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
        Schema::dropIfExists('coupon');
    }
}
