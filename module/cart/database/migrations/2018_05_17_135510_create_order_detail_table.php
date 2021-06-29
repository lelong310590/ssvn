<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users');
            $table->integer('customer')->unsigned();
            $table->integer('price');
            $table->integer('base_price');
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->enum('status', ['create', 'done', 'cancel'])->default('create');
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
        Schema::dropIfExists('order_details');
    }
}
