<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer')->unsigned();
            $table->foreign('customer')->references('id')->on('users');
            $table->integer('total_price');
            $table->enum('payment_method', ['transfer', 'atm', 'direct', 'phone'])->default('transfer');
            $table->enum('status', ['create', 'done', 'cancel'])->default('create');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
